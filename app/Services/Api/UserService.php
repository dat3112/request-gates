<?php

namespace App\Services\Api;

use App\Mail\Sendmail;
use Illuminate\Support\Str;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\PasswordResetRepositoryInterface;
use App\Exceptions\CheckAuthorizationException;
use App\Exceptions\QueryException;
use App\Exceptions\ServerException;
use App\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    protected $passwordResetRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CategoryRepositoryInterface $categoryRepository,
        PasswordResetRepositoryInterface $passwordResetRepository,
        DepartmentRepositoryInterface $departmentRepository,
        RequestService $requestService
    ) {
        $this->userRepository = $userRepository;
        $this->requestService = $requestService;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->departmentRepository = $departmentRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        $currentPage = $params['page'] ?? 1;
        if (!Redis::hexists("user", $currentPage)) {
            $user = $this->userRepository->getColumns(['*'], ['department'])->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')->paginate($params['per_page'] ?? config('constants.PER_PAGE'));
            $currentPage = $user->toArray()['current_page'];
            Redis::hmset("user", $currentPage, json_encode($user));
            Redis::expire("user", config('constants.USER.TIME_CACHE'));
        }
        return json_decode(Redis::hmget("user", $currentPage)['0']);
    }

    public function searchUser($request)
    {
        return $this->userRepository->findUser($request);
    }

    public function findByRoleId($role, $request)
    {
        if (!isset($request['status'])) {
            $request['status'] = null;
        }
        return $this->userRepository->findByRoleId($role, $request);
    }

    public function changePassword($data)
    {
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $data['oldPassword']])) {
            throw new CheckAuthorizationException(config('constants.RESET_PASSWORD.OLD_PASSWORD_ERROR'));
        }

        if ($data['newPassword'] == $data['oldPassword']) {
            throw new CheckAuthorizationException(config('constants.RESET_PASSWORD.PASSWORD_ERROR'));
        }

        $newPassword = [
            'password' => bcrypt($data['newPassword']),
        ];

        $mail = [
            'view' => 'emails.users.resetPassword',
            'title' => config('constants.EMAIL.USER.RESET_PASSWORD'),
            'email' => Auth::user()->email
        ];
        $this->userRepository->find(Auth::user()->id)->update($newPassword);
        Mail::to($mail['email'])
            ->send(new SendMail($mail)); //send notification change password
        if (Mail::failures()) {
            throw new QueryException(config('constants.EMAIL.ERROR'));
        }
        return [
            'message' => config('constants.RESET_PASSWORD.SUCCESS')
        ];
    }

    public function forgotPassword($data)
    {
        $token = trim(json_encode(Str::uuid()), '"');
        $data['token'] = $token;
        $mail = [ // Content Email sending
            'view' => 'emails.users.forgotPassword',
            'title' => config('constants.RESET_PASSWORD.NOTIFICATION'),
            'token' =>  $token,
            'email' => $data['email'],
            'url' => env('APP_URL')
        ];
        $createdAt = $this->passwordResetRepository->findCreateAtByEmail($data);
        if (!$createdAt) { //   Email with the first time forgot password
            $this->passwordResetRepository->store($data);
            //send notification change password
            Mail::to($mail['email'])
                ->send(new SendMail($mail));
            if (Mail::failures()) {
                throw new QueryException(config('constants.EMAIL.ERROR'));
            }
            return [
                'message' => config('constants.RESET_PASSWORD.NOTIFICATION_SENT')
            ];
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->passwordResetRepository->updateByEmail($data); //  Email with the second time forgot password
        Mail::to($mail['email'])
            ->send(new SendMail($mail)); //send notification change password
        if (Mail::failures()) {
            throw new QueryException(config('constants.EMAIL.ERROR'));
        }
        return [
            'message' => config('constants.RESET_PASSWORD.NOTIFICATION_SENT')
        ];
    }

    public function resetPassword($data)
    {
        DB::beginTransaction();
        try {
            //  Get created_at token
            $createdAt = $this->passwordResetRepository->findCreateAtByEmail($data)->updated_at->toArray()['formatted'];
            //  set time life for token (10 minutes)
            $timevalidate = date(
                'Y-m-d H:i:s',
                strtotime(config('constants.RESET_PASSWORD.TIME_LIVE'), strtotime($createdAt))
            );
            $now = date('Y-m-d H:i:s');    //  Time now
            if (strtotime($now) > strtotime($timevalidate)) {
                throw new UnprocessableEntityException(config('constants.RESET_PASSWORD.LINK_ERROR'));
            }

            $mail = [ // Content Email sending
                'view' => 'emails.users.resetPassword',
                'title' => config('constants.RESET_PASSWORD.SUCCESS'),
                'email' => $data['email']
            ];
            $this->passwordResetRepository->updatePassword($data);
            Mail::to($mail['email'])
                ->queue(new SendMail($mail)); //send notification reset password
            $this->passwordResetRepository->deleteResetRepository($data);
            DB::commit();
            return [
                'message' => config('constants.RESET_PASSWORD.SUCCESS')
            ];
        } catch (\Throwable $e) {
            DB::rollback();
            throw new ServerException(config('constants.REQUEST.UPDATE.ERROR'));
        }
    }

    public function updateStatusUser($id)
    {
        $user = $this->userRepository->find($id);
        if (Auth::user()->id == $id) {
            throw new CheckAuthorizationException(config('constants.USER.STATUS_MESSAGE.WARNING'));
        }

        if ($user->role_id == config('constants.ROLE.QLBP')) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.STATUS_QLBP'));
        }

        if ($user->role_id == config('constants.ROLE.ADMIN')) {
            $this->updateStatusRoleAdmin($user);
        }

        if ($user->status == config('constants.USER.STATUS.ACTIVE')) {
            $data['status'] = config('constants.USER.STATUS.IN_ACTIVE');
        } else {
            $data['status'] = config('constants.USER.STATUS.ACTIVE');
        }

        if (!$this->userRepository->find($id)->update($data)) {
            throw new QueryException(config('constants.USER.STATUS_MESSAGE.ERROR'));
        }

        if (Redis::exists('user')) {
            Redis::del('user');
        }
        return [
            'message' => config('constants.USER.STATUS_MESSAGE.SUCCESS'),
        ];
    }

    public function updateStatusRoleAdmin($user)
    {
        //Kiểm tra user có đang tham chiếu tới category nào không
        if (count($this->categoryRepository->findCategoryByUser($user->id)) != 0) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.CATEGORY_ASSIGN'));
        }
        //Kiểm tra user có đang xử lý request nào hay không?
        if (count($this->userRepository->findRequestByUser($user->id)) != 0) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.REQUEST_ASSIGN'));
        }
        //Kiểm tra xem có admin nào hay không?
        if (count($this->userRepository->findAdmin()) <= 1) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.LIMIT_ADMIN'));
        }
    }

    public function createUser($data)
    {
        $id = $data['department_id'];
        $departmentCode = $this->departmentRepository->find($id)->department_code;
        $roleId = $data['role_id'];
        $data['avatar'] = config('constants.USER.AVATAR');
        $data['status'] = config('constants.STATUS.OPEN');
        $isAdminWrongDepartment = $roleId == 1 && $departmentCode != config('constants.DEPARTMENT_CODE.HCNS');
        $isOtherRoleWrongDepartment = $roleId != 1 && $departmentCode == config('constants.DEPARTMENT_CODE.HCNS');
        if ($isAdminWrongDepartment || $isOtherRoleWrongDepartment) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.ROLE_HCNS'));
        }
        $password = $this->createPassword();
        $mail = [
            'view' => 'emails.users.createUser',
            'title' => config('constants.EMAIL.USER.CREATE_USER'),
            'email' => $data['email'],
            'password' =>  $password,
            'url' => env('APP_URL')
        ];
        $department = $this->departmentRepository->find($data['department_id']);
        if ($data['role_id'] == config('constants.ROLE.QLBP')) {
            $this->changeRoleManager($department);
        }
        $data['password'] = bcrypt($password);
        if (Redis::exists('user')) {
            Redis::del('user');
        }
        Mail::to($mail['email'])
            ->send(new SendMail($mail)); //send notification change password
        if (Mail::failures()) {
            throw new QueryException(config('constants.EMAIL.ERROR'));
        }
        $this->userRepository->store($data);
        return [
            'message' => config('constants.USER.CREATE.SUCCESS')
        ];
    }

    public function createPassword()
    {
        $length = config('constants.LENGTH_PASSWORD');
        $characters = config('constants.CHARACTERS');
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }

    public function updateUser($id, $data)
    {
        $user = $this->userRepository->find($id);
        //Lấy ra thông tin phòng ban mới mà user đổi sang
        $department = $this->departmentRepository->find($data['department_id']);
        $dataOldUser = [
            'name' => $user->name,
            'phone' => $user->phone,
            'age' => $user->age,
            'gender' => $user->gender,
            'department_id' => $user->department_id,
            'role_id' => $user->role_id
        ];
        //Kiểm tra xem có thay đổi nào hay không?
        if ($data == $dataOldUser) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.CHANGE'));
        }
        //Kiểm tra khi thay đổi quyền thành Admin có phải HCNS không?
        $isAdmin = $data['role_id'] == config('constants.ROLE.ADMIN');
        $isDepartmentHCNS = $department->department_code == config('constants.DEPARTMENT_CODE.HCNS');
        if ($isAdmin && !$isDepartmentHCNS) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.ROLE_HCNS'));
        }
        //Kiểm tra có thay đổi quyền và phòng ban hay không?
        if ($data['role_id'] != $user->role_id || $data['department_id'] != $user->department_id) {
            $this->changeRoleUser($user, $data, $department);
        }

        if (!$this->userRepository->find($id)->update($data)) {
            throw new QueryException(config('constants.USER.UPDATE.ERROR'));
        }
        if (Redis::exists('user')) {
            Redis::del('user');
        }
        return [
            'message' => config('constants.USER.UPDATE.SUCCESS'),
        ];
    }

    public function changeRoleUser($user, $data, $department)
    {
        $newRole = $data['role_id'];
        $oldRole = $user->role_id;
        //Kiểm tra quyền cũ của user
        switch ($oldRole) {
            case config('constants.ROLE.QLBP'):
                throw new CheckAuthorizationException(config('constants.USER.UPDATE.ROLE_QLBP'));
            case config('constants.ROLE.ADMIN'):
                throw new CheckAuthorizationException(config('constants.USER.UPDATE.ROLE_ADMIN'));
            case config('constants.ROLE.CBNV'):
                $this->checkRoleCbnv($newRole, $department);
                break;
            default:
                throw new QueryException(config('constants.USER.UPDATE.ERROR'));
        }
    }

    public function checkRoleCbnv($newRole, $department)
    {
        $isNewDepartmentHCNS = $department->department_code == config('constants.DEPARTMENT_CODE.HCNS');
        //Nếu đổi từ CBNV sang ADMIN nên phòng ban cũng phải là HCNS
        if ($newRole == config('constants.ROLE.ADMIN') && !$isNewDepartmentHCNS) {
            throw new CheckAuthorizationException(config('constants.USER.UPDATE.ROLE_HCNS'));
        }
        //Nếu đổi từ CBNV sang QLBP thì thay đổi quyền của QLBP cũ
        if ($newRole == config('constants.ROLE.QLBP')) {
            $this->changeRoleManager($department);
        }
    }

    public function changeRoleManager($newDepartment)
    {
        $dataRoleUser['role_id'] = config('constants.ROLE.CBNV');
        $userManager = $this->userRepository->findManager($newDepartment->id);
        if (!$this->userRepository->find($userManager[0]->id)->update($dataRoleUser)) {
            throw new QueryException(config('constants.USER.UPDATE.ERROR'));
        }
    }
    
    public function callbackGoogle($request)
    {
        $accessToken = $request->access_token;
        $linkGetUserInfor = config('constants.LOGIN.GOOGLE.LINK_GET_USER_INFOR');
        $userAccess = file_get_contents($linkGetUserInfor . $accessToken);
        $emailAccess = json_decode($userAccess)->email;
        $user = $this->userRepository->findByEmail($emailAccess);
        if (empty($user)) {
            throw new CheckAuthorizationException(config('constants.LOGIN.GOOGLE.ERROR'));
        }
        if ($user->status != config('constants.USER.STATUS.ACTIVE')) {
            throw new CheckAuthorizationException(config('constants.LOGIN.STATUS'));
        }
        $tokenAccess = JWTAuth::fromUser($user);
        return [
            'token' => $tokenAccess
        ];
    }
    public function settingAccount($data)
    {
        $id = Auth::user()->id;
        $avatarRequest =  $data['avatar'];
        $nameAvatarRequest = $data['avatar']->getClientOriginalName();
        // avatar's name save in images folder
        $data['avatar'] = time() . '.' . $avatarRequest->getClientOriginalExtension();
        $isOldPhone = $data['phone'] == Auth::user()->phone;
        $isOldAvatar =  $nameAvatarRequest == Auth::user()->avatar;
        $isOldName = $data['name'] == Auth::user()->name;
        if ($isOldPhone && $isOldAvatar && $isOldName) {
            throw new QueryException(config('constants.USER.UPDATE.CHANGE'));
        }
        // move image into images folder
        $avatarRequest->move(public_path('images'), $data['avatar']);
        // return asset($path);
        if (Redis::exists('user')) {
            Redis::del('user');
        }
        try {
            $this->userRepository->find($id)->update($data);
            DB::commit();
            return [
                'message' => config('constants.USER.UPDATE.SUCCESS'),
            ];
        } catch (\Throwable $e) {
            DB::rollback();
            throw new QueryException(config('constants.USER.UPDATE.ERROR'));
        }
    }
}

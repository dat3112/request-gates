<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = new User();
        $users->name = 'Hoàng Thái Vũ';
        $users->email = 'vuht@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654321';
        $users->avatar = '';
        $users->age = '20';
        $users->gender = '1';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Nguyễn Thị Xoan';
        $users->email = 'xoannt@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654322';
        $users->avatar = '';
        $users->age = '21';
        $users->gender = '1';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Nguyễn Ngọc Huân';
        $users->email = 'huann@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654323';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '1';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Đồng Tiến Đạt';
        $users->email = 'datdt@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654324';
        $users->avatar = '';
        $users->age = '20';
        $users->gender = '1';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Nguyễn Hoàng Nam';
        $users->email = 'namnh@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654325';
        $users->avatar = '';
        $users->age = '20';
        $users->gender = '2';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Nguyễn Hoàng Lân';
        $users->email = 'lannh@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654326';
        $users->avatar = '';
        $users->age = '20';
        $users->gender = '1';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Đỗ Viết Trí';
        $users->email = 'tridv@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '1';
        $users->department_id = '1';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Quản lý HBF';
        $users->email = 'qlhbf@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '2';
        $users->department_id = '2';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Quản lý HB1';
        $users->email = 'qlhb1@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '2';
        $users->department_id = '3';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Quản lý HB2';
        $users->email = 'qlhb2@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '2';
        $users->department_id = '4';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Quản lý HB3';
        $users->email = 'qlhb3@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '2';
        $users->department_id = '5';
        $users->status = 1;
        $users->save();

        $users = new User();
        $users->name = 'Quản lý HB4';
        $users->email = 'qlhb4@hblab.vn';
        $users->password = bcrypt('123456');
        $users->phone = '0987654327';
        $users->avatar = '';
        $users->age = '22';
        $users->gender = '2';
        $users->role_id = '2';
        $users->department_id = '6';
        $users->status = 1;
        $users->save();
    }
}

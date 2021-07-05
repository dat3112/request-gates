<?php

return [
    'RESET_PASSWORD' => [
        'OLD_PASSWORD_ERROR' => 'Mật khẩu cũ không đúng!',
        'RE_PASSWORD_ERROR' => 'Mật khẩu nhập lại không đúng!',
        'PASSWORD_ERROR' => 'Mật khẩu mới trùng với mật khẩu cũ!',
        'SUCCESS' => 'Đã thay đổi mật khẩu!',
        'ERROR' => 'Thay đổi mật khẩu thất bại!',
        'NOTIFICATION' => 'Thông báo thay đổi mật khẩu!',
        'NOTIFICATION_SENT' => 'Đã gửi thông báo thay đổi mật khẩu!',
        'LINK_ERROR' => 'Link hết hạn!',
        'TIME_LIVE' => '+20 minutes'
    ],
    'LOGIN' => [
        'ERROR' => 'Email hoặc mật khẩu không chính xác!',
        'EMAIL' => 'Không được để trống!',
        'EMAILERROR' => 'Không hợp lệ!',
        'PASSWORD' => 'Không được để trống!',
        'STATUS' => 'Tài khoản đã bị khoá!',
        'GOOGLE' => [
            'LINK_GET_USER_INFOR' => 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=',
            'ERROR' => 'Không có quyền truy cập!'
        ]
    ],
    'LOGOUT' => [
        'SUCCESS' => 'Đã đăng xuất!'
    ],
    'REQUEST' => [
        'STORE' => [
            'SUCCESS' => 'Tạo mới request thành công!',
            'ERROR' => 'Tạo mới request thất bại!',
        ],
        'UPDATE' => [
            'CHANGE' => 'Không có sự thay đổi nào!',
            'SUCCESS' => 'Chỉnh sửa thành công!',
            'ERROR' => 'Chỉnh sửa thất bại!',
            'WARNING' => 'Bạn không thể chỉnh sửa!',
            'LONG_TEXT' => 'Quá dài để hiển thị!'
        ],
        'DELETE' => [
            'SUCCESS' => 'Xoá thành công!',
            'ERROR' => 'Xoá thất bại!',
            'WARNING' => 'Bạn không thể xoá!',
        ],
        'APPROVE' => [
            'SUCCESS' => 'Approve thành công!',
            'ERROR' => 'Approve thất bại!',
            'WARNING' => 'Bạn không thể approve!'
        ],
        'REJECT' => [
            'SUCCESS' => 'Reject thành công!',
            'ERROR' => 'Reject thất bại!',
            'WARNING' => 'Bạn không thể reject!'
        ]
    ],
    'USER' => [
        'UPDATE' => [
            'CHANGE' => 'Không có sự thay đổi nào!',
            'SUCCESS' => 'Chỉnh sửa thành công!',
            'ERROR' => 'Chỉnh sửa thất bại!',
            'WARNING' => 'Bạn không thể chỉnh sửa!',
            'ROLE_QLBP' => 'Không thể thay đổi quyền của quản lý bộ phận!',
            'ROLE_HCNS' => 'Phòng ban không phù hợp!',
            'ROLE_ADMIN' => 'Không thể thay đổi quyền của Admin!',
            'CATEGORY_ASSIGN' => 'Nhân viên đang chịu trách nhiệm cho 1 danh mục khác!',
            'REQUEST_ASSIGN' => 'Nhân viên đang phụ trách 1 request chưa hoàn thành!',
            'LIMIT_ADMIN' => 'Admin không được trống!',
            'STATUS_QLBP' => 'Quản lý bộ phận không thể in-active',
        ],
        'CREATE' => [
            'SUCCESS' => 'Thêm user thành công!',
            'ERROR' => 'Thêm user thất bại!'
        ],
        'STATUS_MESSAGE' => [
            'SUCCESS' => 'Thao tác thành công!',
            'ERROR' => 'Thao tác thất bại!',
            'WARNING' => 'Thao tác không thành công!',
        ],
        'STATUS' => [
            'ACTIVE' => 1,
            'IN_ACTIVE' => 2
        ],
        'GENDER' => [
            'MALE' => 1,
            'FEMALE' => 2
        ],
        'TIME_CACHE' => 30, // 30 second
        'PER_PAGE' => 10,
        'AVATAR' => 'avatar1.png'
    ],
    'CATEGORY' => [
        'STORE' => [
            'SUCCESS' => 'Thêm mới thành công!',
        ],
        'UPDATE' => [
            'SUCCESS' => 'Chỉnh sửa thành công!',
        ],
        'STATUS' => [
            'ENABLE' => 1,
            'DISABLE' => 2
        ],
        'TIME_CACHE' => 60, // 60 second
    ],
    'DEPARTMENT' => [
        'STORE' => [
            'SUCCESS' => 'Thêm mới thành công!',
        ],
        'UPDATE' => [
            'SUCCESS' => 'Chỉnh sửa thành công!',
        ],
        'STATUS' => [
            'ENABLE' => 1,
            'DISABLE' => 2
        ],
        'VALIDATE' => [
            'MAX' => 'Tối đa 50 kí tự',
            'MIN' => 'Tối thiểu 5 kí tự',
        ],
        'TIME_CACHE' => 60, // 60 second
    ],
    'EMAIL' => [
        'NAME' => 'REQUEST GATE',
        'STORE' => [
            'TITLE' => 'Request GATE new request created at ' . date("d/m/Y"),
        ],
        'UPDATE' => [
            'TITLE' => 'Request GATE update a request at ' . date("d/m/Y"),
        ],
        'USER' => [
            'RESET_PASSWORD' => 'Thông báo thay đổi mật khẩu!',
            'CREATE_USER' => 'Tài khoản của bạn đã được khởi tạo!'
        ],
        'DELETE' => [
            'TITLE' => 'Request GATE delete a request at ' . date("d/m/Y"),
        ],
        'APPROVE_REQUEST' => 'Request GATE approve a request at ' . date("d/m/Y"),
        'REJECT_REQUEST' => 'Request GATE reject a request at ' . date("d/m/Y"),
        'ERROR' => 'Gửi mail không thành công!',
        'REQUEST_DUE' => 'Request sắp đến hạn!'
    ],
    'VALIDATE' => [
        'STRING' => 'Dữ liệu nhập vào phải là string!',
        'REQUIRED' => 'Dữ liệu không được trống!',
        'DATE_FORMAT' => 'Dữ liệu nhập phải là định dạng: Năm-Tháng-Ngày!',
        'INTEGER' => 'Dữ liệu nhập vào phải là số nguyên!',
        'EXISTS' => 'Dữ liệu không có trong hệ thống!',
        'IN' => [
            'STATUS' => 'Dữ liệu phải là enable hoặc disable!',
            'GENDER' => 'Dữ liệu phải là nam hoặc nữ!',
            'ROLE' => 'Dữ liệu không phù hợp!'
        ],
        'DIGITS' => [
            'PHONE' => 'Dữ liệu phải là số và có 10 kí tự!'
        ],
        'UNIQUE' => [
            'EMAIL' => 'Email này đã tồn tại!',
            'PHONE' => 'Số điện thoại này đã tồn tại!',
            'DEPARTMENT_CODE' => 'Mã phòng ban này đã tồn tại!',
        ],
        'AGE' => 'Bắt buộc phải đủ 18 tuổi trở lên!',
        'IMAGE' => [
            'MIMES' => [
                'MESSAGE' => 'Định dạng ảnh phải là jpeg, png, jpg, gif, svg',
                'TYPE' => array('jpeg', 'png', 'jpg', 'gif', 'svg'),
            ],
        ]
    ],
    'HISTORY_REQUEST' => [
        'CREATE_REQUEST' => 'Đã cập nhật request mới!',
        'UPDATE_REQUEST' => 'Đã chỉnh sửa request!',
        'DELETE_REQUEST' => 'Đã xoá request!',
        'APPROVE_REQUEST' => 'Đã tiếp nhận request!',
        'REJECT_REQUEST' => 'Đã từ chối request!',
    ],
    'COMMENT' => [
        'STORE' => [
            'SUCCESS' => 'Comment thành công!',
            'WARNING' => 'Bạn không thể comment!',
        ],
        'APPROVE_REQUEST' => 'Đã tiếp nhận yêu cầu!',
        'REJECT_REQUEST' => 'Đã từ chối yêu cầu!',
    ],
    'ROLE' => [
        'ADMIN' => 1,
        'QLBP' => 2,
        'CBNV' => 3
    ],
    'STATUS' => [
        'OPEN' => 1,
        'PROGRESS' => 2,
        'CLOSE' => 3,
    ],
    'PRIORITY' => [
        'LOW' => 1,
        'MEDIUM' => 2,
        'HIGH' => 3,
        'CRITICAL' => 4,
    ],
    'PER_PAGE' => 10,
    'SUCCESS' => 'Thao tác thành công!',
    'ERROR' => 'Thao tác thất bại!',
    'CHECKROLE' => [
        'NOT_PERMISSION' => 'Bạn không có quyền truy cập!',
    ],
    'LENGTH_PASSWORD' => 8,
    'CHARACTERS' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
    'DEPARTMENT_CODE' => [
        'HCNS' => 'HCNS',
    ],
];

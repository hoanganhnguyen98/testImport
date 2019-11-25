<?php

return [
    'title' => [
        'home' => 'Nhà hàng NINJA',
    ],
    'header' => [
        'home' => 'Trang chủ',
        'about' => 'Giới thiệu',
        'login' => 'Đăng nhập',
        'logout' => 'Đăng xuất',
        'register' => 'Tạo tài khoản',
        'language' => 'Language',
    ],
    'sidebar' => [
        'header' => 'Nhà hàng Ninja',
        'management-header' => 'Quản lý',
        'general-settings' => 'Cài đặt chung',
        'account' => [
            'header' => 'Tài khoản',
            'create' => 'Tạo mới tài khoản',
            'list' => 'Danh sách tài khoản',
        ],
        'food' => [
            'header' => 'Món ăn',
            'create' => 'Tạo mới món ăn',
            'list' => 'Danh sách món ăn',
        ],
        'bill' => [
            'header' => 'Hóa đơn',
            'create' => 'Tạo mới hóa đơn',
            'list' => 'Danh sách hóa đơn',
        ],
        'profile' => [
            'header' => 'Hồ sơ',
            'detail' => 'Thông tin tài khoản',
            'change-password' => 'Đổi mật khẩu',
        ],
    ],
    'login' => [
        'title' => 'Đăng nhập',
        'header' => 'Đăng nhập',
        'email' => 'Tài khoản',
        'password' => 'Mật khẩu',
        'button' => 'Đăng nhập',
        'forget' => 'Quên mật khẩu',
    ],
    'role' => [
        'employee' => 'Nhân viên',
        'receptionist' => 'Lễ tân',
        'waiter' => 'Bồi bàn',
        'kitchen_manager' => 'Quản lý bếp',
        'admin' => 'Quản trị viên',
    ],
    'suggest' => 'nhấn để chọn',
    'type' => [
        'salad' => 'Gỏi',
        'rice' => 'Cơm',
        'cake' => 'Bánh',
        'meat' => 'Thịt',
        'seafood' => 'Hải sản',
        'noodles' => 'Bún phở',
        'curry' => 'Cà ri',
        'sushi' => 'Sushi',
        'pizza' => 'Pizza',
        'kimchi' => 'Kimchi',
        'soup' => 'Canh',
        'appetizer' => 'Món khai vị',
        'dessert' => 'Món tráng miệng',
    ],
    'create' => [
        'account' => [
            'title' => 'Tạo tài khoản',
            'header' => 'Tạo tài khoản',
            'name' => 'Họ tên',
            'image' => 'Ảnh',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'area' => 'Khu vực',
            'role' => 'Vai trò',
            'email' => 'Tài khoản (Thư điện tử)',
            'button' => 'Tạo mới',
        ],
        'food' => [
            'title' => 'Tạo mới món ăn',
            'header' => 'Tạo mới món ăn',
            'name' => 'Tên',
            'image' => 'Hình ảnh',
            'type' => 'Loại',
            'source' => 'Nguồn gốc',
            'material' => 'Nguyên liệu',
            'price' => 'Giá',
            'button' => 'Tạo mới',
        ],
        'bill' => [
            'title' => 'Tạo mới hóa đơn',
            'header' => 'Tạo mới hóa đơn',
            'table' => 'Bàn số',
            'name' => 'Tên khách hàng',
            'address' =>  'Địa chỉ',
            'street' => '...đường',
            'district' => '...quận/huyện',
            'city' => '...tỉnh/thành phố',
            'phone' => 'Số điện thoại',
            'email' => 'Địa chỉ email',
            'button' => 'Tạo mới',
        ],
    ],
    'list' => [
        'account' => [
            'title' => 'Danh sách tài khoản',
            'header' => 'Danh sách tài khoản',
            'name' => 'Họ tên',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'role' => 'Vai trò',
            'button' => [
                'back' => 'Quay lại danh sách',
                'detail' => 'Chi tiết',
                'change_image' => 'Đổi ảnh',
                'edit' => 'Sửa',
                'delete' => 'Xóa',
                'cancel' => 'Hủy',
            ],
            'modal_title' => 'Xóa tài khoản này?',
        ],
        'food' => [
            'title' => 'Danh sách món ăn',
            'header' => 'Danh sách món ăn',
            'image' => 'Hình ảnh',
            'name' => 'Tên món ăn',
            'type' => 'Loại',
            'source' => 'Nguồn gốc',
            'material' => 'Nguyên liệu',
            'vnd_price' => 'Giá (VND)',
            'usd_price' => 'Giá (USD)',
            'button' => [
                'detail' => 'Chi tiết',
                'edit' => 'Sửa',
                'delete' => 'Xóa',
            ],
        ],
    ],   
    'change-password' => [
        'title' => 'Thay đổi mật khẩu',
        'header' => 'Thay đổi mật khẩu',
        'email' => 'Tài khoản (Thư điện tử)',
        'old_password' => 'Mật khẩu hiện tại',
        'new_password' => 'Mật khẩu mới',
        'repassword' => 'Xác nhận mật khẩu mới',
        'button' => 'Thay đổi mật khẩu',
    ],
    'reset_password' => [
        'title' => 'Đặt lại mật khẩu',
        'header' => 'Đặt lại mật khẩu',
        'email_address' => 'Địa chỉ thư điện tử',
        'button' => 'Gửi yêu cầu',
    ],
    'reset_form' => [
        'title' => 'Đặt lại mật khẩu',
        'header' => 'Đặt lại mật khẩu',
        'email' => 'Tài khoản',
        'password' => 'Mật khẩu mới',
        'repassword' => 'Xác nhận mật khẩu mới',
        'button' => 'Đặt lại',
    ],
    'first_login' => [
        'title' => 'Đăng nhập lần đầu',
        'header' => 'Thay đổi mật khẩu lần đăng nhập đầu tiên',
        'email' => 'Tài khoản',
        'password' => 'Mật khẩu',
        'repassword' => 'Xác nhận mật khẩu',
        'button' => 'Thay đổi',
    ],
];

<?php

return [
    'name' => 'Smart App Downloader',

    'settings' => [
        'title' => 'Tải ứng dụng',
        'description' => 'Một liên kết /download thông minh đưa mỗi khách truy cập đến đúng kho ứng dụng hoặc bộ cài.',
    ],

    'sections' => [
        'options' => 'Tùy chọn',
        'links_mobile' => 'Liên kết di động',
        'links_desktop' => 'Liên kết máy tính',
        'files' => 'Tải lên bộ cài (dùng thay cho liên kết)',
        'branding' => 'Trang lựa chọn',
    ],

    'platforms' => [
        'ios' => 'iOS',
        'android' => 'Android',
        'huawei' => 'Huawei AppGallery',
        'amazon' => 'Amazon Appstore',
        'windows' => 'Windows',
        'microsoft' => 'Microsoft Store',
        'macos' => 'macOS',
        'linux' => 'Linux',
    ],

    'link_label' => 'Liên kết :platform',

    'info' => [
        'your_link' => 'Liên kết tải của bạn. Chia sẻ ở bất kỳ đâu.',
        'copy' => 'Sao chép',
        'copied' => 'Đã sao chép',
        'open' => 'Mở',
        'test_as' => 'Thử với:',
        'no_links' => 'Thêm một liên kết bên dưới để bắt đầu thử.',
        'preview_design' => 'Xem trước giao diện:',
        'qr_download' => 'Tải mã QR',
        'stats_title' => 'lượt truy cập trong 30 ngày qua',
        'stats_empty' => 'Chưa có lượt truy cập.',
        'stats_chooser' => 'Trang lựa chọn',
    ],

    'enabled' => 'Tự động chuyển hướng khách truy cập',
    'track' => 'Đếm lượt truy cập',

    'designs' => [
        'minimal' => 'Tối giản',
        'hero' => 'Nổi bật',
        'split' => 'Chia đôi',
        'tiles' => 'Dạng thẻ',
    ],
    'design' => 'Giao diện trang',
    'accent_color' => 'Màu nhấn',

    'app_name' => 'Tên ứng dụng',
    'tagline' => 'Giới thiệu một dòng',
    'icon' => 'Biểu tượng ứng dụng',
    'deep_link' => 'Liên kết "Mở trong ứng dụng"',

    'upload' => [
        'none' => 'Chưa có tệp. Chấp nhận :types',
        'choose' => 'Tải lên',
        'replace' => 'Thay thế',
        'remove' => 'Xóa',
        'confirm_remove' => 'Xóa tệp này?',
        'bad_type' => 'Nền tảng này chỉ cho phép tệp :types.',
        'out_of_order' => 'Quá trình tải lên bị gián đoạn. Vui lòng thử lại.',
        'failed' => 'Tải lên thất bại. Vui lòng thử lại.',
        'too_big' => 'Tệp lớn hơn 2 GB.',
    ],

    'page_title' => 'Tải ứng dụng',
    'get_app' => 'Tải :name',
    'page_description' => 'Chọn nền tảng của bạn để tải ứng dụng.',
    'no_links_configured' => 'Liên kết tải xuống chưa sẵn sàng. Vui lòng quay lại sau.',
    'other_platforms' => 'Nền tảng khác',
    'download_for' => 'Tải cho :platform',
    'download' => 'Tải xuống',
    'for_you' => 'Cho thiết bị của bạn',
    'open_app' => 'Đã cài đặt? Mở ứng dụng',

    'invalid_deep_link' => 'Nhập liên kết ứng dụng hợp lệ như myapp://open hoặc URL https.',
];

<?php

return [
    'name' => 'Smart App Downloader',

    'settings' => [
        'title' => 'تنزيل التطبيق',
        'description' => 'رابط /download ذكي واحد يوجّه كل زائر إلى المتجر أو ملف التثبيت المناسب.',
    ],

    'sections' => [
        'options' => 'الخيارات',
        'links_mobile' => 'روابط الجوال',
        'links_desktop' => 'روابط الحاسوب',
        'files' => 'رفع ملفات التثبيت (تُستخدم بدلًا من الرابط)',
        'branding' => 'صفحة الاختيار',
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

    'link_label' => 'رابط :platform',

    'info' => [
        'your_link' => 'رابط التنزيل الخاص بك. شاركه في أي مكان.',
        'copy' => 'نسخ',
        'copied' => 'تم النسخ',
        'open' => 'فتح',
        'test_as' => 'جرّب كـ:',
        'no_links' => 'أضف رابطًا أدناه لبدء التجربة.',
        'preview_design' => 'معاينة التصميم:',
        'qr_download' => 'تنزيل رمز QR',
        'stats_title' => 'زيارة خلال آخر 30 يومًا',
        'stats_empty' => 'لا توجد زيارات بعد.',
        'stats_chooser' => 'صفحة الاختيار',
    ],

    'enabled' => 'إعادة توجيه الزوار تلقائيًا',
    'track' => 'عدّ الزيارات',

    'designs' => [
        'minimal' => 'بسيط',
        'hero' => 'بارز',
        'split' => 'مقسّم',
        'tiles' => 'بطاقات',
    ],
    'design' => 'تصميم الصفحة',
    'accent_color' => 'لون التمييز',

    'app_name' => 'اسم التطبيق',
    'tagline' => 'وصف من سطر واحد',
    'icon' => 'أيقونة التطبيق',
    'deep_link' => 'رابط "الفتح في التطبيق"',

    'upload' => [
        'none' => 'لا يوجد ملف. الصيغ المقبولة: :types',
        'choose' => 'رفع',
        'replace' => 'استبدال',
        'remove' => 'حذف',
        'confirm_remove' => 'هل تريد حذف هذا الملف؟',
        'bad_type' => 'يُسمح فقط بملفات :types لهذه المنصة.',
        'out_of_order' => 'انقطع الرفع. يرجى المحاولة مرة أخرى.',
        'failed' => 'فشل الرفع. يرجى المحاولة مرة أخرى.',
        'too_big' => 'حجم الملف أكبر من 2 غيغابايت.',
    ],

    'page_title' => 'حمّل التطبيق',
    'get_app' => 'حمّل :name',
    'page_description' => 'اختر منصتك لتنزيل التطبيق.',
    'no_links_configured' => 'روابط التنزيل غير متاحة بعد. يرجى العودة قريبًا.',
    'other_platforms' => 'منصات أخرى',
    'download_for' => 'تنزيل لـ :platform',
    'download' => 'تنزيل',
    'for_you' => 'لجهازك',
    'open_app' => 'هل ثبّتّه بالفعل؟ افتح التطبيق',

    'invalid_deep_link' => 'أدخل رابط تطبيق صالحًا مثل myapp://open أو عنوان https.',
];

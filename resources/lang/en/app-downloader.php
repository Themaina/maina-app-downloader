<?php

return [
    'name' => 'Smart App Downloader',

    'settings' => [
        'title' => 'App Downloader',
        'description' => 'One smart /download link that sends each visitor to the right app store or installer.',
    ],

    'sections' => [
        'options' => 'Options',
        'links_mobile' => 'Mobile links',
        'links_desktop' => 'Desktop links',
        'files' => 'Upload installers (used instead of a link)',
        'branding' => 'Chooser page',
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

    'link_label' => ':platform link',

    'info' => [
        'your_link' => 'Your download link. Share it anywhere.',
        'copy' => 'Copy',
        'copied' => 'Copied',
        'open' => 'Open',
        'test_as' => 'Test as:',
        'no_links' => 'Add a link below to start testing.',
        'preview_design' => 'Preview design:',
        'qr_download' => 'Download QR',
        'stats_title' => 'visits in the last 30 days',
        'stats_empty' => 'No visits yet.',
        'stats_chooser' => 'Chooser page',
    ],

    'enabled' => 'Auto-redirect visitors',
    'track' => 'Count visits',

    'designs' => [
        'minimal' => 'Minimal',
        'hero' => 'Hero',
        'split' => 'Split',
        'tiles' => 'Tiles',
    ],
    'design' => 'Page design',
    'accent_color' => 'Accent color',

    'app_name' => 'App name',
    'tagline' => 'One-line pitch',
    'icon' => 'App icon',
    'deep_link' => '"Open in app" link',

    'upload' => [
        'none' => 'No file. Accepts :types',
        'choose' => 'Upload',
        'replace' => 'Replace',
        'remove' => 'Remove',
        'confirm_remove' => 'Remove this file?',
        'bad_type' => 'Only :types files are allowed for this platform.',
        'out_of_order' => 'The upload was interrupted. Please try again.',
        'failed' => 'The upload failed. Please try again.',
        'too_big' => 'File is larger than 2 GB.',
    ],

    'page_title' => 'Get the App',
    'get_app' => 'Get :name',
    'page_description' => 'Choose your platform to download the app.',
    'no_links_configured' => 'Download links are not available yet. Please check back soon.',
    'other_platforms' => 'Other platforms',
    'download_for' => 'Download for :platform',
    'download' => 'Download',
    'for_you' => 'For your device',
    'open_app' => 'Already installed? Open the app',

    'invalid_deep_link' => 'Enter a valid app link such as myapp://open or an https URL.',
];

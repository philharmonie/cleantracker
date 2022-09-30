<?php

$splash_icons = glob(public_path('icons/apple-splash*.jpg'));
$splash_icons = array_reduce($splash_icons, function ($carry, $item) {
    $carry[str_replace('-', 'x', explode('splash-', pathinfo($item, PATHINFO_FILENAME))[1])] = $item;
    return $carry;
}, []);


$data = [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'Clean Tracker'),
        'short_name' => 'Clean',
        'start_url' => '/',
        'background_color' => '#F3F4F6',
        'theme_color' => '#9B1C1C',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => '#F3F4F6',
        'icons' => [
            '180x180' => [
                'path' => '/icons/apple-icon-180.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => $splash_icons
    ]
];


return $data;

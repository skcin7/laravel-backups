<?php


return [

	'path' => storage_path() . '/dumps/',

	'mysql' => [
		'dump_command_path' => '',
		'restore_command_path' => '',
	],

	's3' => [
		'path' => ''
	],

    'dropbox' => [
        'accessToken' => env('DROPBOX_TOKEN', ''),
        'appSecret' => env('DROPBOX_SECRET', ''),
        'prefix' => env('DROPBOX_PREFIX', '')
    ],

    'encrypt' => [
        'key' => env('ENCRYPT_KEY', '')
    ],

    'compress' => true,
];


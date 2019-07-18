# Laravel Backups

Package to manage database backups in a Laravel project. Easily integrates with Dropbox and AWS S3.

> This package is based on [wladmonax/laravel-db-backup](https://github.com/wladmonax/laravel-db-backup) so credit to them for their great work.

### Table of Contents

- [Installation](#installation)
- [Contribution Guidelines](#contribution-guidelines)
- [Maintainers](#maintainers)
- [License](#license)

### Installation

Run Composer command: `composer require skcin7/laravel-backups`

### Configuration

Copy the config file into your project by running
```
php artisan vendor:publish
```

This will generate a config file like this
```php
return [

    // add a backup folder in the app/database/ or your dump folder
    'path' => app_path() . '/database/backup/',

    // add the path to the restore and backup command of mysql
    // this exemple is if your are using MAMP server on a mac
    // on windows: 'C:\\...\\mysql\\bin\\'
    // on linux: '/usr/bin/'
    // trailing slash is required
    'mysql' => [
        'dump_command_path' => '/Applications/MAMP/Library/bin/',
        'restore_command_path' => '/Applications/MAMP/Library/bin/',
    ],

    // s3 settings
    's3' => [
        'path'  => 'your/s3/dump/folder'
    ]
    
    //dropbox settings
    'dropbox' => [
        'accessToken' => DROPBOX_ACCESS_TOKEN,
        'appSecret' => DROPBOX_APP_SECRET,
        'prefix' => DROPBOX_PREFIX, //this is name of your dropbox folder
    ],
    
    //encrypt settings
    'encrypt' => [
        'key' => ENCRYPT_KEY
    ],
    // Use GZIP compression
    'compress' => false,
];

```

__All settings are optional and have reasonable default values.__




## Usage

#### Backup
Creates a dump file in `app/storage/dumps`
```sh
$ php artisan db:backup
```

###### Use specific database
```sh
$ php artisan db:backup --database=mysql
```
###### Need ecnrypt db
```sh
$ php artisan db:backup --encrypt
```
###### Save dump to dropbox
```sh
$ php artisan db:backup --dropbox
```
###### You can merge options like this
```sh
$ php artisan db:backup --dropbox --encrypt
```

###### Upload to AWS S3
```sh
$ php artisan db:backup --upload-s3 your-bucket
```

You can use the `--keep-only-s3` option if you don't want to keep a local copy of the SQL dump.

Uses the [aws/aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) package which needs to be [configured](https://github.com/aws/aws-sdk-php-laravel#configuration).                                                                                                                                                                
Uses the [spatie/flysystem-dropbox](https://github.com/spatie/flysystem-dropbox) package.                                                                                                                                                                                                   

#### Restore
Paths are relative to the app/storage/dumps folder.

###### Restore a dump
```sh
$ php artisan db:restore dump.sql
```

###### Restore from last backup dump
```sh
$ php artisan db:restore --last-dump
```

###### Restore from Dropbox
```sh
$ php artisan db:restore --dropbox-dump=filename.sql
```

###### Restore from Dropbox last dump
```sh
$ php artisan db:restore --dropbox-last-dump
```

###### List dumps
```sh
$ php artisan db:restore
```
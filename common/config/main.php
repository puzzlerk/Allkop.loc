<?php
return [
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'controllerMap' => [
        'geo-manage' => \common\widgets\TemplateOfElement\controllers\GeoController::class,
        'image' => \common\widgets\ImageManager\controllers\ImageController::class,
    ],
    'components' => [
        'fieldsManage' => \common\widgets\TemplateOfElement\components\FieldsManage::class,
        'commentsManage' => \common\widgets\Comment\components\CommentManage::class,
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        /*'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 10,
            ]
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 11,
            ]
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 12,
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'class'      => \common\components\I18n\I18n::className(),
            'languages' => ['en'],
            'format'     => 'db',
            'sourcePath' => [
                __DIR__ . '/../../frontend',
                __DIR__ . '/../../backend',
                __DIR__ . '/../../common',
                __DIR__ . '/../../console',
            ],
            'messagePath' => __DIR__  . '/../../messages',
            'translations' => [
                'app' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
                '*' => [
                    'class'           => 'common\components\TranslateContent',
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
            ],
        ],
        'youTubeData' => [
            'class' => \phpnt\youtube\components\YouTubeData::class,
            'key' => 'AIzaSyBAk-zc4vmAmy732nU0SR7cw78RP_TYB6M',
        ],
    ],
];

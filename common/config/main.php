<?php
return [
    'language'=>'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cache1'=>[
            'class' => 'yii\caching\ApcCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'Systemconfig' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'forceTranslation'=>true,
                    'fileMap' => [
                        'Systemconfig' => 'Systemconfig.php',
                    ],
                ],
            ],
        ],
    ],
];

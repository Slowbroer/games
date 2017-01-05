<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
//            'dsn' => 'sqlsrv:Server=localhost;Database=games',
//            'dsn'=>'dblib:host=192.168.137.120:1433;dbname=games',
//            'dsn'=>'dblib:host=192.168.1.105:1433;dbname=games',
            'dsn'=>'dblib:host=222.186.15.227:1433;dbname=games',
            'username' => 'sa',
//            'password' => 'mj19930115',
            'password' => 'gamemugua',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',  //每种邮箱的host配置不一样
                'username' => '1573975217@qq.com',
                'password' => 'mj4436549213',
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['1573975217@qq.com'=>'admin']
            ],
        ],
    ],
];

<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'dsn' => 'sqlsrv:Server=localhost;Database=games2',
            'username' => 'sa',
            'password' => 'mj19930115',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

<?php
return [
    'id' => 'app-backend-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=lojadeinformatica', // Altere para o seu banco de testes
            'username' => 'root', // Substitua pelo seu usuário do banco de dados
            'password' => '',     // Substitua pela sua senha
            'charset' => 'utf8',
        ],
        'assetManager' => [
            'basePath' => '@backend/web/assets',
            'baseUrl' => '@web/assets',
        ],
    ],
];

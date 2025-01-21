<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],

    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'as access' => [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin', 'funcionario'], // Apenas admin e funcionário têm acesso ao backend
                ],
            ],
            'denyCallback' => function () {
                return Yii::$app->response->redirect(['site/login']); // Redireciona para o login em caso de negação
            },
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule','controller' => [
                    'api/user',
                    'api/fatura',
                    'api/artigos',
                    'api/iva',
                    'api/categorias',
                    'api/carrinho',
                    'api/matematica',
                ],
                    'pluralize' => false,
                    'extraPatterns' => [



                        //user
                        'GET login' => 'login',
                        'PUT dados'=>'puteditardados',




                        //artigos
                        'GET get-all-artigos' => 'get-all-artigos',
                        'GET descricoes' => 'getdescricoes',
                        'GET preco/{referencia}' => 'getprecoporreferencia',
                        'DELETE referencia/{referencia}' => 'deleteporreferencia',
                        'PUT referencia/{referencia}' => 'putprecoporreferencia',
                        'POST adicionarartigo' => 'postartigo',
                        'PUT editarartigo/{id}' => 'putartigo',

                        //categoria
                        'POST postcategoria' => 'postcategoria',
                        'PUT editarcategoria/{id}'=>'putcategoria',
                        'DELETE eliminarcategoria/{id}'=>'deletecategoria',

                        //iva
                        'POST adicionariva' => 'postiva',
                        'PUT editariva/{id}'=> 'putpercentagemporid',
                        'DELETE eliminariva/{id}'=>'deleteiva',

                        //carrinho
                        'GET carrinhoativo'=>'carrinhoativo',
                        'POST adicionarcarrinho' =>'postcarrinho',
                        'DELETE eliminarcarrinho/{id}' =>'deletecarrinho',
                        'PUT finalizar/{id}' =>'putfinalizarcarrinho',

                        //linhas carrinho
                        'GET linhas/{id}'=>'getlinhasporcarrinho',
                        'POST adicionarlinha' =>'postlinha',
                        'DELETE eliminarlinha/{id}'=>'deletelinha',
                        'PUT linha/{id}'=>'putquantidadeporlinha',




                        //fatura
                        'GET {id}/view' => 'view',

                        'GET {user_id}/user' => 'faturas-usuario',
                        'POST faturas/{id}' => 'postfaturaporcarrinho',
                        'PUT anularfaturas/{id}' => 'putanularfatura',



                        'GET raizdois' =>'raizdois',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{referencia}' => '<referencia:\\w+>', //[a-zA-Z0-9_] 1 ou + vezes (char)
                        '{user_id}' => '<user_id:\\d+>',


                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];

<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 19.08.2018
 * Time: 8:43
 */

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Yii2 CMS - Frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'bm' => \common\widgets\Basket\controllers\BmController::class,
        'auth' => \common\widgets\oAuth\controllers\AuthController::class,
        'rating' => \common\widgets\Rating\controllers\RatingController::class,
        'comment' => \common\widgets\Comment\controllers\CommentController::class,
    ],
    'modules' => [
        'control' => [
            'class' => 'frontend\modules\control\Module',
        ],
        'geo' => [
            'class' => 'frontend\modules\geo\Module',
        ],
        'login' => [
            'class' => 'frontend\modules\login\Module',
        ],
        'signup' => [
            'class' => 'frontend\modules\signup\Module',
        ],
        'profile' => [
            'class' => 'frontend\modules\profile\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => \common\models\forms\UserForm::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['login/default/index'],
            'on afterLogin' => function($event) {
                \common\models\forms\UserForm::afterLogin($event->identity->id);
            }
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => \common\components\extend\UrlManager::class,
            'languages' => ['ru', 'en'],
            'langLabels' => [
                'ru' => 'Русский',
                'en' => 'English',
            ],
            'defaultCity' => '524901',    // Москва
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'ignoreLanguageUrlPatterns' => [
                '#^auth/#' => '#^auth/#',
                //'#^geo/#' => '#^geo/#',
                '#^geo-manage/#' => '#^geo-manage/#',
            ],
        ],
        'userAccess' => [
            'class' => \common\components\other\UserAccess::class,
        ],
        'emailTemplate' => [
            'class' => \common\components\other\GenerateEmailTemplate::class,
        ],
    ],
    'params' => $params,
];

<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 31.08.2018
 * Time: 6:02
 */

namespace backend\modules\geo\controllers;

use common\models\forms\GeoCountryForm;
use Yii;
use common\models\search\GeoCountrySearch;
use yii\base\InlineAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CountryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            /* @var $action InlineAction */
                            if (!Yii::$app->user->can($action->controller->module->id . '/' . $action->controller->id . '/' . $action->id)) {
                                throw new ForbiddenHttpException(Yii::t('app', 'У вас нет доступа к этой странице'));
                            };
                            return true;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Отображение стран
     * @return string
     */
    public function actionIndex()
    {
        $allGeoCountrySearch = new GeoCountrySearch();
        $dataProviderGeoCountry = $allGeoCountrySearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'allGeoCountrySearch' => $allGeoCountrySearch,
            'dataProviderGeoCountry' => $dataProviderGeoCountry,
        ]);
    }
}
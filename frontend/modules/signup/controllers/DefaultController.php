<?php

namespace frontend\modules\signup\controllers;

use common\models\Constants;
use common\models\forms\EmailConfirm;
use common\models\forms\SignupForm;
use common\models\forms\UserForm;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Default controller for the `signup` module
 */
class DefaultController extends Controller
{
    // информация о текущей странице
    public $page;

    public function init()
    {
        parent::init();
        $this->page = (new \yii\db\Query())
            ->select(['*'])
            ->from('document')
            ->where(['alias' => $this->module->id])
            ->one();
    }

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
                        'roles' => Yii::$app->userAccess->getUserAccess($this->page['access'])
                    ],
                    [
                        'allow' => true,
                        'actions' =>['confirm-email']
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws ErrorException
     */
    public function beforeAction($action)
    {
        try {
            parent::beforeAction($action);
        } catch (BadRequestHttpException $e) {
            Yii::$app->errorHandler->logException($e);
            throw new ErrorException($e->getMessage());
        }

        return true;
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        // Уже авторизированных отправляем на домашнюю страницу
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $modelSignupForm = new SignupForm();

        if ($modelSignupForm->load(Yii::$app->request->post()) && $modelSignupForm->save()) {
            Yii::$app->session->set(
                'message',
                [
                    'type'      => 'success',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => ' '.Yii::t('app', 'Ссылка с подтверждением регистрации отправлена на Email.'),
                ]
            );
            return $this->goHome();
        }

        if (!Yii::$app->request->isPjax || !Yii::$app->request->isAjax) {
            return $this->goHome();
        }

        if ($modelSignupForm->errors) {
            return $this->renderAjax('@frontend/views/templates/signup/_signup-form', [
                'page' => $this->page,
                'modelSignupForm' => $modelSignupForm,
            ]);
        }

        return $this->renderAjax('@frontend/views/templates/signup/signup', [
            'page' => $this->page,
            'modelSignupForm' => $modelSignupForm,
        ]);
    }

    /**
     * Подтверждение аккаунта с помощью
     * электронной почты
     * @param $token - токен подтверждения, высылаемый почтой
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionConfirm($token)
    {
        try {
            $model = new EmailConfirm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user_id = $model->confirmEmail()) {
            // Авторизируемся при успешном подтверждении
            Yii::$app->session->set(
                'message',
                [
                    'type'      => 'success',
                    'icon'      => 'glyphicon glyphicon-ok',
                    'message'   => Yii::t('app', 'Email успешно подтвержден.'),
                ]
            );
            Yii::$app->user->login(UserForm::findIdentity($user_id));
        }

        return $this->goHome();
    }

    /**
     * Форма подтверждение электронной почты, если при регистрации через соц. сеть он отсутствовал
     * @param $user_id - id пользователя
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionConfirmEmail($user_id)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = '/main';

        $modelSignupForm = SignupForm::findOne([
            'id' => $user_id,
            'status' => Constants::STATUS_WAIT
        ]);
        $modelSignupForm->email = null;

        if (!$modelSignupForm) {
            Yii::$app->session->set(
                'message',
                [
                    'type'      => 'danger',
                    'icon'      => 'glyphicon glyphicon-ban',
                    'message'   => Yii::t('app', 'Пользователь не найден.'),
                ]
            );
        };

        if ($modelSignupForm->load(Yii::$app->request->post()) && $modelSignupForm->save()) {
            Yii::$app->session->set(
                'message',
                [
                    'type'      => 'success',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => ' '.Yii::t('app', 'Ссылка с подтверждением регистрации отправлена на Email.'),
                ]
            );
            return $this->goHome();
        }

        return $this->render('@frontend/views/templates/signup/confirm-email', [
            'page' => $this->page,
            'modelSignupForm' => $modelSignupForm,
        ]);
    }
}

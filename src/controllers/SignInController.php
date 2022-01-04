<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:20 AM
 */

namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\models\LoginForm;
use Yii;
use yii\web\Request;


/**
 * Class SignInController
 * @package vasadibt\materialdashboard\controllers
 */
class SignInController extends BaseController
{
    /**
     * @var string
     */
    public $defaultAction = 'login';

    public $verbs = [
        'logout' => ['post']
    ];

    public $access = [
        [
            'actions' => ['login'],
            'allow' => true,
        ],
        [
            'actions' => ['logout'],
            'roles' => ['@'],
            'allow' => true,
        ]
    ];

    public $form = LoginForm::class;

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin(Request $request)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var LoginForm $model */
        $model = Yii::createObject($this->form);

        if ($model->load($request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}

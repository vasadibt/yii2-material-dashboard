<?php

namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\models\ExtendedIdentityInterface;
use vasadibt\materialdashboard\models\LockForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;

/**
 * Class LockController
 * @package vasadibt\materialdashboard\controllers
 */
class LockController extends BaseController
{
    const LOCK_SESSION_KEY = 'locked-user';

    /**
     * @var string
     */
    public $defaultAction = 'login';

    public $access = [
        [
            'actions' => ['login'],
            'allow' => true,
        ],
        [
            'actions' => ['lock'],
            'roles' => ['@'],
            'allow' => true,
        ],
    ];

    public $form = LockForm::class;

    /**
     * Logout action.
     *
     * @param Request $request
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin(Request $request)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findLockedUser();
        if ($user === null) {
            return $this->goHome();
        }

        /** @var LockForm $model */
        $model = Yii::createObject($this->form, [$user]);

        if ($model->load($request->post()) && $model->unlock()) {
            return $this->goBack();
        }

        return $this->render('login', compact('model'));
    }

    /**
     * User lock action.
     *
     * @return \yii\web\Response
     */
    public function actionLock()
    {
        $userId = Yii::$app->user->id;
        Yii::$app->user->logout();
        Yii::$app->session->set(static::LOCK_SESSION_KEY, $userId);
        return $this->redirect(['login']);
    }

    /**
     * @return ExtendedIdentityInterface|null
     */
    public function findLockedUser()
    {
        if ($userId = Yii::$app->session->get(static::LOCK_SESSION_KEY)) {
            /** @var ExtendedIdentityInterface $userClass */
            $userClass = Yii::$app->user->identityClass;
            /** @var ExtendedIdentityInterface $user */
            $user = $userClass::findIdentity($userId);
            return $user;
        }

        return null;
    }
}
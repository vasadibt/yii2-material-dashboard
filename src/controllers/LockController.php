<?php

namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\models\ExtendedIdentityInterface;
use vasadibt\materialdashboard\models\LockForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class LockController
 * @package vasadibt\materialdashboard\controllers
 */
class LockController extends Controller
{
    const LOCK_SESSION_KEY = 'locked-user';

    /**
     * @var string
     */
    public $defaultAction = 'login';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['lock'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findLockedUser();
        if ($user === null) {
            return $this->goHome();
        }

        $model = new LockForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->unlock()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * User lock action.
     *
     * @return string
     */
    public function actionLock()
    {
        $userId = Yii::$app->user->id;
        Yii::$app->user->logout();
        Yii::$app->session->open();
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
<?php

namespace vasadibt\materialdashboard\commands;

use vasadibt\materialdashboard\models\ExtendedIdentityInterface;
use Yii;
use yii\base\Model;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\helpers\Console;

/**
 * Class UserController
 * @package vasadibt\materialdashboard\commands
 */
class UserController extends Controller
{
    public $userClass = \common\models\User::class;

    public $color = true;

    /**
     *
     */
    public function actionIndex()
    {
        $this->stdout(Yii::t('materialdashboard', 'User has been created') . "!\n", Console::FG_GREEN);
    }

    /**
     * @param $email
     * @param $password
     * @param null $username
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate($email, $password, $username = null)
    {
        /** @var ActiveRecordInterface|ExtendedIdentityInterface|Model $user */

        $user = Yii::createObject([
            'class' => $this->userClass,
            'email' => $email,
            'username' => $username ?? $email,
            'password' => $password,
        ]);

        if ($user->save()) {
            $this->stdout(Yii::t('materialdashboard', 'User has been created') . "!\n", Console::FG_GREEN);
        } else {
            $this->stdout(Yii::t('materialdashboard', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }

    /**
     * @param $email
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($email)
    {
        if ($this->confirm(Yii::t('materialdashboard', 'Are you sure? Deleted user can not be restored'))) {

            /** @var ActiveRecord $userClass */
            $userClass = $this->userClass;

            $user = $userClass::find()->where(['email' => $email])->one();

            if ($user === null) {
                $this->stdout(Yii::t('materialdashboard', 'User is not found') . "\n", Console::FG_RED);
            } else {
                if ($user->delete()) {
                    $this->stdout(Yii::t('materialdashboard', 'User has been deleted') . "\n", Console::FG_GREEN);
                } else {
                    $this->stdout(Yii::t('materialdashboard', 'Error occurred while deleting user') . "\n", Console::FG_RED);
                }
            }
        }
    }

    /**
     * @param $email
     * @param $password
     */
    public function actionSetPassword($email, $password)
    {
        /** @var ActiveRecord $userClass */
        $userClass = $this->userClass;

        /** @var ExtendedIdentityInterface $user */
        $user = $userClass::find()->where(['email' => $email])->one();

        if ($user === null) {
            $this->stdout(Yii::t('materialdashboard', 'User is not found') . "\n", Console::FG_RED);
        } else {
            if ($user->setPassword($password)) {
                $this->stdout(Yii::t('materialdashboard', 'Password has been changed') . "\n", Console::FG_GREEN);
            } else {
                $this->stdout(Yii::t('materialdashboard', 'Error occurred while changing password') . "\n", Console::FG_RED);
            }
        }
    }
}
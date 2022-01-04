<?php


namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\models\ChangePasswordForm;
use vasadibt\materialdashboard\models\ProfileForm;
use Yii;
use yii\web\Controller;
use yii\web\Request;

/**
 * Class ProfileController
 * @package vasadibt\materialdashboard\controllers
 */
class ProfileController extends BaseController
{
    public $profileForm = ProfileForm::class;
    public $changePasswordForm = ChangePasswordForm::class;

    /**
     * @param Request $request
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(Request $request)
    {
        /** @var ProfileForm $profile */
        /** @var ChangePasswordForm $changePassword */

        $profile = Yii::createObject($this->profileForm);
        $changePassword = Yii::createObject($this->changePasswordForm);

        if ($request->isPost) {
            if ($profile->load($request->post())) {
                if ($profile->change()) {
                    Yii::$app->session->setFlash('success', Yii::t('materialdashboard', 'Successfully saved!'));
                    return $this->refresh();
                }
            } elseif ($changePassword->load($request->post())) {
                if ($changePassword->change()) {
                    Yii::$app->session->setFlash('success', Yii::t('materialdashboard', 'Successfully saved!'));
                    return $this->refresh();
                }
                $changePassword->oldPassword = '';
                $changePassword->newPassword = '';
                $changePassword->retypePassword = '';
            }
        }

        return $this->render('index', compact('profile', 'changePassword'));
    }

}
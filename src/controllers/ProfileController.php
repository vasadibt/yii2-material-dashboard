<?php


namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\models\ChangePasswordForm;
use vasadibt\materialdashboard\models\ProfileForm;
use Yii;
use yii\web\Controller;

/**
 * Class ProfileController
 * @package vasadibt\materialdashboard\controllers
 */
class ProfileController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $profile = new ProfileForm();
        $changePassword = new ChangePasswordForm();

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
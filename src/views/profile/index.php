<?php

use vasadibt\materialdashboard\models\ChangePasswordForm;
use vasadibt\materialdashboard\models\ProfileForm;
use vasadibt\materialdashboard\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ProfileForm $profile */
/** @var ChangePasswordForm $changePassword */

$this->title = Yii::t('materialdashboard', 'Edit profile');

?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-info text-center">
                <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([]) ?>
                <?= $form->errorSummary($profile) ?>
                <?= $form->field($profile, 'username') ?>
                <?= $form->field($profile, 'email') ?>
                <div class="mt-4 text-center">
                    <?= Html::submitButton(Yii::t('materialdashboard', 'Save changes'), ['class' => 'btn btn-success btn-lg']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-primary text-center">
                <h4 class="card-title"><?= Yii::t('materialdashboard', 'Change password') ?></h4>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([]) ?>
                <?= $form->errorSummary($changePassword) ?>
                <?= $form->field($changePassword, 'oldPassword')->passwordInput() ?>
                <?= $form->field($changePassword, 'newPassword')->passwordInput() ?>
                <?= $form->field($changePassword, 'retypePassword')->passwordInput() ?>
                <div class="mt-4 text-center">
                    <?= Html::submitButton(Yii::t('materialdashboard', 'Save changes'), ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>

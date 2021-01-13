<?php

use common\models\User;
use vasadibt\materialdashboard\models\UserSearch;
use vasadibt\materialdashboard\widgets\BootstrapSelectPicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var User $model */
/** @var ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->widget(BootstrapSelectPicker::class, [
        'items' => UserSearch::statusLabels(),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('materialdashboard', 'Save'), ['class' => 'btn btn-fill btn-success']) ?>
        <?= Html::a(Yii::t('materialdashboard', 'Back'), ['/' . Yii::$app->controller->uniqueId], ['class' => 'btn btn-fill btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

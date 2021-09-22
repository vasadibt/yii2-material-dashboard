<?php

/** @var \yii\web\View $this */
/** @var string $newButtonLabel */
/** @var string $grid */
?>
<div class="card">
    <div class="card-header card-header-icon">
        <div class="card-icon d-none d-sm-block"><?= Yii::$app->material->helperHtml::icon('assignment') ?></div>
        <h4 class="card-title d-inline-block"><?= Yii::$app->material->helperHtml::encode($this->title) ?></h4>
        <div class="float-right mt-1"><?= Yii::$app->material->helperButton::new($newButtonLabel) ?></div>
    </div>
    <div class="card-body">
        <?= $grid ?>
    </div>
</div>

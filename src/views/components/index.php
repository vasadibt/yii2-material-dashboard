<?php

use vasadibt\materialdashboard\helpers\Html;
use yii\base\Model;

/** @var \yii\web\View $this */
/** @var string $newButtonLabel */
/** @var string $grid */
/** @var Model $model */

?>
<div class="card">
    <div class="card-header card-header-icon">
        <div class="card-icon d-none d-sm-block"><?= Html::icon('assignment') ?></div>
        <h4 class="card-title d-inline-block"><?= Html::encode($this->title) ?></h4>
        <div class="float-right mt-1"><?= Yii::$app->material->create($model) ?></div>
    </div>
    <div class="card-body">
        <?= $grid ?>
    </div>
</div>

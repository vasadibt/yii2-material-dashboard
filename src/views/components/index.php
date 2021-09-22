<?php

use vasadibt\materialdashboard\grid\Helper;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $newButtonLabel */
/** @var string $grid */
?>
<div class="card">
    <div class="card-header card-header-icon">
        <div class="card-icon d-none d-sm-block"><?= Helper::icon('assignment') ?></div>
        <h4 class="card-title d-inline-block"><?= Html::encode($this->title) ?></h4>
        <div class="float-right mt-1"><?= Helper::newButton($newButtonLabel) ?></div>
    </div>
    <div class="card-body">
        <?= $grid ?>
    </div>
</div>

<?php

use vasadibt\materialdashboard\grid\Helper;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $form */
/** @var string $class */

?>
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-header card-header-icon">
                <div class="card-icon d-none d-sm-block"><?= Helper::icon('assignment') ?></div>
                <h4 class="card-title d-inline-block"><?= Html::encode($this->title) ?></h4>
                <div class="float-right"><?= Helper::backButton() ?></div>
            </div>
            <div class="card-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>
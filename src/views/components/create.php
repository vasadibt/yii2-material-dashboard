<?php

/** @var \yii\web\View $this */
/** @var string $form */
/** @var string $class */

?>
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-header card-header-icon">
                <div class="card-icon d-none d-sm-block"><?= \vasadibt\materialdashboard\helpers\Html::icon('assignment') ?></div>
                <h4 class="card-title d-inline-block"><?= \vasadibt\materialdashboard\helpers\Html::encode($this->title) ?></h4>
                <div class="float-right"><?= Yii::$app->material->back() ?></div>
            </div>
            <div class="card-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>
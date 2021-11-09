<?php

use vasadibt\materialdashboard\helpers\Html;

/** @var yii\web\View $this */
/** @var \yii\db\ActiveRecordInterface $model */
/** @var string $form */

?>
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-header card-header-icon">
                <div class="card-icon d-none d-sm-block"><?= Html::icon('assignment') ?></div>
                <h4 class="card-title d-inline-block"><?= Html::encode($this->title) ?></h4>
                <div class="float-right">
                    <?= Yii::$app->material->delete($model) ?>
                    <?= Yii::$app->material->back() ?>
                </div>
            </div>
            <div class="card-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>

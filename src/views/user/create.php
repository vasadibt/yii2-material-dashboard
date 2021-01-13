<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var \common\models\User $model */

$this->title = Yii::t('materialdashboard', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('materialdashboard', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-create">
    <div class="card">
        <div class="card-header card-header-icon card-header-success">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title "><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', compact('model')) ?>
        </div>
    </div>
</div>

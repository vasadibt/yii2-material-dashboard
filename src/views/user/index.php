<?php

use vasadibt\materialdashboard\models\UserSearch;
use vasadibt\materialdashboard\widgets\BootstrapSelectPicker;
use yii\helpers\Html;
use vasadibt\materialdashboard\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var UserSearch $searchModel */

$this->title = Yii::t('materialdashboard', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="card">
        <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title "><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">

            <?php Pjax::begin(); ?>

            <div class="btn-group">
                <?= Html::a(Yii::t('materialdashboard', 'Create new {modelName}', ['modelName' => Yii::t('materialdashboard', 'User')]), ['create'], [
                    'class' => 'btn btn-sm btn-success',
                    'data-pjax' => 0,
                ]) ?>
                <?= Html::a(Yii::t('materialdashboard', 'Reset filters'), [''], ['class' => 'btn btn-sm btn-warning']) ?>
            </div>

            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $searchModel->getDataProvider(),
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-hover table-bordered'],
                    'pager' => ['class' => 'vasadibt\materialdashboard\widgets\LinkPager'],
                    'columns' => [
                        ['class' => 'vasadibt\materialdashboard\grid\SerialColumn'],
                        ['attribute' => 'username'],
                        [
                            'attribute' => 'email',
                            'format' => 'email',
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                $labels = UserSearch::statusLabels();
                                return array_key_exists($model->status, $labels) ? $labels[$model->status] : null;
                            },
                            'filterWidget' => [
                                'class' => BootstrapSelectPicker::class,
                                'prompt' => Yii::t('materialdashboard', 'All'),
                                'items' => UserSearch::statusLabels(),
                            ],
                        ],
                        [
                            'class' => 'vasadibt\materialdashboard\grid\ActionColumn',
                            'template' => '<div class="btn-group">{update}{delete}</div>',
                        ],
                    ],
                ]); ?>
            </div>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
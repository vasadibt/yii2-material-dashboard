<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$modelName = Inflector::camel2words(StringHelper::basename($generator->modelClass));
echo "<?php\n";
?>

use yii\helpers\Html;
use vasadibt\materialdashboard\grid\GridView;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->searchModelClass, '\\') ?> $searchModel */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="card">
        <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title "><?= "<?= " ?>Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">

            <?= "<?php " ?>Pjax::begin(); ?>

            <div class="btn-group">
<?php if($generator->enableI18N): ?>
                <?= "<?= " ?>Html::a(Yii::t('<?= $generator->messageCategory ?>', 'Create new {modelName}', ['modelName' => Yii::t('<?= $generator->messageCategory ?>', '<?= $modelName ?>')]), ['create'], [
                    'class' => 'btn btn-sm btn-success',
                    'data-pjax' => 0,
                ]) ?>
<?php else: ?>
                <?= "<?= " ?>Html::a('Create new <?= $modelName ?>', ['create'], [
                    'class' => 'btn btn-sm btn-success',
                    'data-pjax' => 0,
                ]) ?>
<?php endif ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Reset filters') ?>, [''], ['class' => 'btn btn-sm btn-warning']) ?>
            </div>

            <div class="table-responsive">
                <?= "<?= " ?>GridView::widget([
                    'dataProvider' => $searchModel->getDataProvider(),
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-hover table-bordered'],
                    'pager' => ['class' => 'vasadibt\materialdashboard\widgets\LinkPager'],
                    'columns' => [
                        ['class' => 'vasadibt\materialdashboard\grid\SerialColumn'],
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->name == 'id') continue; ?>
<?php if(($format = $generator->generateColumnFormat($column)) === 'text'): ?>
                        ['attribute' => '<?= $column->name ?>'],
<?php else: ?>
                        [
                            'attribute' => '<?= $column->name ?>',
                            'format' => '<?= $generator->generateColumnFormat($column) ?>',
                        ],
<?php endif ?>
<?php endforeach; ?>
                        [
                            'class' => 'vasadibt\materialdashboard\grid\ActionColumn',
                            'template' => '<div class="btn-group">{update}{delete}</div>',
                        ],
                    ],
                ]); ?>
            </div>

            <?= "<?php " ?>Pjax::end(); ?>

        </div>
    </div>
</div>
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

use vasadibt\materialdashboard\grid\GridView;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->searchModelClass, '\\') ?> $searchModel */

$this->params['breadcrumbs'][] = ($this->title = $searchModel::titleList());

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <?= '<?= ' ?>$this->render('@app/views/components/index', [
        'newButtonLabel' => 'Új ' . $searchModel::title(),
        'grid' => GridView::widget([
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'vasadibt\materialdashboard\grid\ActionColumn'],
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->name == 'id' || $column->name == 'TABLE_ID') continue; ?>
<?php if(($format = $generator->generateColumnFormat($column)) === 'text'): ?>
                [
                    'class' => 'vasadibt\materialdashboard\grid\DataColumn',
                    'attribute' => '<?= $column->name ?>',
                ],
<?php else: ?>
                [
                    'class' => 'vasadibt\materialdashboard\grid\DataColumn',
                    'attribute' => '<?= $column->name ?>',
                    'format' => '<?= $generator->generateColumnFormat($column) ?>',
                ],
<?php endif ?>
<?php endforeach; ?>
            ],
        ]),
    ]) ?>
</div>
<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->gridViewClass ?>;
use <?= $generator->buttonCreateWidgetClass ?>;
use <?= $generator->cardWidgetClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel */

$this->params['breadcrumbs'][] = ($this->title = $searchModel::titleList());

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <?= '<?= ' ?><?= StringHelper::basename($generator->cardWidgetClass) ?>::widget([
        'icon' => 'assignment',
        'title' => $this->title,
        'buttons' => <?= StringHelper::basename($generator->buttonCreateWidgetClass) ?>::widget(['searchModel' => $searchModel]),
        'body' => <?= StringHelper::basename($generator->gridViewClass) ?>::widget([
            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'vasadibt\materialdashboard\grid\CheckboxColumn'],
                //['class' => 'vasadibt\materialdashboard\grid\SerialColumn'],
                ['class' => 'vasadibt\materialdashboard\grid\ActionColumn'],
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey || in_array($column->name, $generator->skipGridFields)) continue; ?>
                [
                    'attribute' => '<?= $column->name ?>',
<?php if(($format = $generator->generateColumnFormat($column)) === 'text'): ?>
                    'format' => '<?= $generator->generateColumnFormat($column) ?>',
<?php endif ?>
                ],
<?php endforeach; ?>
            ],
        ]),
    ]) ?>
</div>
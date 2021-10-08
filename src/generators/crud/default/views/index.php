<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->gridViewClass ?>;
use <?= $generator->htmlHelperClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel */

$this->params['breadcrumbs'][] = ($this->title = Yii::$app->material->modelTitleList($searchModel));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <?= '<?= ' ?>$this->render('@app/views/components/index', [
        'newButtonLabel' => 'Új ' . Yii::$app->material->modelTitle($searchModel),
        'grid' => <?= StringHelper::basename($generator->gridViewClass) ?>::widget([
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'vasadibt\materialdashboard\grid\ActionColumn'],
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey || in_array($column->name, $generator->skipGridFields)) continue; ?>
<?php if(($format = $generator->generateColumnFormat($column)) === 'text'): ?>
                [
                    'attribute' => '<?= $column->name ?>',
                ],
<?php else: ?>
                [
                    'attribute' => '<?= $column->name ?>',
                    'format' => '<?= $generator->generateColumnFormat($column) ?>',
                ],
<?php endif ?>
<?php endforeach; ?>
            ],
        ]),
    ]) ?>
</div>
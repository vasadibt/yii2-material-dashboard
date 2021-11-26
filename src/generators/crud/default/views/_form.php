<?php

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

use yii\helpers\StringHelper;

echo "<?php\n";
?>

use <?= $generator->formBuilderClass ?>;
use <?= $generator->htmlHelperClass ?>;
use <?= $generator->activeFormClass ?>;
use <?= $generator->buttonSubmitWidgetClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

?>
<div class="crud-model-form">
    <?= '<?php ' ?>$form = <?= StringHelper::basename($generator->activeFormClass) ?>::begin(['type' => <?= StringHelper::basename($generator->activeFormClass) ?>::TYPE_HORIZONTAL, 'options' => ['class' => 'warn-lose-changes']]) ?>
    <?= '<?= ' ?><?= StringHelper::basename($generator->formBuilderClass) ?>::widget([
        'form' => $form,
        'model' => $model,
        'attributes' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey || in_array($column->name, $generator->skipFormFields)) continue; ?>
            '<?= $column->name ?>' => [
<?php if ($generator->isForeignColumn($column) && ($table = $generator->getForeignTableSchema($column))): ?>
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \vasadibt\materialdashboard\widgets\SelectPicker<?= $column->allowNull ? 'Promted' : '' ?>::class,
                'options' => [
                    'items' => <?= $generator->getModelClass($table) ?>::collect()->pluck('<?= $generator->getTableNameAttribute($table) ?>', '<?= $table->primaryKey[0] ?>'),
                ],
<?php elseif ($generator->isEnum($column)): ?>
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \vasadibt\materialdashboard\widgets\SelectPicker<?= $column->allowNull ? 'Promted' : '' ?>::class,
                'options' => [
                    'items' => <?= $generator->modelClass ?>::<?= $generator->getEnumFunction($column)?>(),
                ],
<?php elseif ($column->dbType == 'datetime'): ?>
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \vasadibt\materialdashboard\widgets\DateTimePicker::class,
<?php elseif ($column->dbType == 'date'): ?>
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \vasadibt\materialdashboard\widgets\DatePicker::class,
<?php elseif ($column->dbType == 'tinyint(1)'): ?>
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \vasadibt\materialdashboard\widgets\BooleanPicker::class,
<?php else: ?>
                'type' => Form::INPUT_TEXT
<?php endif ?>
            ],
<?php endforeach; ?>
        ],
        'contentAfter' => Html::tag('div', <?= StringHelper::basename($generator->buttonSubmitWidgetClass) ?>::widget(['model' => $model]), ['class' => 'd-flex justify-content-center']),
    ]) ?>
    <?= '<?php ' ?><?= StringHelper::basename($generator->activeFormClass) ?>::end() ?>
</div>
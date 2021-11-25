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
    <?= '<?php ' ?>$form = <?= StringHelper::basename($generator->activeFormClass) ?>::begin(['options' => ['class' => 'warn-lose-changes']]) ?>
    <?= '<?= ' ?><?= StringHelper::basename($generator->formBuilderClass) ?>::widget([
        'form' => $form,
        'model' => $model,
        'attributes' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey || in_array($column->name, $generator->skipFormFields)) continue; ?>
            '<?= $column->name ?>' => ['type' => <?= $generator->generateFormFormat($column) ?>],
<?php endforeach; ?>
        ],
        'contentAfter' => Html::tag('div', <?= StringHelper::basename($generator->buttonSubmitWidgetClass) ?>::widget(['model' => $model]), ['class' => 'd-flex justify-content-center']),
    ]) ?>
    <?= '<?php ' ?><?= StringHelper::basename($generator->activeFormClass) ?>::end() ?>
</div>
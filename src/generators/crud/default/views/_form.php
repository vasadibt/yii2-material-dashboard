<?php

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

use yii\helpers\StringHelper;

echo "<?php\n";
?>

use <?= $generator->formBuilderClass ?>;
use <?= $generator->htmlHelperClass ?>;
use <?= $generator->activeFormClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

?>
<div class="crud-model-form">
    <?= '<?php ' ?>$form = <?= StringHelper::basename($generator->activeFormClass) ?>::begin([
        'options' => ['class' => 'warn-lose-changes'],
        'type' => <?= StringHelper::basename($generator->activeFormClass) ?>::TYPE_HORIZONTAL,
        'fieldConfig' => ['labelSpan' => 3, 'wrapperOptions' => ['class' => 'form-group']],
    ]) ?>
    <?= '<?= ' ?><?= StringHelper::basename($generator->formBuilderClass) ?>::widget([
        'form' => $form,
        'model' => $model,
        'attributes' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey || in_array($column->name, $generator->skipFormFields)) continue; ?>
            '<?= $column->name ?>' => ['type' => <?= $generator->generateFormFormat($column) ?>],
<?php endforeach; ?>
        ],
        'contentAfter' => Html::tag('div', Yii::$app->material->helperButton::submit($model), ['class' => 'd-flex justify-content-center']),
    ]) ?>
    <?= '<?php ' ?><?= StringHelper::basename($generator->activeFormClass) ?>::end() ?>
</div>
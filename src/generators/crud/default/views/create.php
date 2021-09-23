<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->formBuilderClass ?>;
use <?= $generator->htmlHelperClass ?>;
use <?= $generator->activeFormClass ?>;

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->modelClass, '\\') ?> $model */

$this->params['breadcrumbs'][] = ['label' => Yii::$app->material->modelTitleList($model), 'url' => ['index']];
$this->params['breadcrumbs'][] = ($this->title = sprintf('Új %s létrehozása', Yii::$app->material->modelTitle($model)));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?= '<?= ' ?>$this->render('@app/views/components/create', [
        'form' => ActiveForm::widget([
            'options' => ['class' => 'warn-lose-changes'],
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'fieldConfig' => ['labelSpan' => 3, 'wrapperOptions' => ['class' => 'form-group']],
            'contentWidget' => [
                'class' => Form::class,
                'model' => $model,
                'columns' => 1,
                'attributes' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
<?php if($column->isPrimaryKey) continue; ?>
                    '<?= $column->name ?>' => ['type' => Form::INPUT_TEXT],
<?php endforeach; ?>
                ],
                'contentAfter' => Html::tag('div', Yii::$app->material->helperButton::submit($model), ['class' => 'd-flex justify-content-center']),
            ]
        ])
    ]) ?>
</div>

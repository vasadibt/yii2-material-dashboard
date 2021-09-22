<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use <?= $generator->htmlHelperClass ?>;
use <?= $generator->activeFormClass ?>;

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var \yii\widgets\ActiveForm $form */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'options' => ['class' => 'warn-lose-changes'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3 col-form-label',
                'offset' => 'offset-sm-3',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

<?php foreach ($generator->getColumnNames() as $attribute): ?>
<?php if (in_array($attribute, $safeAttributes)): ?>
    <?= "<?= " . $generator->generateActiveField($attribute) ?> ?>
<?php endif; ?>
<?php endforeach; ?>

    <div class="form-group">
        <?= "<?= " ?>$model->isNewRecord ? '' : Html::a('Törlés', ['delete', 'id' => $model->primaryKey], [
            'class' => 'btn btn-danger',
            'data-confirm' =>  'Biztos törölni szeretnéd ezt a tételt?',
            'data-method' => 'post',
        ]) ?>
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? 'Létrehozás' : 'Módosítás', ['class' => 'btn btn-fill btn-success pull-right']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>

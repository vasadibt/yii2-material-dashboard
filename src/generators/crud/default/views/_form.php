<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var \yii\widgets\ActiveForm $form */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute): ?>
<?php if (in_array($attribute, $safeAttributes)): ?>
    <?= "<?= " . $generator->generateActiveField($attribute) ?> ?>
<?php endif; ?>
<?php endforeach; ?>

    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-fill btn-success']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Back') ?>, ['/' . Yii::$app->controller->uniqueId], ['class' => 'btn btn-fill btn-warning']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>

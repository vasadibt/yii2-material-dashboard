<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->buttonBackWidgetClass ?>;
use <?= $generator->buttonDeleteWidgetClass ?>;
use <?= $generator->cardWidgetClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

$this->params['breadcrumbs'][] = ['label' => $model::title(), 'url' => ['index']];
<?php if($generator->enableI18N): ?>
$this->params['breadcrumbs'][] = ($this->title = strtr('{model} edit', ['{model}' => $model::title()]));
<?php else: ?>
$this->params['breadcrumbs'][] = ($this->title = Yii::t('<?= $generator->messageCategory ?>', '{model} edit', ['model' => $model::title()]);
<?php endif ?>

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <?= '<?= ' ?><?= StringHelper::basename($generator->cardWidgetClass) ?>::widget([
        'icon' => 'assignment',
        'title' => $this->title,
        'buttons' => [
            <?= StringHelper::basename($generator->buttonDeleteWidgetClass) ?>::widget(['model' => $model]),
            <?= StringHelper::basename($generator->buttonBackWidgetClass) ?>::widget(),
        ],
        'body' => $this->render('_form', compact('model'))
    ]) ?>
</div>

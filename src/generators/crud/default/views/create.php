<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->cardWidgetClass ?>;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

$this->params['breadcrumbs'][] = ['label' => $model::titleList(), 'url' => ['index']];
$this->params['breadcrumbs'][] = ($this->title = sprintf('Új %s létrehozása', $model::title()));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?= '<?= ' ?><?= StringHelper::basename($generator->cardWidgetClass) ?>::widget([
        'icon' => 'assignment',
        'title' => $this->title,
        'buttons' => Yii::$app->material->back(),
        'body' => $this->render('_form', compact('model'))
    ]) ?>
</div>

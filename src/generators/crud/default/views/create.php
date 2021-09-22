<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

echo "<?php\n";
?>

use <?= $generator->htmlHelperClass ?>;

/** @var \yii\web\View $this */
/** @var \<?= ltrim($generator->modelClass, '\\') ?> $model */


$this->params['breadcrumbs'][] = ['label' => $model::titleList(), 'url' => ['index']];
$this->params['breadcrumbs'][] = ($this->title = sprintf('Új %s létrehozása', $model::title()));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?= '<?= ' ?>$this->render('@app/views/components/create', [
        'form' => $this->render('_form', compact('model'))
    ]) ?>
</div>

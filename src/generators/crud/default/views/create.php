<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use vasadibt\materialdashboard\grid\Helper;
use yii\helpers\Html;

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

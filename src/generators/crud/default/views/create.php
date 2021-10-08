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

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

$this->params['breadcrumbs'][] = ['label' => Yii::$app->material->modelTitleList($model), 'url' => ['index']];
$this->params['breadcrumbs'][] = ($this->title = sprintf('Új %s létrehozása', Yii::$app->material->modelTitle($model)));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?= '<?= ' ?>$this->render('@app/views/components/create', [
        'form' => $this->render('_form', compact('model')),
    ]) ?>
</div>

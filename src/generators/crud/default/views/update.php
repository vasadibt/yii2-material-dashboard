<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$modelClassName = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$nameAttributeTemplate = '$model->' . $generator->getNameAttribute();
$titleTemplate = $generator->generateString('Update ' . $modelClassName . ': {name}', ['name' => '{nameAttribute}']);
if ($generator->enableI18N) {
    $title = strtr($titleTemplate, ['\'{nameAttribute}\'' => $nameAttributeTemplate]);
} else {
    $title = strtr($titleTemplate, ['{nameAttribute}\'' => '\' . ' . $nameAttributeTemplate]);
}

echo "<?php\n";
?>

use vasadibt\materialdashboard\grid\Helper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */

$this->params['breadcrumbs'][] = ['label' => $model::titleList(), 'url' => ['index']];
$this->params['breadcrumbs'][] = ($this->title = sprintf('%s módosítása', $model::title()));

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <?= '<?= ' ?>$this->render('@app/views/components/update', [
        'form' => $this->render('_form', compact('model'))
    ]) ?>
</div>

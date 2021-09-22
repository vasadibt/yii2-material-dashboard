<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii2mod\notify\BootstrapNotify;

/* @var $this View */
/* @var $content string */

if (!empty($appAssetClass = Yii::$app->material->appAssetClass)) {
    $appAssetClass::register($this);
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= BootstrapNotify::widget() ?>

<div class="wrapper">
    <?= $this->render('_sidebar') ?>
    <div class="main-panel">
        <?= $this->render('_navbar') ?>
        <div class="content">
            <div class="content">

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'tag' => 'ol',
                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>' . "\n",
                    'activeItemTemplate' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>' . "\n",
                ]); ?>

                <div class="container-fluid">
                    <?= $content ?>
                </div>
            </div>
        </div>
        <?= $this->render('_footer') ?>
    </div>
</div>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

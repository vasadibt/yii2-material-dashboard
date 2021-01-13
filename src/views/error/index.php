<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$statusCode = $exception instanceof \yii\web\HttpException ? $exception->statusCode : 500;

$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="page-header error-page header-filter" style="background-image: url('<?= $bundle->baseUrl . '/img/clint-mckoy.jpg' ?>')">
    <!-- You can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
    <div class="content-center">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title"><?= $statusCode ?></h1>
                <h2><?= Yii::t('materialdashboard', 'Ooooups! Looks like you got lost.')?> :(</h2>
                <h4><?= nl2br(Html::encode($message)) ?></h4>
                <a href="<?= Yii::$app->user->getReturnUrl() ?>" class="btn btn-link btn-info"><?= Yii::t('materialdashboard', 'Go back')?></a>
            </div>
        </div>
    </div>
    <?= $this->render('../layouts/_footer') ?>
</div>
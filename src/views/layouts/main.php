<?php

use yii\web\View;
use yii2mod\notify\BootstrapNotify;

/* @var $this View */
/* @var $content string */

Yii::$app->material->register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= \vasadibt\materialdashboard\helpers\Html::encode($this->title) ?></title>
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
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </div>
        <?= $this->render('_footer') ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

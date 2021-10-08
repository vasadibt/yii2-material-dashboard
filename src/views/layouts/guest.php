<?php

use yii2mod\notify\BootstrapNotify;

/** @var \yii\web\View $this */
/** @var string $content */

if (!empty($appAssetClass = Yii::$app->material->appAssetClass)) {
    $appAssetClass::register($this);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Yii::$app->material->helperHtml::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= BootstrapNotify::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

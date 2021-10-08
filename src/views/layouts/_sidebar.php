<?php

use vasadibt\materialdashboard\widgets\Menu;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */

$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="sidebar" data-color="rose" data-background-color="black" data-image="<?= $bundle->baseUrl . '/img/sidebar-1.jpg' ?>">
    <div class="logo">
        <a href="<?= Url::to(['/']) ?>" class="simple-text logo-mini">
            <i class="material-icons">settings_applications</i>
        </a>
        <a href="<?= Url::to(['/']) ?>" class="simple-text logo-normal">
            <?= Yii::$app->name ?>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <?= Menu::widget([
            'items' => [
                [
                    'label' => 'Users',
                    'icon' => 'face',
                    'url' => ['/auth/user/index'],
                ],
            ]
        ]) ?>
    </div>
</div>

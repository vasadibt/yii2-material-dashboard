<?php


namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle;

/**
 * Class GridViewAsset
 * @package vasadibt\materialdashboard\assets
 */
class GridViewAsset extends AssetBundle
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/grid-view';
    public $css = [
        'grid-view.css',
    ];
    public $depends = [
        \yii\grid\GridViewAsset::class,
    ];
}
<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle as BaseMaterialAsset;

/**
 * Material AssetBundle
 * @since 0.1
 */
class MaterialAsset extends BaseMaterialAsset
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/material';

    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons',
        'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'css/material-dashboard.min.css',
        'css/custom.css',
    ];

    public $js = [
        'js/popper.min.js',
        'js/bootstrap-material-design.min.js',
        'js/material-dashboard.min.js',
        'js/custom.js',
    ];

    public $depends = [
        \yii\web\YiiAsset::class,
        \vasadibt\materialdashboard\assets\PerfectScrollbarAsset::class,
    ];
}

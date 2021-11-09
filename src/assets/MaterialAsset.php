<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle as BaseMaterialAsset;
use yii\web\YiiAsset;

/**
 * Material AssetBundle
 * @since 0.1
 */
class MaterialAsset extends BaseMaterialAsset
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/material-new';

    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons',
        'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'css/material-dashboard.css',
        'css/custom.css',
    ];

    public $js = [
        'js/core/popper.min.js',
        'js/core/bootstrap-material-design.min.js',
        'js/plugins/moment.min.js',
        'js/material-dashboard.min.js',
        'js/materialdashboard-fileinput.js',
        'js/custom.js',
    ];

    public $depends = [
        YiiAsset::class,
        PerfectScrollbarAsset::class,
    ];
}

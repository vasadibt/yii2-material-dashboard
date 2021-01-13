<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle;

/**
 * Class PerfectScrollbarAsset
 * @package vasadibt\materialdashboard\assets
 */
class PerfectScrollbarAsset extends AssetBundle
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/perfectscrollbar';

    public $css = [
        'perfect-scrollbar.jquery.css',
    ];

    public $js = [
        'perfect-scrollbar.jquery.min.js',
        'init.js',
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
    ];
}
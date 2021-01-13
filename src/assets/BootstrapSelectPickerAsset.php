<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle;

/**
 * Class BootstrapSelectPickerAsset
 * @package vasadibt\materialdashboard\assets
 */
class BootstrapSelectPickerAsset extends AssetBundle
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/bootstrapselectpicker';

    public $js = [
        'bootstrap-selectpicker.js',
    ];

    public $depends = [
        MaterialAsset::class,
    ];
}
<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle;

/**
 * Class BootstrapDateTimePickerAsset
 * @package vasadibt\materialdashboard\assets
 */
class BootstrapDateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/bootstrapdatetimepicker';

    public $js = [
        'bootstrap-datetimepicker.min.js',
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
        \conquer\momentjs\MomentjsAsset::class,
    ];
}
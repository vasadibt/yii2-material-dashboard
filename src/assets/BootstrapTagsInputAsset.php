<?php

namespace vasadibt\materialdashboard\assets;

use yii\web\AssetBundle;

/**
 * Class BootstrapTagsInputAsset
 * @package vasadibt\materialdashboard\assets
 */
class BootstrapTagsInputAsset extends AssetBundle
{
    public $sourcePath = '@vasadibt/materialdashboard/assets/bootstraptagsinput';

    public $js = [
        'bootstrap-tagsinput.js',
    ];

    public $depends = [
        MaterialAsset::class,
    ];
}
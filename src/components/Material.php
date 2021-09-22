<?php

namespace vasadibt\materialdashboard\components;

use vasadibt\materialdashboard\helpers\Button;
use vasadibt\materialdashboard\helpers\Html;
use yii\base\Component;

class Material extends Component
{
    public $appAssetClass;
    /**
     * @var string|Html
     */
    public $helperHtml = Html::class;
    /**
     * @var string|Button
     */
    public $helperButton = Button::class;

}
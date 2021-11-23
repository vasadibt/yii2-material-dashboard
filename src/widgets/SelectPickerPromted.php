<?php

namespace vasadibt\materialdashboard\widgets;

use Yii;

class SelectPickerPromted extends SelectPicker
{
    public $prompt;

    public function init()
    {
        parent::init();
        $this->prompt = $this->prompt ?? Yii::t('materialdashboard', 'Not selected');
    }
}
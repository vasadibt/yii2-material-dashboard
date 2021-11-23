<?php

namespace vasadibt\materialdashboard\widgets;

use Yii;

class BooleanPicker extends SelectPicker
{
    public $items;
    public $yesLabel;
    public $noLabel;

    public function init()
    {
        parent::init();

        if($this->items === null){
            $this->items = [
                1 => $this->yesLabel ?? Yii::t('materialdashboard', 'Yes'),
                0 => $this->noLabel ?? Yii::t('materialdashboard', 'No'),
            ];
        }
    }
}
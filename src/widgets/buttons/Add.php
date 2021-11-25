<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Add extends Fab
{
    public $icon = 'add';
    public $optionType = 'btn-success';
    public $optionBorder = 'btn-round';

    public function init()
    {
        parent::init();
        if ($this->tooltip === null) {
            $this->tooltip = Yii::t('materialdashboard', 'Add');
        }
    }
}
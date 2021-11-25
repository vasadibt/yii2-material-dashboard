<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class More extends Fab
{
    public $icon = 'north_east';
    public $optionType = 'btn-info';

    public function init()
    {
        parent::init();

        if ($this->tooltip === null) {
            $this->tooltip = Yii::t('materialdashboard', 'More');
        }
    }
}
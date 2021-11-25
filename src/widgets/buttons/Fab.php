<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Fab extends Link
{
    public $optionStyle = 'btn-fab';
    public $tooltip;

    public function init()
    {
        parent::init();

        if ($this->tooltip === null) {
            $this->tooltip = Yii::t('materialdashboard', 'More');
        }
    }
}
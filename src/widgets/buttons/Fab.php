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

        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'More');
        }
    }
}
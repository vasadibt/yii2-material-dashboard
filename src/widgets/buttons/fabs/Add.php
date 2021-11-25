<?php

namespace vasadibt\materialdashboard\widgets\buttons\fabs;

use Yii;

class Add extends Fab
{
    public $icon = 'add';
    public $optionType = 'btn-success';

    public function init()
    {
        parent::init();
        if ($this->tooltip === null) {
            $this->tooltip = Yii::t('materialdashboard', 'Add');
        }
    }
}
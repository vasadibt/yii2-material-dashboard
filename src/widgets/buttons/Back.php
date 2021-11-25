<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Back extends Link
{
    public $icon = 'keyboard_arrow_left';
    public $title;
    public $optionType = 'btn-info';
    public $optionStyle = 'btn-round';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        if (empty($this->url)) {
            $this->url = Yii::$app->request->referrer ?? ['index'];
        }
        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Back');
        }
    }


}
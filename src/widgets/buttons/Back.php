<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Back extends BaseButton
{
    public $tag = 'a';
    public $title;
    public $icon = 'keyboard_arrow_left';
    protected $_options = [
        'class' => [
            'widget' => 'btn',
            'size' => 'btn-sm',
            'type' => 'btn-info',
            'style' => 'btn-round',
            'position' => 'mt-3'
        ],
    ];

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
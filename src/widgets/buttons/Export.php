<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Export extends BaseButton
{
    public $tag = 'a';
    public $title;
    public $icon = 'file_download';
    protected $_options = [
        'class' => [
            'widget' => 'btn',
            'size' => 'btn-sm',
            'type' => 'btn-info',
        ],
    ];

    public function init()
    {
        parent::init();
        if (empty($this->url)) {
            $this->url = array_merge(['export'], Yii::$app->request->getQueryParams());
        }
        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Excel export');
        }
    }
}
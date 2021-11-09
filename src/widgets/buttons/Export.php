<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use vasadibt\materialdashboard\components\MaterialButton;
use Yii;

class Export extends BaseButton
{
    public $tag = 'a';
    public $title = 'Excel exportálás';
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
    }
}
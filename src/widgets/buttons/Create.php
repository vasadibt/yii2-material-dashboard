<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Create extends BaseButton
{
    public $tag = 'a';
    /**
     * @var object
     */
    public $model;
    public $title = 'Új {{modelTitle}}';
    public $icon = 'add';
    public $modelTitle;

    protected $_options = [
        'class' => [
            'widget' => 'btn',
            'size' => 'btn-sm',
            'type' => 'btn-success'
        ],
    ];

    public function init()
    {
        parent::init();
        if(empty($this->url)){
            $this->url = ['create'];
        }
        $this->modelTitle = $this->material->modelTitle($this->model);
    }
}
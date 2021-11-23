<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use vasadibt\materialdashboard\interfaces\ModelTitleizeInterface;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

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

        if($this->url === null){
            $this->url = ['create'];
        }

        if($this->modelTitle === null && $this->model){
            $this->modelTitle = $this->model instanceof ModelTitleizeInterface
                ? $this->model::title()
                : Inflector::titleize(Inflector::camel2words(StringHelper::basename(get_class($this->model))));
        }
    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use yii\db\ActiveRecordInterface;

class Delete extends BaseButton
{
    public $tag = 'a';
    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $title = 'Törlés';
    public $icon = 'delete';

    protected $_options = [
        'class' => [
            'widget' => 'btn',
            'size' => 'btn-sm',
            'type' => 'btn-danger',
            'style' => 'btn-round',
            'position' => 'mt-3'
        ],
        'data' => [
            'method' => 'post',
            'confirm' => 'Biztos törölni szeretnéd ezt a tételt?',
        ],
    ];

    public function init()
    {
        parent::init();
        if (empty($this->url) && $this->model) {
            $this->url = array_merge(['delete'], $this->model->getPrimaryKey(true));
        }
    }
}
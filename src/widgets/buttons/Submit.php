<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use yii\db\ActiveRecordInterface;

class Submit extends BaseButton
{
    public $tag = 'button';

    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $createTitle = 'Létrehozás';
    public $updateTitle = 'Mentés';
    public $title;
    public $icon = 'save';
    protected $_options = [
        'type' => 'submit',
        'class' => [
            'widget' => 'btn',
            'size' => 'btn-sm',
            'type' => 'btn-success',
        ]
    ];

    public function init()
    {
        parent::init();
        if($this->title === null){
            $this->title =  $this->model && $this->model->isNewRecord ? $this->createTitle : $this->updateTitle;
        }
    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;
use yii\db\ActiveRecordInterface;

class Submit extends BaseButton
{
    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $createTitle;
    public $updateTitle;
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
        if ($this->title === null) {
            if ($this->model && $this->model->isNewRecord) {
                $this->title = $this->createTitle ?? Yii::t('materialdashboard', 'Create');
            } else {
                $this->title = $this->updateTitle ?? Yii::t('materialdashboard', 'Save');
            }
        }
    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;
use yii\db\ActiveRecordInterface;

class Delete extends Link
{
    public $icon = 'delete';
    public $title;
    protected $_options = [
        'class' => [
            'widget' => '{{optionWidget}}',
            'size' => '{{optionSize}}',
            'type' => '{{optionType}}',
            'style' => '{{optionStyle}}',
            'position' => '{{optionPosition}}'
        ],
        'data' => [
            'method' => '{{dataMethod}}',
            'confirm' => '{{dataConfirm}}',
        ],
    ];
    public $optionType = 'btn-danger';
    public $optionStyle = 'btn-round';

    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $dataMethod = 'POST';
    public $dataConfirm;

    public function init()
    {
        parent::init();
        if (empty($this->url) && $this->model) {
            $this->url = array_merge(['delete'], $this->model->getPrimaryKey(true));
        }

        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Delete');
        }

        if ($this->dataConfirm === null) {
            $this->dataConfirm = Yii::t('materialdashboard', 'Are you sure you want to delete this item?');
        }

    }
}
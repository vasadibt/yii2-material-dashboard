<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;
use yii\db\ActiveRecordInterface;

class Delete extends BaseButton
{
    public $tag = 'a';
    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $title;
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
            'confirm' => null,
        ],
    ];

    public function init()
    {
        parent::init();
        if (empty($this->url) && $this->model) {
            $this->url = array_merge(['delete'], $this->model->getPrimaryKey(true));
        }

        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Delete');
        }

        if (!isset($this->_options['data']['confirm'])) {
            $this->_options['data']['confirm'] = Yii::t('materialdashboard', 'Are you sure you want to delete this item?');
        }

    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons\fabs;

use Yii;
use yii\db\ActiveRecordInterface;

class Delete extends Fab
{
    public $icon = 'delete';
    public $optionType = 'btn-danger';
    /**
     * @var ActiveRecordInterface
     */
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->url) && $this->model) {
            $this->url = array_merge(['delete'], $this->model->getPrimaryKey(true));
        }

        if ($this->tooltip === null) {
            $this->tooltip = Yii::t('materialdashboard', 'Delete');
        }

        if (empty($this->confirm)) {
            $this->confirm = Yii::t('materialdashboard', 'Are you sure you want to delete this item?');
        }
    }
}
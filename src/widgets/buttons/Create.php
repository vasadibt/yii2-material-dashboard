<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use vasadibt\materialdashboard\interfaces\ModelTitleizeInterface;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class Create extends Link
{
    public $icon = 'add';
    public $title;
    public $optionType = 'btn-success';

    /**
     * @var object
     */
    public $model;
    public $modelTitle;

    public function init()
    {
        parent::init();

        if ($this->url === null) {
            $this->url = ['create'];
        }

        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'New {{modelTitle}}');
        }

        if ($this->modelTitle === null && $this->model) {
            $this->modelTitle = $this->model instanceof ModelTitleizeInterface
                ? $this->model::title()
                : Inflector::titleize(Inflector::camel2words(StringHelper::basename(get_class($this->model))));
        }
    }
}
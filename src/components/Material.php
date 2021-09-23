<?php

namespace vasadibt\materialdashboard\components;

use vasadibt\materialdashboard\helpers\Button;
use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\interfaces\ModelTitleizeInterface;
use yii\base\Component;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class Material extends Component
{
    public $appAssetClass;
    /**
     * @var string|Html
     */
    public $helperHtml = Html::class;
    /**
     * @var string|Button
     */
    public $helperButton = Button::class;

    /**
     * @param Model $model
     * @return string
     */
    public function modelTitle($model)
    {
        return $model instanceof ModelTitleizeInterface
            ? $model::title()
            : Inflector::titleize(Inflector::camel2words(StringHelper::basename(get_class($model))));
    }

    /**
     * @param Model $model
     * @return string
     */
    public function modelTitleList($model)
    {
        return $model instanceof ModelTitleizeInterface
            ? $model::titleList()
            : $this->modelTitle($model) . ' list';
    }

}
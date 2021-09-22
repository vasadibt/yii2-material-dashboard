<?php

namespace vasadibt\materialdashboard\widgets;

use Yii;
use yii\widgets\InputWidget;

/**
 * Class ToggleButton
 * @package vasadibt\materialdashboard\widgets
 */
class ToggleButton extends InputWidget
{
    /**
     * {@inheritDoc}
     * @return string
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Yii::$app->material->helperHtml::activeCheckbox($this->model, $this->attribute, $this->options)
            : Yii::$app->material->helperHtml::checkbox($this->name, $this->value, $this->options);

        $toggle = Yii::$app->material->helperHtml::tag('span', null, ['class' => 'toggle']);
        $label = Yii::$app->material->helperHtml::tag('label', $input . $toggle);
        return Yii::$app->material->helperHtml::tag('div', $label, ['class' => 'togglebutton']);
    }
}
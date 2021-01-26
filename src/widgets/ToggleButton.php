<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\helpers\Html;
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
            ? Html::activeCheckbox($this->model, $this->attribute, $this->options)
            : Html::checkbox($this->name, $this->value, $this->options);

        $toggle = Html::tag('span', null, ['class' => 'toggle']);
        $label = Html::tag('label', $input . $toggle);
        return Html::tag('div', $label, ['class' => 'togglebutton']);
    }
}
<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\assets\BootstrapSelectPickerAsset;
use vasadibt\materialdashboard\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class BootstrapSelectPicker
 * @package vasadibt\materialdashboard\widgets
 */
class BootstrapSelectPicker extends InputWidget
{
    /**
     * @var string
     */
    public $prompt;
    public $items = [];
    public $dataStyle = 'select-with-transition';
    public $multiple = false;

    /**
     * @var array
     */
    public $pluginOptions = [];
    /**
     * @var array
     */
    public $pluginEvents = [];

    /**
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'selectpicker');
        $this->options['prompt'] = $this->prompt;
        $this->options['data-style'] = $this->dataStyle;
        $this->options['multiple'] = $this->multiple;
        $this->pluginOptions = (array)$this->pluginOptions;
        $this->registerAssets();
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function run()
    {
        return $this->hasModel()
            ? Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options)
            : Html::dropDownList($this->name, $this->value, $this->items, $this->options);
    }

    /**
     * Register plugin script
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $id = 'jQuery("#' . $this->options['id'] . '")';
        $script = $id . '.selectpicker(' . (!empty($this->pluginOptions) ? Json::htmlEncode($this->pluginOptions) : '') . ')';

        if (!empty($this->pluginEvents)) {
            foreach ($this->pluginEvents as $event => $handler) {
                $function = $handler instanceof JsExpression ? $handler : new JsExpression($handler);
                $script .= "\n{$id}.on('{$event}', {$function});";
            }
        }

        BootstrapSelectPickerAsset::register($view);
        $view->registerJs($script);
    }
}
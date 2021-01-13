<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\assets\BootstrapDateTimePickerAsset;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Class BootstrapDateTimePicker
 * @package vasadibt\materialdashboard\widgets
 */
class BootstrapDateTimePicker extends InputWidget
{
    const FORMAT_DATETIME = 'YYYY-MM-DD H:mm';
    const FORMAT_DATE = 'YYYY-MM-DD';
    const FORMAT_TIME = 'H:mm';

    /**
     * @var bool
     */
    public $format = self::FORMAT_DATETIME;
    /**
     * @var string
     */
    public $locale = 'en';
    /**
     * @var array
     */
    public $pluginOptions = [];
    /**
     * @var array
     */
    public $pluginEvents = [];
    /**
     * @var array
     */
    public $icons = [
        'time' => 'fa fa-clock-o',
        'date' => 'fa fa-calendar',
        'up' => 'fa fa-chevron-up',
        'down' => 'fa fa-chevron-down',
        'previous' => 'fa fa-chevron-left',
        'next' => 'fa fa-chevron-right',
        'today' => 'fa fa-screenshot',
        'clear' => 'fa fa-trash',
        'close' => 'fa fa-remove',
    ];

    /**
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->pluginOptions = (array)$this->pluginOptions;

        if ($this->format !== null) {
            $this->pluginOptions['format'] = $this->format;
        }
        if ($this->locale !== null) {
            $this->pluginOptions['locale'] = $this->locale;
        }
        if ($this->icons !== null) {
            $this->pluginOptions['icons'] = $this->icons;
        }
        $this->registerAssets();
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function run()
    {
        return $this->renderInputHtml('text');
    }

    /**
     * Register plugin script
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $id = 'jQuery("#' . $this->options['id'] . '")';
        $script = $id . '.datetimepicker(' . (!empty($this->pluginOptions) ? Json::htmlEncode($this->pluginOptions) : '') . ')';

        if (!empty($this->pluginEvents)) {
            foreach ($this->pluginEvents as $event => $handler) {
                $function = $handler instanceof JsExpression ? $handler : new JsExpression($handler);
                $script .= "\n{$id}.on('{$event}', {$function});";
            }
        }

        BootstrapDateTimePickerAsset::register($view);
        $view->registerJs($script);
    }
}
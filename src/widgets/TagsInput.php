<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\assets\BootstrapTagsInputAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Class TagsInput
 * @package vasadibt\materialdashboard\widgets
 */
class TagsInput extends InputWidget
{
    const DEFAULT = 'default';
    const PRIMARY = 'primary';
    const INFO = 'info';
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const DANGER = 'danger';

    /**
     * @var string
     */
    public $color = self::PRIMARY;
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

        Html::addCssClass($this->options, 'tagsinput');

        $this->options['data-role'] = 'tagsinput';
        $this->options['data-color'] = $this->color;
        $this->pluginOptions = (array)$this->pluginOptions;
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
        $script = $id . '.tagsinput(' . (!empty($this->pluginOptions) ? Json::htmlEncode($this->pluginOptions) : '') . ')';

        if (!empty($this->pluginEvents)) {
            foreach ($this->pluginEvents as $event => $handler) {
                $function = $handler instanceof JsExpression ? $handler : new JsExpression($handler);
                $script .= "\n{$id}.on('{$event}', {$function});";
            }
        }

        BootstrapTagsInputAsset::register($view);
        $view->registerJs($script);
    }
}
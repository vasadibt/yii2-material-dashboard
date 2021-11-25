<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\widgets\BaseWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @property array $options
 * @property string $url
 */
class Button extends BaseWidget
{
    const SPINNER_TEMPLATE = '<span class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true"></span>';

    const TEMPLATE_ICON = '<{{tag}}{{options}}>{{iconTemplate}}{{spinner}}{{ripple}}</{{tag}}>';
    const TEMPLATE_ICON_TITLE = '<{{tag}}{{options}}>{{iconTemplate}}<span class="d-none d-md-inline ml-1">{{title}}</span>{{spinner}}{{ripple}}</{{tag}}>';
    const TEMPLATE_TITLE = '<{{tag}}{{options}}>{{title}}{{spinner}}{{ripple}}</{{tag}}>';

    /**
     * @var string
     */
    public $template = self::TEMPLATE_ICON_TITLE;
    /**
     * @var string
     */
    public $tag = 'button';
    /**
     *
     */
    protected $spinner;
    /**
     * @var string
     */
    public $iconTemplate = '<i class="material-icons">{{icon}}</i>';
    /**
     * @var string
     */
    public $icon;
    /**
     * @var string
     */
    public $ripple = '<div class="ripple-container"></div>';
    /**
     * @var string
     */
    public $title;
    /**
     * @var array
     */
    protected $_options = [
        'class' => [
            'widget' => '{{optionWidget}}',
            'size' => '{{optionSize}}',
            'type' => '{{optionType}}',
            'style' => '{{optionStyle}}',
            'position' => '{{optionPosition}}'
        ],
    ];

    public $optionWidget = 'btn';
    public $optionSize = 'btn-sm';
    public $optionType = 'btn-info';
    public $optionStyle = '';
    public $optionPosition = '';


    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->renderTemplate($this->template ?? $this->getAutoTemplate());
    }

    /**
     * @return string
     */
    public function getAutoTemplate()
    {
        if (isset($this->icon) && isset($this->title)) {
            return static::TEMPLATE_ICON_TITLE;
        }
        if (isset($this->icon)) {
            return static::TEMPLATE_ICON;
        }
        return static::TEMPLATE_TITLE;
    }

    /**
     * @return \string[][]
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param string[][] $options
     */
    public function setOptions(array $options): void
    {
        Html::updateOptions($this->_options, $options);
    }

    /**
     * @param string|array $name
     * @param null $default
     * @return mixed
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function getOption($name, $default = null)
    {
        if (is_string($name) && substr($name, 0, 5) == 'data-') {
            $name = 'data.' . substr($name, 5);
        }
        return ArrayHelper::getValue($this->options, $name, $default);
    }

    /**
     * @param string|array $name
     * @param mixed $value
     */
    public function setOption($name, $value)
    {
        $this->setOptions([$name => $value]);
    }

    /**
     * @return string
     */
    public function getUrlOptionName($default = null)
    {
        return $this->tag == 'a' ? 'href' : ($default ?? 'data-url');
    }

    /**
     * @param null $attribute
     * @return mixed
     */
    public function getUrl($attribute = null)
    {
        return $this->getOption($this->getUrlOptionName($attribute));
    }

    /**
     * @param $value
     * @param null $attribute
     */
    public function setUrl($value, $attribute = null, $schema = null)
    {
        $this->setOption($this->getUrlOptionName($attribute), Url::to($value, $schema));
    }

    /**
     * @param bool|string $spinner
     */
    public function setSpinner($spinner)
    {
        $this->spinner = is_bool($spinner) ? ($spinner ? static::SPINNER_TEMPLATE : '') : $spinner;
    }

    /**
     * @param $template
     * @return array|mixed|string|string[]
     */
    public function renderTemplate($template)
    {
        $template = (string)$template;
        while (preg_match("/{{(.*?)}}/", $template, $matches)) {
            $key = $matches[0];
            $attribute = $matches[1];
            $value = $this->renderAttribute($attribute);

            $template = str_replace($key, $value, $template);
        }

        return $template;
    }

    /**
     * @param string $attribute
     * @param mixed $default
     * @return string|mixed
     */
    public function renderAttribute(string $attribute, $default = '')
    {
        if (!isset($this->$attribute)) {
            return $default;
        }

        $renderMethod = $attribute . 'Render';
        if (method_exists($this, $renderMethod)) {
            return $this->$renderMethod();
        }

        return $this->$attribute;
    }

    /**
     * @return string
     */
    public function optionsRender()
    {
        return Html::renderTagAttributes($this->options);
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        ob_start();
        ob_implicit_flush(false);
        try {
            $this->end();
        } catch (\Exception $e) {
            // close the output buffer opened above if it has not been closed already
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }

        return ob_get_clean();
    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use vasadibt\materialdashboard\components\Material;
use vasadibt\materialdashboard\helpers\Html;
use yii\base\Widget;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @property array $options
 * @property string $url
 */
class BaseButton extends Widget
{
    /**
     * @var string|Material
     */
    public $material = 'material';
    /**
     * @var string
     */
    public $content = '<{{tag}}{{options}}>{{iconTemplate}}<span class="d-none d-md-inline"> {{title}}</span>{{ripple}}</{{tag}}>';
    public $tag = 'button';
    public $iconTemplate = '<span class="material-icons">{{icon}}</span>';
    public $ripple = '<div class="ripple-container"></div>';

    protected $_options = [];

    /**
     * @var array
     */
    protected $title = [];

    /**
     * {@inheritdoc }
     */
    public function init()
    {
        parent::init();
        $this->material = Instance::ensure($this->material, Material::class);
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->renderTemplate($this->content, $this);
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
}
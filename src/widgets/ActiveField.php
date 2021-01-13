<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveField as YiiActiveField;

/**
 * Class ActiveField
 * @package vasadibt\materialdashboard\widgets
 *
 * @property ActiveForm $form
 */
class ActiveField extends YiiActiveField
{
    /**
     * {@inheritdoc}
     */
    public $options = ['class' => ['widget' => 'form-group bmd-form-group']];
    /**
     * @var string the `enclosed by label` template for checkboxes and radios in default layout
     */
    public $checkEnclosedTemplate = <<< HTML
<div class="form-check">\n
{beginLabel}\n
{input}\n
<span class="form-check-sign"><span class="check"></span></span>\n
{labelTitle}\n
{endLabel}\n
{error}\n
{hint}\n
</div>
HTML;

    /**
     * {@inheritdoc}
     * @overwrite enclosedByLabel params default value to 'true'
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        Html::addCssClass($options, 'form-check-input');
        Html::addCssClass($this->labelOptions, 'form-check-label');

        return parent::checkbox($options, $enclosedByLabel);
    }

    /**
     * {@inheritdoc}
     * @overwrite enclosedByLabel params default value to 'true'
     */
    public function radio($options = [], $enclosedByLabel = true)
    {
        Html::addCssClass($options, 'form-check-input');
        Html::addCssClass($this->labelOptions, 'form-check-label');

        return parent::radio($options, $enclosedByLabel);
    }

    /**
     * @param $part
     * @param $content
     * @return ActiveField
     */
    public function parts($part, $content)
    {
        $this->parts[$part] = $content;
        return $this;
    }

    /**
     * @param array|string|false $prepend
     * @return ActiveField|void
     */
    public function prepend($prepend)
    {
        Html::addCssClass($this->options, 'input-prepend');

        return $this->addon('prepend', $prepend);
    }

    /**
     * @param array|string|false $append
     * @return ActiveField|void
     */
    public function append($append)
    {
        return $this->addon('append', $append);
    }

    /**
     * @param $type
     * @param $addon
     * @return ActiveField|void
     */
    public function addon($type, $addon)
    {
        $type = strtolower($type);

        if (strpos($this->template, 'class="input-group"') === false) {
            $this->template = str_replace('{input}', '<div class="input-group">{input}</div>', $this->template);
        }

        if (strpos($this->template, '{' . $type . '}') === false) {
            $addonTemplate = '<div class="input-group-' . $type . '">{' . $type . '}</div>';
            $template = $type == 'prepend' ? "$addonTemplate\n{input}" : "{input}\n$addonTemplate";
            $this->template = str_replace('{input}', $template, $this->template);
        }

        if (!isset($this->parts['{' . $type . '}'])) {
            $this->parts['{' . $type . '}'] = '';
        }

        if ($addon === false) {
            $this->parts['{' . $type . '}'] = '';
            return $this;
        }

        if (is_string($addon)) {
            $this->parts['{' . $type . '}'] .= $addon;
        } elseif (is_array($addon)) {
            $tag = ArrayHelper::remove($addon, 'tag', 'span');
            $options = ArrayHelper::remove($addon, 'options', []);
            Html::addCssClass($options, 'input-group-text');
            $content = ArrayHelper::remove($addon, 'content', '');
            $this->parts['{' . $type . '}'] .= Html::tag($tag, $content, $options);
        }

        return $this;
    }
}
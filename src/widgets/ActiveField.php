<?php

namespace vasadibt\materialdashboard\widgets;

use kartik\form\ActiveForm;
use vasadibt\materialdashboard\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveField as KartikActiveField;

/**
 * Class ActiveField
 * @package vasadibt\materialdashboard\widgets
 *
 * @property ActiveForm $form
 */
class ActiveField extends KartikActiveField
{
    use WidgetTrait;
    /**
     * {@inheritdoc}
     */
    //public $options = ['class' => ['widget' => 'form-group bmd-form-group']];

    public $labelSpan = 3;
    //public $wrapperOptions = ['class' => 'form-group'];
    public $deviceSize = ActiveForm::SIZE_SMALL;

    public $checkTemplate = <<< HTML
<div class="form-check">
<label class="form-check-label">
{input}&nbsp;\n
<span class="form-check-sign"><span class="check"></span></span>\n
</label>
</div>
{error}\n
{hint}\n
HTML;

    /**
     * @var string the `enclosed by label` template for checkboxes and radios in default layout
     */
    public $checkEnclosedTemplate = <<< HTML
<div class="form-check">
{beginLabel}\n
{input}\n
<span class="form-check-sign"><span class="check"></span></span>\n
{labelTitle}\n
{endLabel}\n
</div>
{error}\n
{hint}\n
HTML;

    /**
     * @var string the template for rendering the Bootstrap 4.x custom file browser control
     * @see https://getbootstrap.com/docs/4.1/components/forms/#file-browser
     */
    public $fileTemplate = "
    {label}\n
    {beginWrapper}
    <div class=\"custom-file\">
        {input}
        <input type=\"text\" class=\"form-control inputFileVisible\" readonly>
    </div>\n
    {hint}\n
    {error}\n
    {endWrapper}
";


    /**
     * {@inheritdoc}
     * @overwrite enclosedByLabel params default value to 'true'
     */
    public function checkbox($options = [], $enclosedByLabel = null)
    {
        Html::addCssClass($options, 'form-check-input');
        return parent::checkbox($options, $enclosedByLabel);
    }

    /**
     * {@inheritdoc}
     * @overwrite enclosedByLabel params default value to 'true'
     */
    public function radio($options = [], $enclosedByLabel = null)
    {
        Html::addCssClass($options, 'form-check-input');
        return parent::radio($options, $enclosedByLabel);
    }

    /**
     * @param string $type
     * @param array $options
     * @param null $enclosedByLabel
     * @return KartikActiveField
     * @throws \yii\base\InvalidConfigException
     */
    protected function getToggleField($type = self::TYPE_CHECKBOX, $options = [], $enclosedByLabel = null)
    {
        $enclosedByLabel = !$this->form->isHorizontal();

        $this->initDisability($options);

        Html::removeCssClass($options, 'form-control');
        Html::addCssClass($options, "form-check-input");

        $this->template = ArrayHelper::remove($options, 'template', $enclosedByLabel ? $this->checkEnclosedTemplate : $this->checkTemplate);

        $this->form->removeCssClass($this->labelOptions, ActiveForm::BS_CONTROL_LABEL);
        Html::addCssClass($this->labelOptions, 'col-form-label');

        if ($this->form->isHorizontal()) {
            Html::removeCssClass($this->labelOptions, $this->getColCss($this->deviceSize) . $this->labelSpan);
            Html::addCssClass($this->labelOptions, 'label-checkbox');

            $hor = $this->horizontalCssClasses;
            $prefix = $this->getColCss($this->deviceSize);
            $labelCss = $prefix . $this->labelSpan . ' ' . implode(' ', (array)ArrayHelper::getValue($hor, 'label'));
            $inputCss = $prefix . ($this->form->fullSpan - $this->labelSpan) . ' ' . implode(' ', (array)ArrayHelper::getValue($hor, 'wrapper'));

            $inputCss .= ' checkbox-radios';

            $this->template = '{beginLabel}{labelTitle}{endLabel}'
                . Html::tag('div', $this->template, ['class' => $inputCss]);

            Html::addCssClass($this->labelOptions, $labelCss);
        }

        Html::removeCssClassWhen($this->form->isInline(), $this->labelOptions, $this->form->getSrOnlyCss());

        if ($enclosedByLabel || isset($options['label'])) {
            if (isset($options['label'])) {
                $this->parts['{labelTitle}'] = $options['label'];
            }
            $this->parts['{beginLabel}'] = Html::beginTag('label', $this->labelOptions);
            $this->parts['{endLabel}'] = Html::endTag('label');
        }

        return \yii\widgets\ActiveField::$type($options, false);
    }

    public function fileInput($options = [])
    {
        $this->template = $this->fileTemplate;

        Html::addCssClass($this->options, 'form-file-upload');
        Html::addCssClass($this->options, 'form-file-simple');
        Html::addCssClass($options, 'inputFileHidden');

        return parent::fileInput($options);
    }
}
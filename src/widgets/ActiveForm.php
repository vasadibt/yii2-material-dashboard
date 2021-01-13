<?php

namespace vasadibt\materialdashboard\widgets;

use yii\base\Model;
use yii\bootstrap4\ActiveForm as YiiActiveForm;

/**
 * Class ActiveForm
 * @package vasadibt\materialdashboard\widgets
 *
 * @method ActiveField field(Model $model, \string $attribute, array $options = [])
 */
class ActiveForm extends YiiActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'vasadibt\materialdashboard\widgets\ActiveField';
    /**
     * @var string the CSS class that is added to a field container when the associated attribute has validation error.
     */
    public $errorCssClass = 'has-danger';
    /**
     * @var string the CSS class that is added to a field container when the associated attribute is successfully validated.
     */
    public $successCssClass = 'has-success';
    /**
     * @var string where to render validation state class
     * Could be either "container" or "input".
     * Default is "container".
     * @since 2.0.14
     */
    public $validationStateOn = self::VALIDATION_STATE_ON_CONTAINER;
}
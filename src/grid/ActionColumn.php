<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 02. 28.
 * Time: 9:14
 */

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\helpers\Html;
use yii\grid\ActionColumn as YiiActionColumn;
use Yii;

/**
 * Class ActionColumn
 * @package vasadibt\materialdashboard\grid
 */
class ActionColumn extends YiiActionColumn
{
    public $template = '<div class="btn-group">{view}{update}{delete}</div>';
    public $contentOptions = ['class' => 'td-actions'];

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->header = $this->header ?? Yii::t('materialdashboard', 'Actions');
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'visibility', [
            'class' => 'btn btn-default',
            'rel'=>'tooltip',
            'title' => Yii::t('materialdashboard', 'View'),
            'aria-label' => Yii::t('materialdashboard', 'View'),
            'data-pjax' => '0',
        ]);
        $this->initDefaultButton('update', 'edit', [
            'class' => 'btn btn-info',
            'rel'=>'tooltip',
            'title' => Yii::t('materialdashboard', 'Update'),
            'aria-label' => Yii::t('materialdashboard', 'Update'),
            'data-pjax' => '0',
        ]);
        $this->initDefaultButton('delete', 'delete', [
            'class' => 'btn btn-danger',
            'rel'=>'tooltip',
            'title' => Yii::t('materialdashboard', 'Delete'),
            'aria-label' => Yii::t('materialdashboard', 'Delete'),
            'data-confirm' => Yii::t('materialdashboard', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'data-pjax' => '0',
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $options = array_merge($additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', $iconName, ['class' => 'material-icons']);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
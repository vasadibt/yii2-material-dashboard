<?php

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\helpers\Html;
use Yii;
use yii\helpers\ArrayHelper;

class ActionColumn extends \kartik\grid\ActionColumn
{
    public $templateContainer = '<div class="btn-group">{template}</div>';
    public $template = '{delete}{update}';
    public $contentOptions = ['class' => 'td-actions'];
    public $viewOptions = ['class' => 'btn btn-warning'];
    public $updateOptions = ['class' => 'btn btn-info'];
    public $deleteOptions = ['class' => 'btn btn-danger'];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $template = parent::renderDataCellContent($model, $key, $index);

        if ($this->templateContainer != false) {
            $template = strtr($this->templateContainer, [
                "{template}" => $template,
            ]);
        }

        return $template;
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        $this->setDefaultButton('view', 'Megtekintés', 'visibility');
        $this->setDefaultButton('update', 'Módosítás', 'edit');
        $this->setDefaultButton('delete', 'Törlés', 'delete');
    }

    /**
     * Sets a default button configuration based on the button name (bit different than [[initDefaultButton]] method)
     *
     * @param string $name button name as written in the [[template]]
     * @param string $title the title of the button
     * @param string $icon the meaningful glyphicon suffix name for the button
     */
    protected function setDefaultButton($name, $title, $icon)
    {
        if (isset($this->buttons[$name])) {
            return;
        }

        $this->buttons[$name] = function ($url) use ($name, $title, $icon) {
            $opts = "{$name}Options";
            $options = [
                'title' => $title,
                'aria-label' => $title,
                'data-original-title' => $title,
                'data-pjax' => '0',
                'rel' => 'tooltip',
            ];

            if ($name === 'delete') {
                $item = $this->grid->itemLabelSingle ?? Yii::t('kvgrid', 'item');
                $options['data-method'] = 'post';
                $options['data-confirm'] = Yii::t('kvgrid', 'Are you sure to delete this {item}?', ['item' => $item]);
            }
            $options = array_replace_recursive($options, $this->buttonOptions, $this->$opts);
            $label = $this->renderLabel($options, $title, [
                'class' => 'material-icons',
                'icon' => $icon,
                'aria-hidden' => 'true',
            ]);

            $link = \yii\helpers\Html::a($label, $url, $options);

            if ($this->_isDropdown) {
                $options['tabindex'] = '-1';
            }

            return $link;
        };
    }

    /**
     * Renders button icon
     *
     * @param array $options HTML attributes for the action button element
     * @param array $iconOptions HTML attributes for the icon element. The following additional options are recognized:
     * - `tag`: _string_, the HTML tag to render the icon. Defaults to `span`.
     *
     * @return string
     */
    protected function renderIcon(&$options, $iconOptions = [])
    {
        $icon = ArrayHelper::remove($options, 'icon');
        if ($icon === false) {
            return '';
        }

        if (is_string($icon)) {
            return $icon;
        }

        if (is_array($icon)) {
            $iconOptions = array_replace_recursive($iconOptions, $icon);
        }
        $tag = ArrayHelper::remove($iconOptions, 'tag', 'span');
        $iconType = ArrayHelper::remove($iconOptions, 'icon');
        return Html::tag($tag, $iconType, $iconOptions);

    }
}
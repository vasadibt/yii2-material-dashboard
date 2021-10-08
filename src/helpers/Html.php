<?php

namespace vasadibt\materialdashboard\helpers;

use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

class Html extends \yii\bootstrap4\Html
{
    /**
     * @return string
     */
    public static function span($content = '', $option = [])
    {
        return static::tag('span', $content, $option);
    }

    /**
     * @return string
     */
    public static function div($content = '', $option = [])
    {
        return static::tag('div', $content, $option);
    }

    /**
     * @param $name
     * @param array $options
     * @return string
     */
    public static function icon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        static::addCssClass($options, ['widget' => 'material-icons']);
        return static::tag($tag, $name, $options);
    }

    /**
     * @return string
     */
    public static function ripple()
    {
        return static::div('', ['class' => 'ripple-container']);
    }

    /**
     * @param DataProviderInterface $dataProvider
     * @param $id
     * @param $pageSizeValues
     * @return string
     */
    public static function pageSizeSelector(DataProviderInterface $dataProvider, $id, $pageSizeValues)
    {
        $selectedPageSize = $dataProvider->getPagination() ? $dataProvider->getPagination()->pageSize : '-';

        return static::div(
            static::label('Oldal mérete', $id, ['class' => 'control-label mr-2'])
            . static::dropDownList('per-page', $selectedPageSize, $pageSizeValues, [
                'id' => $id,
                'class' => 'form-control form-control-sm',
                'dir' => 'rtl',
            ]),
            ['class' => 'items-per-page-container']
        );
    }

    /**
     * @param $condition
     * @param $options
     * @param $class
     */
    public static function addCssClassWhen($condition, &$options, $class)
    {
        if ($condition) {
            static::addCssClass($options, $class);
        }
    }

    /**
     * @param $condition
     * @param $options
     * @param $class
     */
    public static function removeCssClassWhen($condition, &$options, $class)
    {
        if ($condition) {
            static::removeCssClass($options, $class);
        }
    }

}
<?php

namespace vasadibt\materialdashboard\traits;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

trait ModelTitleize
{
    public static $_title;
    public static $_titleList;

    /**
     * @return string
     */
    public static function title()
    {
        return static::$_title ?? Inflector::titleize(Inflector::camel2words(StringHelper::basename(static::class)));
    }

    /**
     * @return string
     */
    public static function titleList()
    {
        return static::$_titleList ?? static::title() . ' list';
    }
}
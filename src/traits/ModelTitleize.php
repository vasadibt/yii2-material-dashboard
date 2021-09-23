<?php

namespace vasadibt\materialdashboard\traits;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

trait ModelTitleize
{
    public static $title;
    public static $titleList;

    /**
     * @return string
     */
    public static function title()
    {
        return static::$title ?? Inflector::titleize(Inflector::camel2words(StringHelper::basename(static::class)));
    }

    /**
     * @return string
     */
    public static function titleList()
    {
        return static::$titleList ?? static::title() . ' list';
    }
}
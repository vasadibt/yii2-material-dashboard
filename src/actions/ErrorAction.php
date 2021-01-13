<?php


namespace vasadibt\materialdashboard\actions;


class ErrorAction extends \yii\web\ErrorAction
{
    /**
     * @var string
     */
    public $view = '@vasadibt/materialdashboard/views/error/index';
    /**
     * @var string
     */
    public $layout = '@vasadibt/materialdashboard/views/layouts/base';
}
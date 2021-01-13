<?php

namespace vasadibt\materialdashboard\controllers;

use vasadibt\materialdashboard\actions\ErrorAction;
use Yii;
use yii\base\Action;
use yii\web\Controller;

/**
 * Class ErrorController
 * @package vasadibt\materialdashboard\controllers
 */
class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
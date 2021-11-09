<?php

namespace vasadibt\materialdashboard\components;

use yii\web\Controller;

class DemoController extends Controller
{
    public function actionIndex()
    {
        return $this->render->('index');
    }
}
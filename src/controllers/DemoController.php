<?php

namespace vasadibt\materialdashboard\components;

use Yii;
use yii\web\Controller;

class DemoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    private function forMessageExtractScanner()
    {
        $messages = [
            Yii::t('materialdashboard', 'Item successfully created!'),
            Yii::t('materialdashboard', 'You have successfully modified the item!'),
            Yii::t('materialdashboard', 'You have successfully removed the item!'),
            Yii::t('materialdashboard', 'New {model} create'),
            Yii::t('materialdashboard', '{model} edit'),
        ];
    }
}
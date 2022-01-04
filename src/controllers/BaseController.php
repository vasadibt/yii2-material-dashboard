<?php

namespace vasadibt\materialdashboard\controllers;

use yii\console\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

abstract class BaseController extends Controller
{
    /**
     * @var array
     */
    public $actions = [];
    /**
     * @var array
     */
    public $verbs = [];
    /**
     * @var array
     */
    public $access = [];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [];

        if ($this->verbs) {
            $behaviors['verbs'] = [
                'class' => VerbFilter::class,
                'actions' => $this->verbs,
            ];
        }

        if($this->access){
            $behaviors['access'] = [
                'class' => AccessControl::class,
                'rules' => $this->access,
            ];
        }

        return $behaviors;
    }
}
<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;
use yii\base\Model;

class Reset extends Link
{
    public $icon = 'zoom_out';
    public $title;
    public $optionType = 'btn-warning';

    /**
     * @var Model
     */
    public $filterModel;

    public function init()
    {
        parent::init();

        if (empty($this->url)) {
            $params = Yii::$app->request->getQueryParams();
            if ($this->filterModel instanceof Model) {
                unset($params[$this->filterModel->formName()]);
            } else {
                $params = array_intersect_key($params, array_flip(['per-page', 'sort']));
            }
            $this->url = array_merge([''], $params);
        }

        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Reset filters');
        }
    }
}
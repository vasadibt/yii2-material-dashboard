<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;

class Export extends Link
{
    public $icon = 'file_download';
    public $title;
    public $optionType = 'btn-info';

    public function init()
    {
        parent::init();
        if (empty($this->url)) {
            $this->url = array_merge(['export'], Yii::$app->request->getQueryParams());
        }
        if ($this->title === null) {
            $this->title = Yii::t('materialdashboard', 'Excel export');
        }
    }
}
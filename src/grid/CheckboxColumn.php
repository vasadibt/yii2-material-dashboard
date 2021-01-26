<?php

namespace vasadibt\materialdashboard\grid;

use yii\grid\CheckboxColumn as YiiCheckboxColumn;

/**
 * Class CheckboxColumn
 * @package vasadibt\materialdashboard\grid
 */
class CheckboxColumn extends YiiCheckboxColumn
{
    use ColumnTrait;

    public $width = '30px';

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->setPageRows();
    }
}
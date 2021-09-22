<?php

namespace vasadibt\materialdashboard\grid;

use yii\base\Model;
use yii\grid\DataColumn as YiiDataColumn;

class DataColumn extends \kartik\grid\DataColumn
{
    public $vAlign = GridView::ALIGN_MIDDLE;
    public $sortLinkOptions = [];
}
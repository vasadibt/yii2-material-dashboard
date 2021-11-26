<?php

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\widgets\BooleanPickerPromted;

class BooleanColumn extends DataColumn
{
    public $filterType = BooleanPickerPromted::class;
    public $format = 'boolean';
    public $hAlign = 'center';
}
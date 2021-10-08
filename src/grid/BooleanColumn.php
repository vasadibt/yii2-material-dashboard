<?php

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\widgets\BootstrapSelectPicker;

class BooleanColumn extends DataColumn
{
    public $filterType = BootstrapSelectPicker::class;
    public $filterWidgetOptions = [
        'prompt' => 'Mind',
        'items' => ['1' => 'Igen', '2' => 'Nem'],
    ];
    public $format = 'boolean';
    public $hAlign = 'center';
}
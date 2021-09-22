<?php

namespace vasadibt\materialdashboard\grid;

class BooleanColumn extends DataColumn
{
    public $filterType = \vasadibt\materialdashboard\widgets\BootstrapSelectPicker::class;
    public $filterWidgetOptions = [
        'prompt' => 'Mind',
        'items' => ['1' => 'Igen', '2' => 'Nem'],
    ];
    public $format = 'boolean';
    public $hAlign = 'center';
}
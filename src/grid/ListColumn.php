<?php

namespace vasadibt\materialdashboard\grid;

class ListColumn extends DataColumn
{
    public $filterType = \vasadibt\materialdashboard\widgets\BootstrapSelectPicker::class;
    public $filterWidgetOptions = ['prompt' => 'Mind'];
    public $items = [];

    public function init()
    {
        if (!isset($this->filterWidgetOptions['items'])) {
            $this->filterWidgetOptions['items'] = $this->items;
        }

        parent::init();
    }
}
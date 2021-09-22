<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 06. 01.
 * Time: 7:44
 */

namespace vasadibt\materialdashboard\grid;

/**
 * Class GridView
 * @package vasadibt\materialdashboard\grid
 */
class GridView extends \kartik\grid\GridView
{
    public $dataColumnClass = DataColumn::class;

    public $layout = '
    {toolbar}
<div class="d-flex justify-content-between">{summary}{pager}{pageSizeTop}</div>
{items}
<div class="d-flex justify-content-between">{summary}{pager}{pageSizeBottom}</div>';

    public $pjax = true;
    public $pjaxSettings = ['neverTimeout' => true];
    public $toggleData = false;
    public $filterSelector = '#items-per-page-bottom';

    public $export = false;
    public $hover = true;
    public $panel = false;
    public $pager = [
        'class' => LinkPager::class,
        'options' => ['class' => 'pagination pagination-info'],
        'hideOnSinglePage' => false,
        'disableCurrentPageButton' => true,
        'linkOptions' => ['class' => 'page-link border-info text-info bg-transparent', 'style' => 'border-width: 1px; border-style: solid;'],
        'disabledListItemSubTagOptions' => ['class' => 'page-link border-danger text-danger bg-transparent'],
        'firstPageLabel' => '|«',
        'prevPageLabel' => '‹',
        'nextPageLabel' => '›',
        'lastPageLabel' => '»|',
    ];


    public $pageSizes = [1 => 1, 2 => 2, 20 => 20, 50 => 50, 100 => 100, '-' => 'Mind'];

    public function __construct($config = [])
    {
        $this->toolbar = [
            [
                'options' => ['class' => 'd-flex justify-content-end'],
                'content' => Helper::exportButton() . Helper::resetButton()
            ],
        ];

        parent::__construct($config);
    }

    public function init()
    {
        if ($this->filterModel instanceof \vasadibt\materialdashboard\interfaces\SearchModelInterface) {
            $this->dataProvider ??= $this->filterModel->getDataProvider();
        }

        if (!isset($this->replaceTags['{pageSizeTop}'])) {
            $this->replaceTags['{pageSizeTop}'] = Helper::pageSizeSelector($this->filterModel, 'items-per-page-top', $this->pageSizes);
        }

        if (!isset($this->replaceTags['{pageSizeBottom}'])) {
            $this->replaceTags['{pageSizeBottom}'] = Helper::pageSizeSelector($this->filterModel, 'items-per-page-bottom', $this->pageSizes);
        }

        parent::init();
    }
}
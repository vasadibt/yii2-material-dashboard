<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 06. 01.
 * Time: 7:44
 */

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\interfaces\SearchModelInterface;
use vasadibt\materialdashboard\widgets\buttons\Export;
use vasadibt\materialdashboard\widgets\buttons\Reset;
use Yii;
use yii\data\DataProviderInterface;

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
    public $toolbar;

    public function init()
    {
        if ($this->dataProvider === null
            && $this->filterModel instanceof SearchModelInterface
        ) {
            $this->dataProvider = $this->filterModel->getDataProvider();
        }

        if ($this->dataProvider instanceof DataProviderInterface) {
            if (!isset($this->replaceTags['{pageSizeTop}'])) {
                $this->replaceTags['{pageSizeTop}'] = Html::pageSizeSelector($this->dataProvider, 'items-per-page-top', $this->pageSizes);
            }

            if (!isset($this->replaceTags['{pageSizeBottom}'])) {
                $this->replaceTags['{pageSizeBottom}'] = Html::pageSizeSelector($this->dataProvider, 'items-per-page-bottom', $this->pageSizes);
            }
        }

        if ($this->toolbar === null) {
            $this->toolbar = [
                [
                    'options' => ['class' => 'd-flex justify-content-end'],
                    'content' => Export::widget() . Reset::widget(['filterModel' => $this->filterModel]),
                ],
            ];
        }

        parent::init();
    }
}
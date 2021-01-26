<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 06. 01.
 * Time: 7:44
 */

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\assets\GridViewAsset;
use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\widgets\BootstrapSelectPicker;
use Yii;
use yii\base\InvalidConfigException;
use yii\grid\GridView as YiiGridView;
use yii\helpers\ArrayHelper;

/**
 * Class GridView
 * @package vasadibt\materialdashboard\grid
 */
class GridView extends YiiGridView
{
    /**
     * @var string the top part of the table after the header (used for location of the page summary row)
     */
    const POS_TOP = 'top';
    /**
     * @var string the bottom part of the table before the footer (used for location of the page summary row)
     */
    const POS_BOTTOM = 'bottom';
    /**
     * @var string identifier for the `COUNT` summary function
     */
    const F_COUNT = 'f_count';
    /**
     * @var string identifier for the `SUM` summary function
     */
    const F_SUM = 'f_sum';
    /**
     * @var string identifier for the `MAX` summary function
     */
    const F_MAX = 'f_max';
    /**
     * @var string identifier for the `MIN` summary function
     */
    const F_MIN = 'f_min';
    /**
     * @var string identifier for the `AVG` summary function
     */
    const F_AVG = 'f_avg';

    /**
     * @var string
     */
    public $dataColumnClass = DataColumn::class;
    /**
     * @var array
     */
    public $tableOptions = ['class' => 'table table-striped table-hover table-bordered'];
    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     * - `{itemsPerPage}`: the items per page changer. See [[renderItemsPerPage()]].
     */
    public $layout = "{summary}\n{items}\n{pager}\n{itemsPerPage}";
    /**
     * @var array
     */
    public $itemsPerPage = [];

    /**
     * @var boolean whether to show the page summary row for the table. This will be displayed above the footer.
     */
    public $showPageSummary = false;
    /**
     * @var string location of the page summary row (whether [[POS_TOP]] or [[POS_BOTTOM]])
     */
    public $pageSummaryPosition = self::POS_BOTTOM;
    /**
     * @array the HTML attributes for the page summary container. The following special options are recognized:
     *
     * - `tag`: _string_, the tag used to render the page summary. Defaults to `tbody`.
     */
    public $pageSummaryContainer = ['class' => 'page-summary-container'];

    /**
     * @array the HTML attributes for the summary row.
     */
    public $pageSummaryRowOptions = [];

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->pager === []) {
            $this->pager = [
                'options' => ['style' => 'display:inline-block;'],
                'class' => 'vasadibt\materialdashboard\widgets\LinkPager',
            ];
        }


        if ($this->itemsPerPage !== false) {
            $this->itemsPerPage = array_replace_recursive($this->itemsPerPage, [
                'class' => BootstrapSelectPicker::class,
                'id' => 'items-per-page',
                'name' => 'per-page',
                'value' => Yii::$app->request->get('per-page', 20),
                'items' => [10 => 10, 20 => 20, 50 => 50, 100 => 100],
                'options' => ['class' => 'float-right items-per-page', 'data-width' => '100px'],
            ]);

            $this->filterSelector = $this->filterSelector ?? '#' . $this->itemsPerPage['id'];
        }
    }

    /**
     * {@inheritDoc}
     * @return string|void
     */
    public function run()
    {
        Html::addCssClass($this->options, ['widget' => 'material-grid-view']);
        GridViewAsset::register($this->getView());
        parent::run();
    }

    /**
     * {@inheritdoc}
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{itemsPerPage}':
                return $this->renderItemsPerPage();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * @return string
     */
    public function renderItemsPerPage()
    {
        if ($this->itemsPerPage === false) {
            return '';
        }

        $widget = $this->itemsPerPage;
        $class = ArrayHelper::remove($widget, 'class', BootstrapSelectPicker::class);
        return $class::widget($widget);
    }

    /**
     * Renders the table page summary.
     *
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderPageSummary()
    {
        if (!$this->showPageSummary) {
            return null;
        }
        if (!isset($this->pageSummaryRowOptions['class'])) {
            $this->pageSummaryRowOptions['class'] = 'table-primary';
        }
        $row = $this->getPageSummaryRow();
        if ($row === null) {
            return '';
        }
        $tag = ArrayHelper::remove($this->pageSummaryContainer, 'tag', 'tbody');
        $content = Html::tag('tr', $row, $this->pageSummaryRowOptions);
        return Html::tag($tag, $content, $this->pageSummaryContainer);
    }

    /**
     * Get the page summary row markup
     * @return string
     */
    protected function getPageSummaryRow()
    {
        $columns = array_values($this->columns);
        $cols = count($columns);
        if ($cols === 0) {
            return null;
        }
        $cells = [];
        $skipped = [];
        for ($i = 0; $i < $cols; $i++) {
            /** @var DataColumn $column */
            $column = $columns[$i];
            if (!method_exists($column, 'renderPageSummaryCell')) {
                $cells[] = Html::tag('td');
                continue;
            }
            $cells[] = $column->renderPageSummaryCell();
            if (!empty($column->pageSummaryOptions['colspan'])) {
                $span = (int) $column->pageSummaryOptions['colspan'];
                $dir = ArrayHelper::getValue($column->pageSummaryOptions, 'data-colspan-dir', 'ltr');
                if ($span > 0) {
                    $fm = ($dir === 'ltr') ? ($i + 1) : ($i - $span + 1);
                    $to = ($dir === 'ltr') ? ($i + $span - 1) : ($i - 1);
                    for ($j = $fm; $j <= $to; $j++) {
                        $skipped[$j] = true;
                    }
                }
            }
        }
        if (!empty($skipped )) {
            for ($i = 0; $i < $cols; $i++) {
                if (isset($skipped[$i])) {
                    $cells[$i] = '';
                }
            }
        }
        return implode('', $cells);
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function renderTableBody()
    {
        $content = parent::renderTableBody();
        if ($this->showPageSummary) {
            $summary = $this->renderPageSummary();
            return $this->pageSummaryPosition === self::POS_TOP ? ($summary . $content) : ($content . $summary);
        }
        return $content;
    }
}
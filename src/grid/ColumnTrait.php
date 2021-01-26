<?php


namespace vasadibt\materialdashboard\grid;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

trait ColumnTrait
{
    /**
     * @var boolean|string|Closure the page summary that is displayed above the footer. You can set it to one of the
     * following:
     * - `false`: the summary will not be displayed.
     * - `true`: the page summary for the column will be calculated and displayed using the
     *   [[pageSummaryFunc]] setting.
     * - `string`: will be displayed as is.
     * - `Closure`: you can set it to an anonymous function with the following signature:
     *
     *   ```php
     *   // example 1
     *   function ($summary, $data, $widget) { return 'Count is ' . $summary; }
     *   // example 2
     *   function ($summary, $data, $widget) { return 'Range ' . min($data) . ' to ' . max($data); }
     *   ```
     *
     *   where:
     *
     *   - the `$summary` variable will be replaced with the calculated summary using the [[pageSummaryFunc]] setting.
     *   - the `$data` variable will contain array of the selected page rows for the column.
     */
    public $pageSummary = false;
    /**
     * @var boolean whether to just hide the page summary display but still calculate the summary based on
     * [[pageSummary]] settings
     */
    public $hidePageSummary = false;
    /**
     * @var string|Closure the summary function that will be used to calculate the page summary for the column. If
     * setting as `Closure`, you can set it to an anonymous function with the following signature:
     *
     * ```php
     * function ($data)
     * ```
     *
     *   - the `$data` variable will contain array of the selected page rows for the column.
     */
    public $pageSummaryFunc = GridView::F_SUM;
    /**
     * @var array HTML attributes for the page summary cell. The following special attributes are available:
     * - `prepend`: _string_, a prefix string that will be prepended before the pageSummary content
     * - `append`: _string_, a suffix string that will be appended after the pageSummary content
     * - `colspan`: _int_, the column count that will be merged.
     * - `data-colspan-dir`: _string_, whether `ltr` or `rtl`. Defaults to `ltr`. If this is set to `ltr` the columns
     *    will be merged starting from this column to the right (i.e. left to right). If this is set to `rtl`, the columns
     *    will be merged starting from this column to the left (i.e. right to left).
     */
    public $pageSummaryOptions = [];
    /**
     * @var string|array|Closure in which format should the value of each data model be displayed as (e.g. `"raw"`, `"text"`, `"html"`,
     * `['date', 'php:Y-m-d']`). Supported formats are determined by the [[GridView::formatter|formatter]] used by
     * the [[GridView]]. Default format is "text" which will format the value as an HTML-encoded plain text when
     * [[\yii\i18n\Formatter]] is used as the [[GridView::$formatter|formatter]] of the GridView.
     *
     * If this is not set - it will default to the `format` setting for the Column.
     *
     * @see \yii\i18n\Formatter::format()
     */
    public $pageSummaryFormat;
    /**
     * @var array collection of row data for the column for the current page
     */
    protected $_rows = [];
    /**
     * @var Model[]
     */
    protected $_models = [];

    /**
     * Renders the page summary cell.
     *
     * @return string the rendered result
     */
    public function renderPageSummaryCell()
    {
        $prepend = ArrayHelper::remove($this->pageSummaryOptions, 'prepend', '');
        $append = ArrayHelper::remove($this->pageSummaryOptions, 'append', '');
        return Html::tag('td', $prepend . $this->renderPageSummaryCellContent() . $append, $this->pageSummaryOptions);
    }

    /**
     * Renders the page summary cell content.
     *
     * @return string the rendered result
     */
    protected function renderPageSummaryCellContent()
    {
        if ($this->hidePageSummary) {
            return $this->grid->emptyCell;
        }
        $content = $this->getPageSummaryCellContent();
        if ($this->pageSummary === true) {
            $format = isset($this->pageSummaryFormat) ? $this->pageSummaryFormat : $this->format;
            try {
                return $this->grid->formatter->format($content, $format);
            } catch (\Throwable $e) {
                return $content;
            }
        }
        return ($content === null) ? $this->grid->emptyCell : $content;
    }

    /**
     * Gets the raw page summary cell content.
     *
     * @return string the rendered result
     */
    protected function getPageSummaryCellContent()
    {
        if ($this->pageSummary === true || is_callable($this->pageSummary)) {
            $summary = $this->calculateSummary();
            return ($this->pageSummary === true) ? $summary : call_user_func(
                $this->pageSummary,
                $summary,
                $this->_rows,
                $this->_models,
                $this
            );
        }
        if ($this->pageSummary !== false) {
            return $this->pageSummary;
        }
        return null;
    }

    /**
     * Calculates the summary of an input data based on page summary aggregration function.
     *
     * @return float
     */
    protected function calculateSummary()
    {
        $type = $this->pageSummaryFunc;
        if (is_callable($type)) {
            return call_user_func($type, $this->_rows, $this->_models);
        }

        if (empty($this->_rows)) {
            return '';
        }
        $data = $this->_rows;
        switch ($type) {
            case null:
            case GridView::F_SUM:
                return array_sum($data);
            case GridView::F_COUNT:
                return count($data);
            case GridView::F_AVG:
                return count($data) > 0 ? array_sum($data) / count($data) : null;
            case GridView::F_MAX:
                return max($data);
            case GridView::F_MIN:
                return min($data);
        }
        return '';
    }

    /**
     * Store all rows for the column for the current page
     */
    protected function setPageRows()
    {
        if ($this->grid->showPageSummary && isset($this->pageSummary) && $this->pageSummary !== false &&
            !is_string($this->pageSummary)
        ) {
            $provider = $this->grid->dataProvider;
            $models = array_values($provider->getModels());
            $keys = $provider->getKeys();
            foreach ($models as $index => $model) {
                $key = $keys[$index];
                $this->_rows[] = $this->getDataCellValue($model, $key, $index);
                $this->_models[] = $model;
            }
        }
    }

}
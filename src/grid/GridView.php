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
use yii\grid\GridView as YiiGridView;
use yii\helpers\ArrayHelper;

/**
 * Class GridView
 * @package vasadibt\materialdashboard\grid
 */
class GridView extends YiiGridView
{
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
                'value' => Yii::$app->request->get('per-page', 10),
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
}
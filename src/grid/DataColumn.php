<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 02. 15.
 * Time: 10:53
 */

namespace vasadibt\materialdashboard\grid;

use vasadibt\materialdashboard\widgets\BootstrapSelectPicker;
use Yii;
use yii\base\InvalidArgumentException;
use yii\grid\DataColumn as YiiDataColumn;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class DataColumn
 * @package vasadibt\materialdashboard\grid
 *
 * @property Model|null $model
 */
class DataColumn extends YiiDataColumn
{
    use ColumnTrait;

    /**
     * @var string|array the options/settings for the filter widget. Will be used only if you set `filterType` to a widget
     * classname that exists.
     */
    public $filterWidget = [];

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->setPageRows();
    }

    /**
     * Renders filter inputs based on the `filterType`
     *
     * @return string
     * @throws \Exception
     */
    protected function renderFilterCellContent()
    {
        if(empty($this->filterWidget) && $this->format == 'boolean'){
            $this->filterWidget = [
                'class' => BootstrapSelectPicker::class,
                'prompt' => Yii::t('materialdashboard', 'All'),
                'items' => [
                    1 => Yii::t('materialdashboard', 'Yes'),
                    0 => Yii::t('materialdashboard', 'No'),
                ],
            ];
        }

        $content = parent::renderFilterCellContent();
        if ($this->filter === false || empty($this->filterWidget) || $content === $this->grid->emptyCell) {
            return $content;
        }

        /** @var \yii\base\Widget $widgetClass */
        if(is_string($this->filterWidget)){
            $widgetClass = $this->filterWidget;
            $widgetOptions = [];
        } else {
            $widgetClass = ArrayHelper::remove($this->filterWidget, 'class');
            $widgetOptions = $this->filterWidget;
        }

        $defaultOptions = [
            'model' => $this->grid->filterModel,
            'attribute' => $this->attribute,
            'options' => $this->filterInputOptions,
        ];

        $widgetOptions = array_replace_recursive($widgetOptions, $defaultOptions);

        return $widgetClass::widget($widgetOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null) {
            $value = $this->getDataCellValue($model, $key, $index);
            if (is_callable($this->format)) {
                return call_user_func($this->format, $value, $this->grid->formatter, $model, $this);
            } else {
                return $this->grid->formatter->format($value, $this->format);
            }

        }
        return parent::renderDataCellContent($model, $key, $index);
    }
}
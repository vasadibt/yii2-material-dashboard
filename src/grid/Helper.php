<?php

namespace vasadibt\materialdashboard\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Helper
{
    /**
     * @param $name
     * @param array $options
     * @return string
     */
    public static function icon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        Html::addCssClass($options, ['widget' => 'material-icons']);
        return Html::tag($tag, $name, $options);
    }

    /**
     * @return string
     */
    public static function ripple()
    {
        return Html::tag('div', '', ['class' => 'ripple-container']);
    }

    /**
     * @param $searchModel
     * @param $id
     * @param $pageSizeValues
     * @return string
     */
    public static function pageSizeSelector($searchModel, $id, $pageSizeValues)
    {
        $selectedPageSize = $searchModel->dataProvider->getPagination() ? $searchModel->dataProvider->getPagination()->pageSize : '-';

        return Html::tag(
            'div',
            Html::label('Oldal mérete', $id, ['class' => 'control-label mr-2'])
            . Html::dropDownList('per-page', $selectedPageSize, $pageSizeValues, [
                'id' => $id,
                'class' => 'form-control form-control-sm',
                'dir' => 'rtl',
            ]),
            ['class' => 'items-per-page-container']
        );
    }

    /**
     * @return string
     */
    public static function newButton($title)
    {
        return Html::a(
            static::icon('add')
            . Html::tag('span', ' ' . $title, ['class' => 'd-none d-md-inline-block'])
            . static::ripple(),
            ['create'],
            [
                'class' => 'btn btn-sm btn-success',
                'rel' => 'tooltip',
                'data-original-title' => $title,
            ]
        );
    }

    /**
     * @return string
     */
    public static function exportButton()
    {
        return Html::a(
            static::icon('file_download')
            . Html::tag('span', ' Excel exportálás', ['class' => 'd-none d-md-inline-block'])
            . static::ripple(),
            array_merge(['export'], Yii::$app->request->getQueryParams()),
            [
                'class' => 'btn btn-sm btn-info',
                'data-method' => 'post',
                'rel' => 'tooltip',
                'data-original-title' => 'Excel exportálás',
            ]
        );
    }

    /**
     * @return string
     */
    public static function resetButton()
    {
        $fixParams = array_intersect_key(
            Yii::$app->request->getQueryParams(),
            array_flip(['per-page', 'sort'])
        );

        return Html::a(
            static::icon('zoom_out')
            . Html::tag('span', ' Szűrések törlése', ['class' => 'd-none d-md-inline-block'])
            . static::ripple(),
            array_merge([''], $fixParams),
            [
                'class' => 'btn btn-sm btn-warning',
                'rel' => 'tooltip',
                'data-original-title' => 'Szűrések törlése',
            ]
        );
    }

    /**
     * @return string
     */
    public static function backButton()
    {
        return Html::a(static::icon('keyboard_arrow_left'), ['index'], [
            'class' => 'btn btn-sm btn-success btn-round btn-fab mt-3',
            'rel' => 'tooltip',
            'data-original-title' => 'Vissza',
        ]);
    }

}
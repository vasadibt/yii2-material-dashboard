<?php

namespace vasadibt\materialdashboard\helpers;

use Yii;
use yii\db\ActiveRecordInterface;

class Button
{
    /**
     * @return string
     */
    public static function new($title)
    {
        return Html::a(
            Html::icon('add') . ' ' . Html::span($title, ['class' => 'd-none d-md-inline-block']) . Html::ripple(),
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
    public static function export()
    {
        return Html::a(
            Html::icon('file_download') . ' ' . Html::span('Excel exportálás', ['class' => 'd-none d-md-inline-block']) . Html::ripple(),
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
    public static function reset()
    {
        $fixParams = array_intersect_key(
            Yii::$app->request->getQueryParams(),
            array_flip(['per-page', 'sort'])
        );

        return Html::a(
            Html::icon('zoom_out') . ' ' . Html::span('Szűrések törlése', ['class' => 'd-none d-md-inline-block']) . Html::ripple(),
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
    public static function back()
    {
        return Html::a(
            Html::icon('keyboard_arrow_left')
            . Html::span('Vissza', ['class' => 'd-none d-md-inline-block ml-2']),
            ['index'],
            [
                'class' => 'btn btn-sm btn-success btn-round mt-3',
                'rel' => 'tooltip',
                'data-original-title' => 'Vissza',
            ]
        );
    }

    /**
     * @return string
     */
    public static function delete(ActiveRecordInterface $model)
    {

        return Html::a(
            Html::icon('delete')
            . Html::span('Törlés', ['class' => 'd-none d-md-inline-block ml-2']),
            array_merge(['delete'], $model->getPrimaryKey(true)),
            [
                'class' => 'btn btn-sm btn-danger btn-round mt-3',
                'data-confirm' => 'Biztos törölni szeretnéd ezt a tételt?',
                'data-method' => 'post',
                'rel' => 'tooltip',
                'data-original-title' => 'Törlés',
            ]
        );
    }

    /**
     * @return string
     */
    public static function submit(ActiveRecordInterface $model)
    {
        return Html::submitButton(
            $model->isNewRecord ? 'Létrehozás' : 'Módosítás',
            [
                'class' => 'btn btn-fill btn-success pull-center',
            ]
        );
    }


}
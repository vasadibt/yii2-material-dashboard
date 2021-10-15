<?php

namespace vasadibt\materialdashboard\helpers;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;

class Button
{
    /**
     * @return string
     */
    public static function new($title)
    {
        return Html::a(
            Html::icon('add')
            . Html::span(' ' . $title, ['class' => 'd-none d-md-inline-block'])
            . Html::ripple(),
            ['create'],
            [
                'class' => 'btn btn-sm btn-success',
                'rel' => 'tooltip',
                'title' => $title,
                'data-original-title' => $title,
            ]
        );
    }

    /**
     * @return string
     */
    public static function export($exportUrl = null)
    {
        $exportUrl = $exportUrl ?? ['export'];

        return Html::a(
            Html::icon('file_download')
            . Html::span(' Excel exportálás', ['class' => 'd-none d-md-inline-block'])
            . Html::ripple(),
            array_merge($exportUrl, Yii::$app->request->getQueryParams()),
            [
                'class' => 'btn btn-sm btn-info',
                'data-method' => 'post',
                'rel' => 'tooltip',
                'title' => 'Excel exportálás',
                'data-original-title' => 'Excel exportálás',
            ]
        );
    }

    /**
     * @param Model|null $filterModel
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function reset(Model $filterModel = null)
    {
        $params = Yii::$app->request->getQueryParams();

        if($filterModel instanceof Model){
            unset($params[$filterModel->formName()]);
        } else {
            $params = array_intersect_key($params, array_flip(['per-page', 'sort']));
        }

        return Html::a(
            Html::icon('zoom_out')
            . Html::span(' Szűrések törlése', ['class' => 'd-none d-md-inline-block'])
            . Html::ripple(),
            array_merge([''], $params),
            [
                'class' => 'btn btn-sm btn-warning',
                'rel' => 'tooltip',
                'title' => 'Szűrések törlése',
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
            . Html::span(' Vissza', ['class' => 'd-none d-md-inline-block ml-2'])
            . Html::ripple(),
            ['index'],
            [
                'class' => 'btn btn-sm btn-success btn-round mt-3',
                'rel' => 'tooltip',
                'title' => 'Vissza',
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
            . Html::span(' Törlés', ['class' => 'd-none d-md-inline-block ml-2'])
            . Html::ripple(),
            array_merge(['delete'], $model->getPrimaryKey(true)),
            [
                'class' => 'btn btn-sm btn-danger btn-round mt-3',
                'data-confirm' => 'Biztos törölni szeretnéd ezt a tételt?',
                'data-method' => 'post',
                'rel' => 'tooltip',
                'title' => 'Törlés',
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
            ($model->isNewRecord ? 'Létrehozás' : 'Mentés')
            . Html::ripple(),
            [
                'class' => 'btn btn-fill btn-success pull-center',
            ]
        );
    }


}
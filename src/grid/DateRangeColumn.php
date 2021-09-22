<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 02. 15.
 * Time: 10:41
 */

namespace vasadibt\materialdashboard\grid;

use yii\db\ActiveRecord;
use yii\db\Expression;

class DateRangeColumn extends DataColumn
{
    public $width = '150px';
    public $filterType = \kartik\daterange\DateRangePicker::class;

    public $filterWidgetOptions = [
        'attribute' => 'created_at',
        'convertFormat' => true,
        'pluginOptions' => [
            'timePicker' => false,
            'locale' => [
                'format' => 'Y-m-d',
                'applyLabel' => 'Alkalmaz',
                'cancelLabel' => 'Mégse',
            ]
        ],
    ];

    /**
     * @param ActiveRecord $model
     * @param string $attribute
     * @param string|null $target
     * @return array
     */
    public static function filter($model, $attribute, $target = null)
    {
        $value = $model->$attribute;
        if ($value === ''
            || $value === []
            || $value === null
            || (is_string($value) && trim($value) === '')
        ) {
            return [];
        }

        $filedName = $target ?? $model::tableName() . "." . $attribute;
        $field = new Expression('DATE(' . $filedName . ')');

        if (!str_contains($value, ' - ')) {
            return [
                '=',
                $field,
                $value
            ];
        }

        list($minValue, $maxValue) = explode(" - ", $value);
        return [
            'BETWEEN',
            $field,
            $minValue,
            $maxValue
        ];
    }
}

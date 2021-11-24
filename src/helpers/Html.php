<?php

namespace vasadibt\materialdashboard\helpers;

use Yii;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;
use yii\web\User;

class Html extends \yii\bootstrap4\Html
{
    /**
     * Options add permission checker
     * Permission can be
     *  - callable
     *  - array  -> [permissionName, option => value ... etc],
     *  - string -> the permission name
     *
     * @param bool|string|null $name
     * @param string $content
     * @param array $options
     * @return false|mixed|string
     */
    public static function tag($name, $content = '', $options = [])
    {
        /** @var User $user */
        if (
            ($permission = ArrayHelper::remove($options, 'permission'))
            && ($user = Yii::$app->get('user', false))
        ) {
            if (is_callable($permission)) {
                $hasPermission = call_user_func($permission, $user, $options, $content, $name);
            }elseif (is_array($permission)) {
                $name = array_shift($permission);
                $hasPermission =  call_user_func([$user, 'can'], $name, $permission);
            } else {
                $hasPermission =  $user->can($permission);
            }

            if(!$hasPermission){
                return '';
            }
        }

        return parent::tag($name, $content, $options);
    }

    /**
     * @return string
     */
    public static function span($content = '', $option = [])
    {
        return static::tag('span', $content, $option);
    }

    /**
     * @return string
     */
    public static function div($content = '', $option = [])
    {
        return static::tag('div', $content, $option);
    }

    /**
     * @param $name
     * @param array $options
     * @return string
     */
    public static function icon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        static::addCssClass($options, ['widget' => 'material-icons']);
        return static::tag($tag, $name, $options);
    }

    /**
     * @return string
     */
    public static function ripple()
    {
        return static::div('', ['class' => 'ripple-container']);
    }

    /**
     * @param DataProviderInterface $dataProvider
     * @param $id
     * @param $pageSizeValues
     * @return string
     */
    public static function pageSizeSelector(DataProviderInterface $dataProvider, $id, $pageSizeValues)
    {
        $selectedPageSize = $dataProvider->getPagination() ? $dataProvider->getPagination()->pageSize : '-';

        return static::div(
            static::label('Oldal mérete', $id, ['class' => 'control-label mr-2'])
            . static::dropDownList('per-page', $selectedPageSize, $pageSizeValues, [
                'id' => $id,
                'class' => 'form-control form-control-sm',
                'dir' => 'rtl',
            ]),
            ['class' => 'items-per-page-container']
        );
    }

    /**
     * @param $condition
     * @param $options
     * @param $class
     */
    public static function addCssClassWhen($condition, &$options, $class)
    {
        if ($condition) {
            static::addCssClass($options, $class);
        }
    }

    /**
     * @param $condition
     * @param $options
     * @param $class
     */
    public static function removeCssClassWhen($condition, &$options, $class)
    {
        if ($condition) {
            static::removeCssClass($options, $class);
        }
    }


    /**
     * @param array $options
     * @param array $updateOptions
     */
    public static function updateOptions(&$options, $updateOptions)
    {
        if ($class = ArrayHelper::remove($updateOptions, 'class')) {
            Html::updateCssClass($options, $class);
        }

        if ($style = ArrayHelper::remove($updateOptions, 'style')) {
            Html::addCssStyle($options, $style);
        }

        static::parseOptionsData($updateOptions);
        if ($data = ArrayHelper::remove($updateOptions, 'data')) {
            Html::addCssData($options, $data);
        }

        foreach ($updateOptions as $key => $value) {
            $options[$key] = $value;
        }
    }

    /**
     * update a CSS class (or several classes) to the specified options.
     *
     * If the CSS class is already in the options, it will not be added again.
     * If class specification at given options is an array, and some class placed there with the named (string) key,
     * overriding of such key will have no effect. For example:
     *
     * ```php
     * $options = ['class' => ['persistent' => 'initial']];
     * Html::addCssClass($options, ['persistent' => 'override']);
     * var_dump($options['class']); // outputs: array('persistent' => 'override');
     * ```
     *
     * @param array $options the options to be modified.
     * @param string|array $class the CSS class(es) to be added
     * @see upgradeCssClasses()
     * @see cssClassToArray()
     */
    public static function updateCssClass(&$options, $class)
    {
        if (!isset($options['class'])) {
            $options['class'] = $class;
            return;
        }

        if (!is_array($options['class']) && !is_array($class)) {
            $options['class'] .= ' ' . $class;
            return;
        }

        $options['class'] = self::upgradeCssClasses(
            static::cssClassToArray($options['class']),
            static::cssClassToArray($class)
        );
    }

    /**
     * Merges already existing CSS classes with new one.
     * This method provides the priority for named existing classes over additional.
     * @param array $existingClasses already existing CSS classes.
     * @param array $additionalClasses CSS classes to be added.
     * @return array merge result.
     * @see addCssClass()
     */
    private static function upgradeCssClasses(array $existingClasses, array $additionalClasses)
    {
        foreach ($additionalClasses as $key => $class) {
            if (is_int($key) && !in_array($class, $existingClasses)) {
                $existingClasses[] = $class;
            } else {
                if ($class === null || $class === false) {
                    unset($existingClasses[$key]);
                } else {
                    $existingClasses[$key] = $class;
                }
            }
        }

        return array_unique($existingClasses);
    }

    /**
     * @param string|array $class
     * @return array
     */
    public static function cssClassToArray($class)
    {
        if (is_array($class)) {
            return $class;
        }

        return preg_split('/\s+/', $class, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param array $options
     */
    public static function parseOptionsData(&$options)
    {
        foreach ($options as $key => $value) {
            if (substr($key, 0, 5) == 'data-') {
                if (!isset($options['data'])) {
                    $options['data'] = [];
                }
                $options['data'][substr($key, 5)] = $value;
                unset($options[$key]);
            }
        }
    }

    /**
     * @param array $options
     * @param array $data
     */
    public static function addCssData(&$options, array $data)
    {
        if (!isset($options['data'])) {
            $options['data'] = [];
        }

        foreach ($data as $key => $value) {
            $options['data'][$key] = $value;
        }
    }
}
<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace vasadibt\materialdashboard\generators\crud;

use yii\gii\generators\crud\Generator as GiiCrudGenerator;

/**
 * Class Generator
 * @package vasadibt\materialdashboard\generators\crud
 */
class Generator extends GiiCrudGenerator
{
    /**
     * @var bool
     */
    public $enablePjax = true;
    /**
     * @var string
     */
    public $messageCategory = 'materialdashboard';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Material CRUD Generator';
    }
}

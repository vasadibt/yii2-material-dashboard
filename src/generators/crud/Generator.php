<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace vasadibt\materialdashboard\generators\crud;

use kartik\builder\Form;
use yii\db\Schema;
use yii\gii\generators\crud\Generator as GiiCrudGenerator;

/**
 * Class Generator
 * @package vasadibt\materialdashboard\generators\crud
 */
class Generator extends GiiCrudGenerator
{
    const SIMPLE = 'simple';
    /**
     * @var bool
     */
    public $enablePjax = true;
    /**
     * @var string
     */
    public $messageCategory = 'materialdashboard';

    public $htmlHelperClass = 'vasadibt\materialdashboard\helpers\Html';
    public $buttonHelperClass = 'vasadibt\materialdashboard\helpers\Button';
    public $activeFormClass = 'vasadibt\materialdashboard\widgets\ActiveForm';
    public $gridViewClass = 'vasadibt\materialdashboard\grid\GridView';
    public $formBuilderClass = 'kartik\builder\Form';
    public $searchModelInterface = 'vasadibt\materialdashboard\interfaces\SearchModelInterface';
    public $spreadsheetBuilder = 'yii2tech\spreadsheet\Spreadsheet';

    public $skipGridFields = ['created_at', 'updated_at', 'deleted_at', 'last_login', 'created_by', 'updated_by'];
    public $skipFormFields = ['created_at', 'updated_at', 'deleted_at', 'last_login', 'created_by', 'updated_by'];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Material CRUD Generator';
    }

    /**
     * Generates search conditions
     * @return array
     */
    public function getSearchConditions()
    {
        $columns = [];
        if (($table = $this->getTableSchema()) === false) {
            $class = $this->modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ($model->attributes() as $attribute) {
                $columns[$attribute] = 'unknown';
            }
        } else {
            foreach ($table->columns as $column) {
                $columns[$column->name] = $column->type;
            }
        }

        $conditions = [];
        foreach ($columns as $column => $type) {
            switch ($type) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $conditions[$column] = static::SIMPLE;
                    break;
                default:
                    $conditions[$column] = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                    break;
            }
        }

        return $conditions;
    }

    /**
     * Generates column format
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateFormFormat($column)
    {
        if ($column->phpType === 'boolean') {
            return 'Form::INPUT_CHECKBOX';
        }

        if ($column->type === 'text') {
            return 'Form::INPUT_TEXTAREA';
        }

        return 'Form::INPUT_TEXT';
    }
}

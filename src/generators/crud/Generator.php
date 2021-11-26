<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace vasadibt\materialdashboard\generators\crud;

use spec\Prophecy\Doubler\Generator\Node\ReturnTypeNodeSpec;
use yii\base\NotSupportedException;
use yii\db\ColumnSchema;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\generators\crud\Generator as GiiCrudGenerator;
use yii\helpers\Inflector;

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
    public $activeFormClass = 'vasadibt\materialdashboard\widgets\ActiveForm';
    public $gridViewClass = 'vasadibt\materialdashboard\grid\GridView';
    public $formBuilderClass = 'kartik\builder\Form';
    public $cardWidgetClass = 'vasadibt\materialdashboard\widgets\Card';


    public $buttonDeleteWidgetClass = 'vasadibt\materialdashboard\widgets\buttons\Delete';
    public $buttonBackWidgetClass = 'vasadibt\materialdashboard\widgets\buttons\Back';
    public $buttonSubmitWidgetClass = 'vasadibt\materialdashboard\widgets\buttons\Submit';
    public $buttonCreateWidgetClass = 'vasadibt\materialdashboard\widgets\buttons\Create';


    public $searchModelInterface = 'vasadibt\materialdashboard\interfaces\SearchModelInterface';
    public $searchModelTrait = 'vasadibt\materialdashboard\traits\SearchModelTrait';
    public $spreadsheetBuilder = 'yii2tech\spreadsheet\Spreadsheet';

    public $skipGridFields = ['auth_key', 'password_hash', 'password_reset_token', 'verification_token', 'password', 'api_key', 'api_token'];
    public $skipFormFields = ['created_at', 'updated_at', 'deleted_at', 'last_login', 'created_by', 'updated_by'];

    public $modelsNamespace = '\common\models';
    public $classNames = [];
    public $nameAttributes = ['name', 'title', 'megnevezes'];

    /**
     * {@inheritdoc}     */
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

    public function getAutoFilters()
    {
        $autoFilters = [
            'equal' => [],
            'like' => [],
            'date' => [],
        ];

        foreach ($this->getTableSchema()->columns as $column) {
            switch ($column->type) {
                case Schema::TYPE_DATE:
                case Schema::TYPE_DATETIME:
                    $autoFilters ['date'][] = $column->name;
                    break;
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_TIME:
                case Schema::TYPE_TIMESTAMP:
                    $autoFilters ['equal'][] = $column->name;
                    break;
                default:
                    $autoFilters ['like'][] = $column->name;
                    break;
            }
        }

        foreach ($autoFilters as $type => $attributes){
            if(empty($attributes)){
                unset($autoFilters[$type]);
            }
        }

        return $autoFilters;
    }

    /**
     * @return \yii\db\Connection|null
     */
    protected function getDb()
    {
        if (is_subclass_of($this->modelClass, '\yii\db\ActiveRecord')) {
            $class = $this->modelClass;
            $db = $class::getDb();
            if ($db instanceof \yii\db\Connection) {
                return $db;
            }
        }

        return null;
    }

    /**
     * @param ColumnSchema $column
     * @return bool
     */
    public function isForeignColumn(ColumnSchema $column)
    {
        foreach ($this->getTableSchema()->foreignKeys as $foreignKey) {
            if (isset($foreignKey[$column->name])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param ColumnSchema $column
     * @return string|null
     */
    public function getRelationName(ColumnSchema $column)
    {
        $key = $column->name;

        if (!empty($key) && strcasecmp($key, 'id')) {
            if (substr_compare($key, 'id', -2, 2, true) === 0) {
                $key = rtrim(substr($key, 0, -2), '_');
            } elseif (substr_compare($key, 'id_', 0, 3, true) === 0) {
                $key = ltrim(substr($key, 3, strlen($key)), '_');
            }
        }

        return lcfirst(Inflector::id2camel($key, '_'));
    }

    /**
     * @param ColumnSchema $column
     * @return \yii\db\TableSchema
     * @throws NotSupportedException
     */
    public function getForeignTableSchema(ColumnSchema $column)
    {
        $foreign = null;
        foreach ($this->getTableSchema()->foreignKeys as $foreignKey) {
            if (isset($foreignKey[$column->name])) {
                $foreign = $foreignKey;
            }
        }

        return $this->getDb()
            ->getSchema()
            ->getTableSchema($foreign[0]);
    }

    /**
     * @param ColumnSchema $column
     * @return string
     */
    public function getModelClass(TableSchema $table)
    {
        if (!isset($this->classNames[$table->name])) {
            $this->classNames[$table->name] = $this->modelsNamespace . '\\' . Inflector::id2camel($table->name, '_');
        }

        return $this->classNames[$table->name];
    }

    /**
     * @param TableSchema $table
     * @return mixed|string
     */
    public function getTableNameAttribute(TableSchema $table)
    {
        $nameAttributes = array_map('strtolower', $this->nameAttributes);

        foreach ($table->getColumnNames() as $name) {
            if (in_array(strtolower($name), $nameAttributes)) {
                return $name;
            }
        }

        return $table->primaryKey[0];
    }

    /**
     * @param ColumnSchema $column
     * @return bool
     */
    public function isEnum(ColumnSchema $column)
    {
        return strtolower(substr($column->dbType, 0, 4)) == 'enum';
    }

    /**
     * @param ColumnSchema $column
     * @return string
     */
    public function getEnumLabel(ColumnSchema $column)
    {
        $column_camel_name = str_replace(' ', '', ucwords(implode(' ', explode('_', $column->name))));
        return lcfirst($column_camel_name) . 'Label';
    }

    /**
     * @param ColumnSchema $column
     * @return string
     */
    public function getEnumFunction(ColumnSchema $column)
    {
        $column_camel_name = str_replace(' ', '', ucwords(implode(' ', explode('_', $column->name))));
        return lcfirst($column_camel_name . 'Labels');
    }
}

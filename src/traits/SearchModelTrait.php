<?php

namespace vasadibt\materialdashboard\traits;

use vasadibt\materialdashboard\interfaces\SearchModelInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\QueryInterface;
use yii\web\Request;

trait SearchModelTrait
{
    /**
     * @var string[]|callable|QueryInterface
     */
    public $_query = [parent::class, 'find'];
    /**
     * @var Pagination|array|false|null
     */
    public $pagination;
    /**
     * @var Sort|array|false|null
     */
    public $sort;
    /**
     * @var DataProviderInterface
     */
    protected $_dataProvider;

    /**
     * @param Request $request
     * @param array $attributes
     * @return SearchModelInterface|static
     */
    public static function createByRequest(Request $request, array $attributes = [])
    {
        /** @var SearchModelInterface $searchModel */
        $attributes['class'] = static::class;
        $searchModel = \Yii::createObject($attributes);
        return $searchModel->search($request);
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function search(Request $request): SearchModelInterface
    {
        /** @var Model|SearchModelTrait $this */

        $this->setDataProvider(
            $this->createDataProvider($request)
        );

        $this->load($request->getQueryParams());

        if (!$this->validate()) {
            return $this;
        }

        if (($query = $this->getQuery()) instanceof QueryInterface) {
            $this->filterQuery($query);
        }

        return $this;
    }

    /**
     * Get Search model built DataProvider object
     *
     * @return DataProviderInterface
     */
    public function getDataProvider(): DataProviderInterface
    {
        return $this->_dataProvider;
    }

    /**
     * Set Search model built DataProvider object
     *
     * @param DataProviderInterface $dataProvider
     */
    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->_dataProvider = $dataProvider;
    }

    /**
     * Create DataProvider object
     *
     * @param Request $request
     * @return DataProviderInterface
     */
    public function createDataProvider(Request $request)
    {
        return new ActiveDataProvider([
            'query' => $this->createQuery(),
            'pagination' => $this->createPagination($request),
            'sort' => $this->createSort(),
        ]);
    }

    /**
     * @return QueryInterface
     */
    public function createQuery()
    {
        return is_callable($this->_query)
            ? call_user_func($this->_query, $this)
            : $this->_query;
    }

    /**
     * @param Request $request
     * @return Pagination|array|false
     */
    public function createPagination(Request $request)
    {
        return $this->pagination ?? ($request->get('per-page') == '-' ? false : []);
    }

    /**
     * @return Sort|array|false
     */
    public function createSort()
    {
        return $this->sort ?? [];
    }
}
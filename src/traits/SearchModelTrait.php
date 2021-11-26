<?php

namespace vasadibt\materialdashboard\traits;

use http\Exception\RuntimeException;
use vasadibt\materialdashboard\grid\DateRangeColumn;
use vasadibt\materialdashboard\interfaces\SearchModelInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\QueryInterface;
use yii\web\Request;

/**
 * @method array autoFilters()
 */
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
        $attributes['class'] = get_called_class();
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
     * @return SearchModelInterface
     */
    public function search(Request $request): SearchModelInterface
    {
        /** @var Model|SearchModelTrait $this */

        $this->setDataProvider(
            $dataProvider = $this->createDataProvider($request)
        );

        $this->load($request->getQueryParams());

        if (!$this->validate()) {
            return $this;
        }

        if ($dataProvider instanceof ActiveDataProvider) {
            if (method_exists($this, 'autoFilters')) {
                $this->autoFilterQuery(
                    $dataProvider->query,
                    $this->autoFilters()
                );
            }

            if (method_exists($this, 'filterQuery')) {
                $this->filterQuery($dataProvider->query);
            }
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

    /**
     * @param QueryInterface $query
     * @param $autoFilters
     */
    public function autoFilterQuery(QueryInterface $query, $autoFilters)
    {
        foreach ($autoFilters as $filter => $attributes) {
            $filterMethod = $filter . 'Filter';

            if (!method_exists($this, $filterMethod)) {
                throw new RuntimeException('Filter method "' . $filterMethod . '"does not exists in "' . get_class($this) . '"!');
            }

            foreach ($attributes as $key => $attribute) {
                $this->$filterMethod($query, $attribute, !is_numeric($key) ? $key : null);
            }
        }
    }

    /**
     * @param QueryInterface $query
     * @param $attribute
     * @param null $alias
     */
    public function equalFilter(QueryInterface $query, $attribute, $alias = null)
    {
        $query->andFilterWhere([$alias ?? $attribute => $this->$attribute]);
    }

    /**
     * @param QueryInterface $query
     * @param $attribute
     * @param null $alias
     */
    public function likeFilter(QueryInterface $query, $attribute, $alias = null)
    {
        $query->andFilterWhere(['like', $alias ?? $attribute, $this->$attribute]);
    }

    /**
     * @param QueryInterface $query
     * @param $attribute
     * @param null $alias
     */
    public function dateFilter(QueryInterface $query, $attribute, $alias = null)
    {
        $query->andFilterWhere(DateRangeColumn::filter($this, $attribute, $alias));
    }
}
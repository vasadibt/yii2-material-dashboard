<?php

namespace vasadibt\materialdashboard\interfaces;

use yii\data\DataProviderInterface;
use yii\db\QueryInterface;
use yii\web\Request;

/**
 * Interface SearchModelInterface
 * @package vasadibt\materialdashboard\interfaces
 */
interface SearchModelInterface
{
    /**
     * @param Request $request
     * @return $this
     */
    public function search(Request $request): self;

    /**
     * @return DataProviderInterface
     */
    public function getDataProvider(): DataProviderInterface;

    /**
     * @param QueryInterface $query
     * @return $this
     */
    public function filterQuery(QueryInterface $query): self;
}
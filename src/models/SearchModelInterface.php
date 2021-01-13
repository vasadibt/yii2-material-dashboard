<?php


namespace vasadibt\materialdashboard\models;


use yii\data\DataProviderInterface;
use yii\db\ActiveQueryInterface;
use yii\web\Request;

/**
 * Interface SearchModelInterface
 * @package vasadibt\materialdashboard\models
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
     * @param ActiveQueryInterface $query
     * @return $this
     */
    public function filterQuery($query): self;
}
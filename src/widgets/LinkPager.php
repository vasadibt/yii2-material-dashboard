<?php


namespace vasadibt\materialdashboard\widgets;

use Yii;
use yii\bootstrap4\LinkPager as YiiBootstrap4LinkPager;

/**
 * Class LinkPager
 * @package vasadibt\materialdashboard\widgets
 */
class LinkPager extends YiiBootstrap4LinkPager
{
    /**
     * @var null
     */
    public $firstPageLabel = null;
    /**
     * @var null
     */
    public $prevPageLabel = null;
    /**
     * @var null
     */
    public $nextPageLabel = null;
    /**
     * @var null
     */
    public $lastPageLabel = null;
    /**
     * @var null
     */
    public $maxButtonCount = null;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->firstPageLabel = $this->firstPageLabel ?? Yii::t('materialdashboard', 'First');
        $this->prevPageLabel = $this->prevPageLabel ?? Yii::t('materialdashboard', 'Prev');
        $this->nextPageLabel = $this->nextPageLabel ?? Yii::t('materialdashboard', 'Next');
        $this->lastPageLabel = $this->lastPageLabel ?? Yii::t('materialdashboard', 'Last');
        $this->maxButtonCount = $this->maxButtonCount ?? 9;
    }
}
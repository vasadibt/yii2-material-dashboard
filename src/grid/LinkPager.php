<?php

namespace vasadibt\materialdashboard\grid;

use Yii;
use yii\helpers\ArrayHelper;

class LinkPager extends \vasadibt\materialdashboard\widgets\LinkPager
{
    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false && $currentPage > 0) {
            $buttons[] = $this->renderPageButton(
                $firstPageLabel,
                0,
                $this->firstPageCssClass,
                $currentPage <= 0,
                false
            );
        }

        // prev page
        if ($this->prevPageLabel !== false && $currentPage > 0) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton(
                $this->prevPageLabel,
                $page,
                $this->prevPageCssClass,
                $currentPage <= 0,
                false
            );
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton(
                $i + 1,
                $i,
                null,
                $this->disableCurrentPageButton && $i == $currentPage,
                $i == $currentPage
            );
        }

        // next page
        if ($this->nextPageLabel !== false && $currentPage < $pageCount - 1) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton(
                $this->nextPageLabel,
                $page,
                $this->nextPageCssClass,
                $currentPage >= $pageCount - 1,
                false
            );
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false && $currentPage < $pageCount - 1) {
            $buttons[] = $this->renderPageButton(
                $lastPageLabel,
                $pageCount - 1,
                $this->lastPageCssClass,
                $currentPage >= $pageCount - 1,
                false
            );
        }

        $options = $this->listOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        return Yii::$app->material->helperHtml::tag($tag, implode("\n", $buttons), $options);
    }
}
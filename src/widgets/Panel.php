<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\helpers\Html;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Tabs;
use yii\helpers\ArrayHelper;


class Panel extends Tabs
{
    use WidgetTrait;

    const TYPE_HORIZONTAL = 'horizontal';
    const TYPE_VERTICAL = 'vertical';

    const TEMPLATES = [
        self::TYPE_HORIZONTAL => <<< HTML
{nav}
{panes}
HTML,
        self::TYPE_VERTICAL => <<< HTML
<div class="row">
    <div class="col-md-3">
        {nav}
    </div>
    <div class="col-md-9 ">
        {panes}
    </div>
</div>
HTML,
    ];

    public $type = self::TYPE_HORIZONTAL;
    public $template;
    public $navType = 'nav-pills';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if ($this->type == static::TYPE_VERTICAL) {
            Html::addCssClass($this->options, 'flex-column');
        }
    }

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     * @throws \Exception
     */
    public function run()
    {
        $this->registerPlugin('tab');

        $template = $this->template ?? static::TEMPLATES[$this->type];

        $this->prepareItems($this->items);

        return strtr($template, [
            '{nav}' => $this->renderNav(),
            '{panes}' => $this->renderPanes($this->panes),
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function renderNav()
    {
        return Nav::widget([
            'dropdownClass' => $this->dropdownClass,
            'options' => ArrayHelper::merge(['role' => 'tablist'], $this->options),
            'items' => $this->items,
            'encodeLabels' => $this->encodeLabels,
        ]);
    }
}
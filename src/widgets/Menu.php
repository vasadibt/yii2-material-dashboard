<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\assets\MaterialAsset;
use vasadibt\materialdashboard\helpers\Html;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class Menu
 * @package vasadibt\materialdashboard\widgets
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @var string submenu id prefix
     */
    public static $submenuPrefix = 'submenu-';
    /**
     * @var int Submenu id counter
     */
    public static $submenuCounter = 0;
    /**
     * @inheritdoc
     */
    public $options = ['class' => 'nav'];
    /**
     * @inheritdoc
     */
    public $itemOptions = ['class' => 'nav-item'];
    /**
     * @inheritdoc
     */
    public $linkTemplate = <<<HTML
<a class="nav-link" href="{url}">
    {icon} <p>{label}</p>
</a>
HTML;
    /**
     * @inheritdoc
     */
    public $parentLinkTemplate = <<<HTML
<a class="nav-link" data-toggle="collapse" href="{url}">
    {icon} <p>{label} {dropdownicon}</p>
</a>
HTML;
    /**
     * @var string
     */
    public $submenuTemplate = <<<HTML
<div class="collapse {show}" id="{id}">
    <ul class="nav">\n{items}\n</ul>
</div>
HTML;
    /**
     * @inheritdoc
     */
    public $activateParents = true;
    /**
     * @var string Dropdown icon
     */
    public $dropdownIcon = '<b class="caret"></b>';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        MaterialAsset::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {
        $icon = isset($item['icon'])
            ? '<i class="material-icons">' . $item['icon'] . '</i>'
            : '';

        if (isset($item['items'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->parentLinkTemplate);
            return strtr($template, [
                '{label}' => $item['label'],
                '{icon}' => $icon,
                '{dropdownicon}' => $this->dropdownIcon,
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        $url = Url::to(isset($item['url']) ? $item['url'] : '#');
        return strtr($template, [
            '{url}' => $url,
            '{label}' => $item['label'],
            '{icon}' => $icon,
            '{dropdownicon}' => $this->dropdownIcon,
        ]);
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);

            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $submenuId = static::getSubmenuUniqueId();

                $menu = strtr($menu, [
                    '{url}' => '#' . $submenuId,
                ]);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                    '{show}' => $item['active'] ? 'show' : '',
                    '{id}' => $submenuId,
                ]);
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }

    /**
     * @inheritdoc
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            $arrayRoute = explode('/', ltrim($route, '/'));
            $arrayThisRoute = explode('/', $this->route);
            if ($arrayRoute[0] !== $arrayThisRoute[0]) {
                return false;
            }
            if (isset($arrayRoute[1]) && $arrayRoute[1] !== $arrayThisRoute[1]) {
                return false;
            }
            if (isset($arrayRoute[2]) && $arrayRoute[2] !== $arrayThisRoute[2]) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Returns the ID of the submenu.
     * @return string ID of the widget.
     */
    public function getSubmenuUniqueId()
    {
        return static::$submenuPrefix . static::$submenuCounter++;
    }
}

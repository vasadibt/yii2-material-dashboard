<?php

namespace vasadibt\materialdashboard\widgets;

use vasadibt\materialdashboard\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/**
 * @property array $containerOptions
 * @property array $headerOptions
 * @property array $iconContainerOptions
 * @property array $iconOptions
 * @property array $titleOptions
 * @property array $buttonOptions
 * @property array $bodyOptions
 * @property array $footerOptions
 */
class Card extends BaseWidget
{
    /**
     * @var string
     */
    public $icon;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string|array
     */
    public $buttons = [];
    /**
     * @var string
     */
    public $body = '';
    /**
     * @var
     */
    public $footer;
    /**
     * @var boolean whether the grid view will be rendered within a pjax container. Defaults to `false`. If set to
     * `true`, the entire GridView widget will be parsed via Pjax and auto-rendered inside a yii\widgets\Pjax
     * widget container. If set to `false` pjax will be disabled and none of the pjax settings will be applied.
     */
    public $pjax = false;
    /**
     * @var array the pjax settings for the widget. This will be considered only when [[pjax]] is set to true. The
     * following settings are recognized:
     * - `neverTimeout`: `boolean`, whether the pjax request should never timeout. Defaults to `true`. The pjax:timeout
     *   event will be configured to disable timing out of pjax requests for the pjax container.
     * - `options`: _array_, the options for the [[\yii\widgets\Pjax]] widget.
     * - `loadingCssClass`: boolean/string, the CSS class to be applied to the grid when loading via pjax. If set to
     *   `false` - no css class will be applied. If it is empty, null, or set to `true`, will default to
     *   `kv-grid-loading`.
     * - `beforeGrid`: _string_, any content to be embedded within pjax container before the Grid widget.
     * - `afterGrid`: _string_, any content to be embedded within pjax container after the Grid widget.
     */
    public $pjaxSettings = [];
    /**
     * @var string[]
     */
    protected $attributeMap = [
        'containerOptions' => '_containerOptions',
        'headerOptions' => '_headerOptions',
        'iconContainerOptions' => '_iconContainerOptions',
        'iconOptions' => '_iconOptions',
        'titleOptions' => '_titleOptions',
        'buttonOptions' => '_buttonOptions',
        'bodyOptions' => '_bodyOptions',
        'footerOptions' => '_footerOptions',
    ];

    protected $_containerOptions = [
        'class' => [
            'widget' => 'card',
            'type' => 'card-default',
        ],
    ];
    protected $_headerOptions = [
        'class' => [
            'widget' => 'card-header',
            'type' => 'card-header-icon',
        ],
    ];
    protected $_iconContainerOptions = [
        'class' => [
            'widget' => 'card-icon',
            'display' => 'd-none d-sm-block',
        ],
    ];
    protected $_iconOptions = [
        'class' => [
            'widget' => 'material-icons',
        ],
    ];
    protected $_titleOptions = [
        'class' => [
            'widget' => 'card-title',
            'display' => 'd-inline-block',
        ],
    ];
    protected $_buttonOptions = [
        'class' => [
            'direction' => 'float-right',
            'margin' => 'mt-1',
        ],
    ];
    protected $_bodyOptions = [
        'class' => [
            'widget' => 'card-body',
        ],

    ];
    protected $_footerOptions = [
        'class' => [
            'widget' => 'card-footer',
        ],
    ];

    /** methods * */
    public function init()
    {
        parent::init();
        /** start capturing output buffer */
        ob_start();

        if (empty($this->_containerOptions['id'])) {
            $this->_containerOptions['id'] = $this->getId();
        }
    }

    /**
     * Get pjax container identifier
     * @return string
     */
    public function getPjaxContainerId()
    {
        if (empty($this->pjaxSettings['options']['id'])) {
            $this->pjaxSettings['options']['id'] = $this->_containerOptions['id'] . '-pjax';
        }

        return $this->pjaxSettings['options']['id'];
    }

    /**
     * Begins the pjax widget rendering
     */
    protected function beginPjax()
    {
        $selector = '#' . $this->getPjaxContainerId(); // Must be generate PJAX id value

        if (
            ($neverTimeout = ArrayHelper::getValue($this->pjaxSettings, 'neverTimeout', true))
            || ($loadingCss = ArrayHelper::getValue($this->pjaxSettings, 'loadingCssClass', 'card-loading'))
        ) {

            $js = "jQuery(\"$selector\")";

            if ($neverTimeout) {
                $js .= "\n.on('pjax:timeout', function(e){ e.preventDefault(); })";
            }

            if ($loadingCss) {
                $pjaxContainer = "$(\"$selector\")";
                $js .= "\n.on('pjax:send', function(){ $pjaxContainer.addClass('$loadingCss'); })";

                $postPjaxJs = "$pjaxContainer.removeClass('$loadingCss');";
                $event = 'pjax:complete.' . hash('crc32', $postPjaxJs);
                $js .= "\n.off('{$event}')";
                $js .= "\n.on('{$event}', function(){ $postPjaxJs })";
            }

            $this->getView()->registerJs($js . ';');
        }


        Pjax::begin($this->pjaxSettings['options']);
        echo '<div class="kv-loader-overlay"><div class="kv-loader"></div></div>';
        // echo '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        echo ArrayHelper::getValue($this->pjaxSettings, 'beforeGrid', '');
    }

    /**
     * Completes the pjax widget rendering
     */
    protected function endPjax()
    {
        echo ArrayHelper::getValue($this->pjaxSettings, 'afterGrid', '');
        Pjax::end();
    }

    /**
     * @return string|void
     */
    public function run()
    {
        $inline = ob_get_clean();

        if ($this->pjax) {
            $this->beginPjax();
        }

        echo Html::beginTag('div', $this->_containerOptions);

        /** Heading */
        if (!empty($this->icon) || !empty($this->title) || !empty($this->buttons)) {
            echo Html::beginTag('div', $this->_headerOptions);

            if (!empty($this->icon)) {
                $iconTag = ArrayHelper::remove($this->_iconOptions, 'tag', 'i');
                echo Html::tag(
                    'div',
                    Html::tag($iconTag, $this->icon, $this->_iconOptions),
                    $this->_iconContainerOptions
                );
            }

            if (!empty($this->title)) {
                $titleTag = ArrayHelper::remove($this->_titleOptions, 'tag', 'h5');
                echo Html::tag($titleTag, Html::encode($this->title), $this->_titleOptions);
            }

            if (!empty($this->buttons)) {
                echo Html::tag('div', is_array($this->buttons) ? join($this->buttons) : $this->buttons, $this->_buttonOptions);
            }
            echo Html::endTag('div');
        }

        /** body */
        echo Html::beginTag('div', $this->_bodyOptions);
        echo $this->body;
        echo $inline;
        echo Html::endTag('div');

        /** footer */
        if (isset($this->footer)) {
            echo Html::tag('div', is_array($this->footer) ? join($this->footer) : $this->footer, $this->_footerOptions);
        }
        echo Html::endTag('div');

        if ($this->pjax) {
            $this->endPjax();
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributeMap)) {
            return $this->{$this->attributeMap[$name]};
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \yii\base\UnknownPropertyException
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->attributeMap)) {
            Html::updateOptions($this->{$this->attributeMap[$name]}, $value);
            return;
        }
        parent::__set($name, $value);
    }

}
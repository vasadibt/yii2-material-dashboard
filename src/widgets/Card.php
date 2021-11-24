<?php

namespace vasadibt\materialdashboard\widgets;

use yii\bootstrap4\Widget;
use vasadibt\materialdashboard\helpers\Html;
use yii\helpers\ArrayHelper;

class Card extends Widget
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
    }

    /**
     * @return string
     */
    public function run()
    {
        $inline = ob_get_clean();

        $out = Html::beginTag('div', $this->_containerOptions);

        /** Heading */
        if (!empty($this->icon) || !empty($this->title) || !empty($this->buttons)) {
            $out .= Html::beginTag('div', $this->_headerOptions);

            if (!empty($this->icon)) {
                $iconTag = ArrayHelper::remove($this->_iconOptions, 'tag', 'i');
                $out .= Html::tag(
                    'div',
                    Html::tag($iconTag, $this->icon, $this->_iconOptions),
                    $this->_iconContainerOptions
                );
            }

            if (!empty($this->title)) {
                $titleTag = ArrayHelper::remove($this->_titleOptions, 'tag', 'h5');
                $out .= Html::tag($titleTag, Html::encode($this->title), $this->_titleOptions);
            }

            if (!empty($this->buttons)) {
                $out .= Html::tag('div', is_array($this->buttons) ? join($this->buttons) : $this->buttons, $this->_buttonOptions);
            }
            $out .= Html::endTag('div');
        }

        /** body */
        $out .= Html::tag('div', $this->body . $inline, $this->_bodyOptions);


        /** footer */
        if (isset($this->footer)) {
            $out .= Html::tag('div', is_array($this->footer) ? join($this->footer) : $this->footer, $this->_footerOptions);
        }
        $out .= Html::endTag('div');
        return $out;
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
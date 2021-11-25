<?php

namespace vasadibt\materialdashboard\widgets\buttons;

use Yii;
use yii\db\ActiveRecordInterface;
use function Webmozart\Assert\Tests\StaticAnalysis\email;

class Submit extends Button
{
    public $icon = 'save';
    public $title;
    protected $_options = [
        'class' => [
            'widget' => '{{optionWidget}}',
            'size' => '{{optionSize}}',
            'type' => '{{optionType}}',
            'style' => '{{optionStyle}}',
            'position' => '{{optionPosition}}'
        ],
        'type' => 'submit',
        'form' => '{{form}}'
    ];
    public $optionType = 'btn-success';

    /**
     * @var ActiveRecordInterface
     */
    public $model;
    public $createTitle;
    public $updateTitle;
    public $form;


    public function init()
    {
        parent::init();
        if ($this->title === null) {
            if ($this->model && $this->model->isNewRecord) {
                $this->title = $this->createTitle ?? Yii::t('materialdashboard', 'Create');
            } else {
                $this->title = $this->updateTitle ?? Yii::t('materialdashboard', 'Save');
            }
        }

        if (empty($this->form) && isset($this->_options['form']) && $this->_options['form'] == '{{form}}'){
            unset($this->_options['form']);
        }
    }
}
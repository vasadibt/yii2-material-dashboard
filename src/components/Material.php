<?php

namespace vasadibt\materialdashboard\components;

use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\web\View;

class Material extends Component implements BootstrapInterface
{
    public $appAssetClass;

    /**
     * {@inheritDoc}
     */
    public function bootstrap($app)
    {
        $this->registerTranslates($app, 'materialdashboard');
    }

    /**
     * Register application translates
     *
     * @param \yii\base\Application $app
     */
    public function registerTranslates($app, $category)
    {
        if (!isset($app->i18n->translations[$category])) {
            $app->i18n->translations[$category] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'fileMap' => [$category => "$category.php"],
            ];
        }
    }

    /**
     * @param View $view
     */
    public function register(View $view)
    {
        if (!empty($appAssetClass = $this->appAssetClass)) {
            $appAssetClass::register($view);
        }
    }
}
<?php

namespace vasadibt\materialdashboard;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package vasadibt\materialdashboard
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var bool
     */
    public $autoSetLayout = true;
    /**
     * @var mixed|object|null
     */
    public $autoErrorPage = true;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $app = Yii::$app;

        if ($app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'vasadibt\materialdashboard\commands';
            $this->registerTranslates($app);
        }

        parent::init();
    }

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            Yii::$container->set('yii\web\User', [
                'enableAutoLogin' => true,
                'loginUrl' => ['/' . $this->id . '/sign-in/login'],
            ]);

            if ($this->autoSetLayout) {
                $app->layout = '@vasadibt/materialdashboard/views/layouts/'
                    . ($app->user->getIsGuest() ? 'base' : 'common');
            }

            if($this->autoErrorPage){
                $app->errorHandler->errorAction = $this->id . '/error/index';
            }

            $this->registerTranslates($app);
        }
    }

    /**
     * @param Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function registerTranslates($app)
    {
        if (!isset($app->get('i18n')->translations['materialdashboard'])) {
            $app->get('i18n')->translations['materialdashboard'] = [
                'class' => \yii\i18n\PhpMessageSource::class,
                'basePath' => '@vasadibt/materialdashboard/messages',
            ];
        }
    }
}
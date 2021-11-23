<?php

namespace vasadibt\materialdashboard\components;

use vasadibt\materialdashboard\widgets\buttons\Back;
use vasadibt\materialdashboard\widgets\buttons\Create;
use vasadibt\materialdashboard\widgets\buttons\Delete;
use vasadibt\materialdashboard\widgets\buttons\Export;
use vasadibt\materialdashboard\widgets\buttons\Reset;
use vasadibt\materialdashboard\widgets\buttons\Submit;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
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

    /**
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function back(array $config = [])
    {
        return Back::widget($config);
    }

    /**
     * @param object|null $model
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function create($model = null, array $config = [])
    {
        if ($model) {
            $config['model'] = $model;
        }
        return Create::widget($config);
    }

    /**
     * @param ActiveRecordInterface|null $model
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function delete(ActiveRecordInterface $model = null, array $config = [])
    {
        if ($model) {
            $config['model'] = $model;
        }
        return Delete::widget($config);
    }

    /**
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function export(array $config = [])
    {
        return Export::widget($config);
    }

    /**
     * @param Model|null $filterModel
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function reset(Model $filterModel = null, array $config = [])
    {
        if ($filterModel) {
            $config['filterModel'] = $filterModel;
        }
        return Reset::widget($config);
    }

    /**
     * @param ActiveRecordInterface|null $model
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function submit(ActiveRecordInterface $model = null, array $config = [])
    {
        if ($model) {
            $config['model'] = $model;
        }
        return Submit::widget($config);
    }
}
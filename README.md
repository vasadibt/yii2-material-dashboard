# Getting started with Yii2-material-dashboard

## 1. Install via composer

Yii2-material-dashboard can be installed using composer.
Run following command to install:

```bash
php composer.phar require vasadibt/yii2-material-dashboard
```

## 2. base configurations

Add kartik grid module to the application modules config
```php
'modules' => [
    // ...
    'gridview' => [
        'class' => '\kartik\grid\Module'
    ],
],
```

Add material to view component theme part in components configurations
```php
'layoutPath' => '@vendor/vasadibt/yii2-material-dashboard/src/views/layouts',

'components' => [
    // ...
    'view' => [
        // ...
        'theme' => [
            'pathMap' => [
                '@vasadibt/materialdashboard/views' => '@app/views',
            ],
        ],
    ],
],
 ```

Turn Off the bootstrap4 dependency in `BootstrapNotifyAsset` class
```php
'components' => [
    // ...
    'assetManager' => [
        // ...
        'bundles' => [
            // ...
            'yii\bootstrap\BootstrapAsset' => false,
            'yii\bootstrap\BootstrapPluginAsset' => false,
            'yii\bootstrap4\BootstrapAsset' => false,
            'yii\bootstrap4\BootstrapPluginAsset' => false,
            'kartik\form\ActiveFormAsset' => ['bsDependencyEnabled' => false],
        ],
    ],
],
```

And add material config component to components configurations, And set the default app asset class
```php
'components' => [
    // ...
    'material' => [
        'class' => 'vasadibt\materialdashboard\components\Material',
        'appAssetClass' => 'frontend\assets\AppAsset',
    ],
],
```
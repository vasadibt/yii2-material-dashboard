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
'components' => [
    // ...
    'view' => [
        // ...
        'theme' => [
            'pathMap' => [
                '@app/views' => '@vasadibt/materialdashboard/views',
            ],
        ],
        'on beforeRender' => function(){
            if(!Yii::$app->request->isAjax){
                \frontend\assets\AppAsset::register(Yii::$app->view);
            }
        }
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
            'yii2mod\notify\BootstrapNotifyAsset' => [
                'depends' => [],
            ],
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

## 3. Optional you can config the global access of project

```php
'as access' => [
    'class' => 'yii\filters\AccessControl',
    'rules' => [
        [
            'controllers' => [
                'sign-in',
                'lock',
            ],
            'allow' => true,
        ],
        [// any other request have to logged user
            'roles' => ['@'],
            'allow' => true,
        ],
    ],
],
```

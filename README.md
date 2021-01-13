# Getting started with Yii2-material-dashboard

## 1. Install via composer

Yii2-material-dashboard can be installed using composer.
Run following command to install:

```bash
php composer.phar require vasadibt/yii2-material-dashboard
```

## 2. Configure backend

> **NOTE:** Make sure that you don't have `auth` component configuration in your config files.

Add following lines to your `backend` configuration file:

```php
return [
    // ...
    'bootstrap' => [
        // ...
        'auth',
    ],
    // ...
    'modules' => [
        // ...
        'auth' => 'vasadibt\materialdashboard\Module',
    ],
    // ...
];
```

## 3. User model

Change user model IdentityInterface to ExtendedIdentityInterface

```php
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function findIdentity($id) { /* .... */ }
    public static function findIdentityByAccessToken($token, $type = null) { /* .... */ }
    public function getId() { /* .... */ }
    public function getAuthKey() { /* .... */ }
    public function validateAuthKey($authKey) { /* .... */ }
}
```

change to

```php
class User extends \yii\db\ActiveRecord implements \vasadibt\materialdashboard\models\ExtendedIdentityInterface
{
    public static function findIdentity($id) { /* .... */ }
    public static function findIdentityByAccessToken($token, $type = null) { /* .... */ }
    public function getId() { /* .... */ }
    public function getAuthKey() { /* .... */ }
    public function validateAuthKey($authKey) { /* .... */ }
    // And add new methods
    public function validatePassword($password) { /* .... */ }
    public function setPassword($password) { /* .... */ }
}
```

## 4. Module implement to console application (optional)

The module has some helper commands what you can use if register module in console configuration.
Add following lines to your console configuration file:

```php
return [
    // ...
    'modules' => [
        // ...
        'material-user' => \vasadibt\materialdashboard\Module::class,
    ],
    // ...
];
```


<?php

namespace vasadibt\materialdashboard\models;

use Yii;
use yii\base\Model;

/**
 * Lock form
 */
class LockForm extends Model
{
    /**
     * @var string
     */
    public $password;
    /**
     * @var ExtendedIdentityInterface
     */
    public $user;

    /**
     * Creates a form model given a token.
     *
     * @param ExtendedIdentityInterface $user
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($user, $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', function ($attribute, $params, $validator) {
                if (!$this->user->validatePassword($this->$attribute)) {
                    $this->addError($attribute, Yii::t('materialdashboard', 'Wrong password'));
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('materialdashboard', 'Password'),
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function unlock()
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->user);
    }
}

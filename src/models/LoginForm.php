<?php

namespace vasadibt\materialdashboard\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;

/**
 * Login form
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;
    /**
     * @var ExtendedIdentityInterface|bool
     */
    protected $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('materialdashboard', 'Email'),
            'password' => Yii::t('materialdashboard', 'Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password, true)) {
                $this->addError('password', Yii::t('materialdashboard', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return ActiveRecordInterface|ExtendedIdentityInterface|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            /** @var ActiveRecordInterface $identityClass */
            $identityClass = Yii::$app->user->identityClass;

            $this->user = $identityClass::find()
                ->where(['email' => $this->email])
                ->one();
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);  // 30 day
    }
}

<?php

namespace vasadibt\materialdashboard\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;

/**
 * Class ProfileForm
 * @package backend\models
 */
class ProfileForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var ExtendedIdentityInterface|ActiveRecordInterface
     */
    public $user;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->user = $this->user ?? Yii::$app->user->identity;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('materialdashboard', 'Username'),
            'email' => Yii::t('materialdashboard', 'Email address'),
        ];
    }

    /**
     * Change password.
     *
     * @return bool the saved model or null if saving fails
     */
    public function change()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->username = $this->username;
        $this->user->email = $this->email;
        if (!$this->user->save()) {
            return false;
        }

        Yii::$app->user->switchIdentity($this->user, 3600 * 24 * 30);  // 30 day
        return true;
    }

}
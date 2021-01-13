<?php

namespace vasadibt\materialdashboard\models;

use vasadibt\materialdashboard\widgets\ActiveForm;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Html;

/**
 * Class ChangePasswordForm
 * @package backend\models
 */
class ChangePasswordForm extends Model
{
    /**
     * @var string
     */
    public $oldPassword;
    /**
     * @var string
     */
    public $newPassword;
    /**
     * @var string
     */
    public $retypePassword;

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
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'retypePassword'], 'required'],
            [['oldPassword'], 'validatePassword'],
            [['newPassword'], 'string', 'min' => 6],
            [['retypePassword'], 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('materialdashboard', 'Old password'),
            'newPassword' => Yii::t('materialdashboard', 'New password'),
            'retypePassword' => Yii::t('materialdashboard', 'Retype password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        /* @var $user ExtendedIdentityInterface */
        $user = Yii::$app->user->identity;
        if (!$user->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', Yii::t('materialdashboard', 'Incorrect old password.'));
        }
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

        $this->user->setPassword($this->newPassword);

        if ($this->user->save(false)) {
            Yii::$app->user->switchIdentity($this->user, 3600 * 24 * 30);  // 30 day
            return true;
        }

        return false;
    }

    /**
     *
     */
    public function render()
    {
        $form = ActiveForm::begin([]);
        echo $form->errorSummary($this);
        echo $form->field($this, 'oldPassword')->passwordInput();
        echo $form->field($this, 'newPassword')->passwordInput();
        echo $form->field($this, 'retypePassword')->passwordInput();
        echo '<div class="mt-4 text-center">';
        echo Html::submitButton(Yii::t('materialdashboard', 'Save changes'), ['class' => 'btn btn-success']);
        echo '</div>';
        ActiveForm::end();
    }

}
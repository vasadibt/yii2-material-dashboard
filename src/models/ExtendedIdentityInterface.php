<?php

namespace vasadibt\materialdashboard\models;

/**
 * Interface ExtendedIdentityInterface
 * @package vasadibt\materialdashboard\models
 */
interface ExtendedIdentityInterface extends \yii\web\IdentityInterface
{
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password);

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password);
}
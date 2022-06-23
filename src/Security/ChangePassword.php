<?php

namespace App\Security;


use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword
{
    protected $oldPassword;

    protected $newPassword;


    function getOldPassword() {
        return $this->oldPassword;
    }

    function getNewPassword() {
        return $this->newPassword;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
        return $this;
    }
}
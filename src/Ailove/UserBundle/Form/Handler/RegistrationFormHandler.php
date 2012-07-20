<?php

namespace Ailove\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;

class RegistrationFormHandler extends BaseHandler
{
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        $apiToken = substr($user->generateConfirmationToken(), 0, 20);
        //$user->setApiToken($apiToken);

        parent::onSuccess($user, $confirmation);
    }
}

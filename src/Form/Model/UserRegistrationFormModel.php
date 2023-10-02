<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"email"}, 
 * message="The email is already in use")
 */

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email dolbaeb")
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Please enter a password bistree!")
     * @Assert\Length(min=5, max=15)
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="Agree terms Condition, hello ??")
     */
    public $agreeTerms;
}

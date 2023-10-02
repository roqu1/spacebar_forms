<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueUser;


class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email dolbaeb")
     * @Assert\Email()
     * @UniqueUser()
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

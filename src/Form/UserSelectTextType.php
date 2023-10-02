<?php

namespace App\Form;

use App\Form\DataTransformer\EmailToUserTransformer;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class UserSelectTextType extends AbstractType
{
    private $userRepository;
    private $router;

    public function __construct(UserRepository $userRepository, RouterInterface $router)
    {
        $this->router = $router;
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new EmailToUserTransformer($this->userRepository, $options['finder_callback']));
    }


    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message'  => 'Hmm, user not found!',
            'finder_callback' => function (UserRepository $userRepository, string $email) {
                return $userRepository->findOneBy(['email' => $email]);
            },
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr']; // get existing attributes from view
        $class = isset($attr['class']) ? $attr['class'] . ' ' : ''; // get existing class attribute and add space or empty string

        $class .= 'js-user-autocomplete'; // add new class to existing class attribute

        $attr['class'] = $class; // set new class attribute
        $attr['data-autocomplete-url'] = $this->router->generate('admin_utility_users'); // set new data-autocomplete-url attribute

        $view->vars['attr'] = $attr; // set new attributes to view
    }
}

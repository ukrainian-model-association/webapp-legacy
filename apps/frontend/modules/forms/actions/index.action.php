<?php

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

load::app('modules/forms/controller');

class forms_index_action extends forms_controller
{
    public function getRoutes()
    {
        return [
            '/^\/forms\/(?P<form_name>(.+))$/' => function (Request $request, $parameters) {
                $formName = $parameters['form_name'];

                switch (true) {
                    case 'enroll-top-model' === $formName:
                        return $this
                            ->setView('enrollTopModel')
                            ->enrollTopModel($request);
                }
            },
        ];
    }

    public function enrollTopModel(Request $request)
    {
        // if (session::get_user_id() !== 4) {
        //     header('location: /');
        // }

        return true;
    }

    private function getForm()
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();


        $form = $formFactory->createBuilder(FormType::class)
            ->add('')
            ->getForm();
    }
}

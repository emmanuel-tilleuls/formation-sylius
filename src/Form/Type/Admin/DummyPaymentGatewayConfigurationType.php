<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class DummyPaymentGatewayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sandbox', CheckboxType::class);
        $builder->add('alwaysRejectPayment', CheckboxType::class, [
            'label' => 'Toujours refuser le paiment',
        ]);
    }
}
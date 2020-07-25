<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'First name'
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Last name'
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email address'
        ])
        ->add('streetNumber', TextType::class, [
            'label' => 'Street & Number'
        ])
        ->add('zip', TextType::class, [
            'label' => 'Zip Code'
        ])
        ->add('city', TextType::class, [
            'label' => 'City'
        ])
        ->add('country', CountryType::class, [
            'label' => 'Country'
        ])
        ->add('phoneNumber', TelType::class, [
            'label' => 'Phone number'
        ])
        ->add('birthday', BirthdayType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],
        ])
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'download_label' => 'Please click here to download the image',
            'download_uri' => true,
            'image_uri' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

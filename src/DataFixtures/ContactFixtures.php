<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 20 ; $i++) { 

            $contact = (new Contact())
                    ->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setEmail($faker->email)
                    ->setStreetNumber("$faker->streetName $faker->buildingNumber")
                    ->setZip($faker->postcode)
                    ->setCity($faker->city)
                    ->setCountry($faker->country)
                    ->setPhoneNumber($faker->phoneNumber);

            $manager->persist($contact);
        }

        $manager->flush();
    }
}

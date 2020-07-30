<?php 

namespace App\Tests\Entity;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\Date;

class ContactTest extends KernelTestCase 
{
        public function getEntity()
        {
            return (new Contact())
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('johndoe@gmail.com')
            ->setStreetNumber('Rue lienard 21')
            ->setZip('92160')
            ->setCity('Antony')
            ->setCountry('FR')
            ->setBirthday(new \DateTime("1991-12-31"))
            ->setPhoneNumber('+33707070777');
        }

        public function assertHasErrors(Contact $contact, int $number = 0) {
            self::bootKernel();
            $errors = self::$container->get('validator')->validate($contact);
            $this->assertCount($number, $errors);
        }


        public function testValidEntity() {

            $this->assertHasErrors($this->getEntity(), 0);


        }

        public function testInvalidEntity() {
            $contact = $this->getEntity()
                        ->setFirstName('')
                        ->setLastName('')
                        ->setEmail('johndoe@gmail')
                        ->setStreetNumber('')
                        ->setZip('')
                        ->setCity('')
                        ->setCountry('FRinvalid')
                        ->setBirthday(new \DateTime())
                        ->setPhoneNumber('097');

            $this->assertHasErrors($contact, 8);
        }
}
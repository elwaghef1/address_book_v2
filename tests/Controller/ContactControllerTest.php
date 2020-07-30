<?php 

namespace App\Tests\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends WebTestCase 
{
    public function testHomePage()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'My address book');
        $this->assertSelectorExists(
            'body tbody tr'
        );

    }

    /**
     * Test Add new contact
     * This test changes the database contents by deleting a contact. However,
     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
     * to the database are rolled back when this test completes. This means that
     * all the application tests begin with the same database contents.
     */
    public function testAddContact(): void
    {
        $firstName = $this->generateRandomString(8);
        $lastName = $this->generateRandomString(10);
        $email = 'contact@gmail.com';
        $streetNumber = 'rue lienard 21' ;
        $zip = $this->generateRandomString(5);
        $city = $this->generateRandomString(6);
        $country = 'FR';
        $phoneNumber = "0788610831";
        $birthday = "2000-03-03";

        $client = static::createClient();
        $client->request('GET', '/new');
        $client->submitForm('Add', [
            'contact[firstName]' => $firstName,
            'contact[lastName]' => $lastName,
            'contact[email]' => $email,
            'contact[streetNumber]' => $streetNumber,
            'contact[zip]' => $zip,
            'contact[city]' => $city,
            'contact[country]' => $country,
            'contact[phoneNumber]' => $phoneNumber,
            'contact[birthday]' => $birthday,
        ]);
        
        $this->assertResponseRedirects('/', Response::HTTP_FOUND);

        /** @var \App\Entity\Contact $contact */
        $contact = self::$container->get(ContactRepository::class)->findOneByEmail($email);

        $this->assertNotNull($contact);
        $this->assertSame($firstName, $contact->getFirstName());
        $this->assertSame($lastName, $contact->getLastName());
        $this->assertSame($email, $contact->getEmail());
        $this->assertSame($streetNumber, $contact->getStreetNumber());
        $this->assertSame($zip, $contact->getZip());
        $this->assertSame($city, $contact->getCity());
        $this->assertSame($country, $contact->getCountry());
    }

    /**
     * Test show contact
     * Has the same effect on the database as the testAddContact
     *
     */
    public function testShowContact()
    {
        $client = static::createClient();
        $client->request('GET', '/1');

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test edit contact
     *
     * Has the same effect on the database as the testAddContact
     */
    public function testEditContact(): void
    {
        $newFirstName = 'Johnny';

        $client = static::createClient();
        $client->request('GET', '/1/edit');
        $client->submitForm('Edit', [
            'contact[firstName]' => $newFirstName,
        ]);
        
        /** @var \App\Entity\Contact $contact */
        $contact = self::$container->get(ContactRepository::class)->find(1);

        $this->assertSame($newFirstName, $contact->getFirstName());
    }

    /**
     * Test delete contact
     * Has the same effect on the database as the testAddContact
     */
    public function testDeleteContact(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/1');
        $client->submit($crawler->filter('#delete-form')->form());
        $this->assertResponseRedirects('/', Response::HTTP_FOUND);
        $contact = self::$container->get(ContactRepository::class)->find(1);
        $this->assertNull($contact);
    }
    

    private function generateRandomString(int $length): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
    }
}

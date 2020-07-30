# address_book_v2
An address book application created with symfony 5.1

To run the app after cloning the project:

- composer install
- create the file contact.sqlite in the var folder
- run php bin/console doctrine:database:create to create the database
- run php bin/console make:migration to validate the mappings
- run php bin/console doctrine:migrations:migrate to create tables in the database
- run doctrine:fixtures:load to add dummy data to the database
- run symfony serve to launch the server


++++++++++ TESTS ++++++++

- create contact_test.sqlite in the directory var
- run php bin/console doctrine:database:create --env=test to create the test database
- run doctrine:fixtures:load --env=test to add dummy data to the test database
- run php bin/phpunit to launch the test (The first time may generate errors, run it a second time)


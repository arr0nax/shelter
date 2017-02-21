<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
    require_once 'src/Animal.php';
    require_once 'src/Type.php';

    $server = 'mysql:host=localhost:8889;dbname=shelter_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AnimalTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Animal::deleteAll();
          Type::deleteAll();
        }
        function test_save() {
            $type_name = 'dog';
            $id = null;
            $new_type = new Type($type_name, $id);
            $new_type->save();

            $name = 'spot';
            $gender = 'female';
            $admit_date = '2007-10-12 00:00:00';
            $breed = 'heeler';
            $type_id = $new_type->getId();
            $id = null;
            $test_animal = new Animal($name, $gender, $admit_date, $breed, $type_id, $id);
            $test_animal->save();

            $result = Animal::getAll();

            $this->assertEquals($test_animal, $result[0]);
        }

        function test_getAnimals()
        {
            $name1 = 'spot';
            $gender1 = 'female';
            $admit_date1 = '2007-10-12 00:00:00';
            $breed1 = 'heeler';
            $type_id = '1';
            $id = null;
            $test_animal1 = new Animal($name1, $gender1, $admit_date1, $breed1, $type_id, $id);
            $test_animal1->save();
            $name2 = 'brad';
            $gender2 = 'male';
            $admit_date2 = '2007-10-12 00:00:01';
            $breed2 = 'dog';
            $test_animal2 = new Animal($name2, $gender2, $admit_date2, $breed2, $type_id, $id);
            $test_animal2->save();

            $result = Animal::getAll();

            $this->assertEquals([$test_animal1, $test_animal2], $result);
        }

        function test_deleteAll()
        {
            $name1 = 'spot';
            $gender1 = 'female';
            $admit_date1 = '2007-10-12 00:00:00';
            $breed1 = 'heeler';
            $type_id = '1';
            $id = null;
            $test_animal1 = new Animal($name1, $gender1, $admit_date1, $breed1, $type_id, $id);
            $test_animal1->save();
            $name2 = 'brad';
            $gender2 = 'male';
            $admit_date2 = '2007-10-12 00:00:01';
            $breed2 = 'dog';
            $test_animal2 = new Animal($name2, $gender2, $admit_date2, $breed2, $type_id, $id);
            $test_animal2->save();

            Animal::deleteAll();
            $result = Animal::getAll();

            $this->assertEquals([], $result);
        }
    }



?>

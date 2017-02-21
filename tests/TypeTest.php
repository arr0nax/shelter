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

    class TypeTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Animal::deleteAll();
            Type::deleteAll();
        }

        function test_save()
        {
            $type_name = 'dog';
            $id = null;
            $new_type = new Type($type_name, $id);
            $new_type->save();

            $result = Type::getAll();

            $this->assertEquals($new_type, $result[0]);
        }

        function test_getAll()
        {
            $type_name = 'dog';
            $id = null;
            $new_type = new Type($type_name, $id);
            $new_type->save();

            $type_name2 = 'horse';
            $new_type2 = new Type($type_name, $id);
            $new_type2->save();

            $result = Type::getAll();

            $this->assertEquals([$new_type, $new_type2], $result);
        }

        function test_deleteAll()
        {
            $type_name = 'dog';
            $id = null;
            $new_type = new Type($type_name, $id);
            $new_type->save();

            $type_name2 = 'horse';
            $new_type2 = new Type($type_name, $id);
            $new_type2->save();

            Type::deleteAll();
            $result = Type::getAll();

            $this->assertEquals([], $result);
        }

        function test_getAnimals()
        {
            $type_name = 'dog';
            $id = null;
            $new_type = new Type($type_name, $id);
            $new_type->save();

            $type_name2 = 'horse';
            $new_type2 = new Type($type_name, $id);
            $new_type2->save();

            $name1 = 'spot';
            $gender1 = 'female';
            $admit_date1 = '2007-10-12';
            $breed1 = 'heeler';
            $type_id1 = $new_type->getId();
            $test_animal1 = new Animal($name1, $gender1, $admit_date1, $breed1, $type_id1, $id);
            $test_animal1->save();

            $name3 = 'trudy';
            $gender3 = 'female';
            $admit_date3 = '2007-10-12';
            $breed3 = 'heeler';
            $type_id3 = $new_type->getId();
            $test_animal3 = new Animal($name3, $gender3, $admit_date3, $breed3, $type_id3, $id);
            $test_animal3->save();

            $name2 = 'brad';
            $gender2 = 'male';
            $admit_date2 = '2007-10-12';
            $breed2 = 'appalachian';
            $type_id2 = $new_type2->getId();
            $test_animal2 = new Animal($name2, $gender2, $admit_date2, $breed2, $type_id2, $id);
            $test_animal2->save();

            $name4 = 'bard';
            $gender4 = 'female';
            $admit_date4 = '2006-10-14';
            $breed4 = 'appalochian';
            $type_id4 = $new_type2->getId();
            $test_animal4 = new Animal($name4, $gender4, $admit_date4, $breed4, $type_id4, $id);
            $test_animal4->save();

            $result = $new_type2->getAnimals();

            $this->assertEquals([$test_animal4, $test_animal2], $result);
        }
    }
?>

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
    }
?>

<?php
// require_once 'src/Animal.php';

    class Type
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO types (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_types = $GLOBALS['DB']->query("SELECT * FROM types");
            $types = array();
            foreach ($returned_types as $type)
            {
                $name = $type['name'];
                $id = $type['id'];
                $new_type = new Type($name, $id);
                array_push($types, $new_type);
            }
            return $types;
        }

        static function getAnimals($id)
        {
            $returned_animals = $GLOBALS['DB']->query("SELECT * FROM animals WHERE type_id = {$id} ORDER BY admit_date;");
            $animals = array();
            foreach($returned_animals as $animal)
            {
                $name = $animal['name'];
                $gender = $animal['gender'];
                $admit_date = $animal['admit_date'];
                $breed = $animal['breed'];
                $type_id = $animal['type_id'];
                $id = $animal['id'];
                $new_animal = new Animal($name, $gender, $admit_date, $breed, $type_id, $id);
                array_push($animals, $new_animal);
            }
            return $animals;
        }

        static function getTypeName($id)
        {
            $returned_type = $GLOBALS['DB']->query("SELECT * FROM types WHERE id = {$id}");
            $new_type;
            foreach ($returned_type as $current_type)
            {
                $new_type = $current_type['name'];
            }
            return $new_type;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM types");
        }
    }
 ?>

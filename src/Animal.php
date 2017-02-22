<?php
    class Animal
    {
        private $name;
        private $gender;
        private $admit_date;
        private $breed;
        private $type_id;
        private $id;

        function __construct($name, $gender, $admit_date, $breed, $type_id, $id = null)
        {
            $this->name = $name;
            $this->gender = $gender;
            $this->admit_date = $admit_date;
            $this->breed = $breed;
            $this->type_id = $type_id;
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

        function getGender()
        {
            return $this->gender;
        }

        function setGender($new_gender)
        {
            $this->gender= $new_gender;
        }

        function getAdmitDate()
        {
            return $this->admit_date;
        }

        function setAdmitDate($new_admit_date)
        {
            $this->admit_date= $new_admit_date;
        }

        function getBreed()
        {
            return $this->breed;
        }

        function setBreed($new_breed)
        {
            $this->breed= $new_breed;
        }

        function getId()
        {
            return $this->id;
        }

        function getTypeId()
        {
            return $this->type_id;
        }

        function getType()
        {
            $type = $GLOBALS['DB']->query("SELECT * FROM types WHERE id = {$this->getTypeId()};");
            $new_type;
            foreach ($type as $current_type)
            {
                $new_type = $current_type['name'];
            }
            return $new_type;
        }

        function update($name, $gender, $admit_date, $breed, $type_id, $id)
        {
            $GLOBALS['DB']->exec("UPDATE animals SET name = '{$name}', gender = '{$gender}', admit_date = '{$admit_date}', breed = '{$breed}', type_id = {$type_id} WHERE id = {$id};");

        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO animals (name, gender, admit_date, breed, type_id) VALUES ('{$this->getName()}', '{$this->getGender()}', '{$this->getAdmitDate()}', '{$this->getBreed()}', '{$this->getTypeId()}'); ");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function deleteAnimal()
        {
            $GLOBALS['DB']->exec("DELETE FROM animals WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_animals = $GLOBALS['DB']->query("SELECT * FROM animals");
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM animals");
        }

        static function getAnimalById($animal_id)
        {
            $returned_animal = $GLOBALS['DB']->query("SELECT * FROM animals WHERE id = '{$animal_id}';");
            $new_animal;
            foreach($returned_animal as $animal)
            {
            $name = $animal['name'];
            $gender = $animal['gender'];
            $admit_date = $animal['admit_date'];
            $breed = $animal['breed'];
            $type_id = $animal['type_id'];
            $id = $animal['id'];
            $new_animal = new Animal($name, $gender, $admit_date, $breed, $type_id, $id);
            }
            return $new_animal;
        }


    }


?>

<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Animal.php";
    require_once __DIR__."/../src/Type.php";

    $server = 'mysql:host=localhost:8889;dbname=shelter';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);
    $app['debug'] = true;

    $app->get('/', function() use($app) {
        $animals = Animal::getAll();
        $types = Type::getAll();
        return $app["twig"]->render("root.html.twig", ['animals'=>$animals,'types'=>$types]);
    });

    $app->post('/add-animal', function() use($app) {
        $id = null;
        $new_animal = new Animal($_POST['name'],$_POST['gender'],$_POST['admit_date'],$_POST['breed'], $_POST['type_id'], $id);
        $new_animal->save();
        $animals = Animal::getAll();
        $types = Type::getAll();
        return $app["twig"]->render("root.html.twig", ['animals'=>$animals,'types'=>$types]);
    });

    $app->post('/add-type', function() use($app) {
        $id = null;
        $new_type = new Type($_POST['name'], $id);
        $new_type->save();
        $animals = Animal::getAll();
        $types = Type::getAll();
        return $app["twig"]->render("root.html.twig", ['animals'=>$animals,'types'=>$types]);
    });

    return $app;
?>

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

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    $app->get('/animal/{id}', function($id) use ($app) {
        $found_animal = Animal::getAnimalById($id);
        $types = Type::getAll();

        return $app['twig']->render("animal.html.twig", ['animal' => $found_animal, 'types'=>$types]);
    });

    $app->patch('/edit-animal/{id}', function($id) use($app) {
        $found_animal = Animal::getAnimalById($id);
        $found_animal->update($_POST['name'],$_POST['gender'],$_POST['admit_date'],$_POST['breed'], $_POST['type_id'], $id);
        return $app->redirect('/animal/'.$id);
    });

    $app->get('/type/{id}', function($id) use ($app) {
        $found_animals = Type::getAnimals($id);
        $type = Type::getTypeName($id);

        return $app['twig']->render('type.html.twig', ['animals' => $found_animals,'type' => $type]);
    });

    $app->delete('/delete-animal/{id}', function($id) use ($app) {
        $found_animal = Animal::getAnimalByID($id);
        $found_animal->deleteAnimal();

        return $app->redirect('/');
    });

    return $app;
?>

<?php

/**
 * 
 */

//region load required files
// load required variables / defines / configs
require_once 'config/init.php';
require_once 'config/database.php';

// loas core files
require_once COREPATH . 'functions.php';
require_once COREPATH . 'controller.class.php';
require_once COREPATH . 'model.class.php';

// load all models
foreach(glob('models/*.php') as $modelClass)
{
    require_once $modelClass;
}
//endregion

// start session
session_start();

//region get desired controller and action
$controllerName = 'pages';  // default controller name
$actionName     = 'index';  // default action


if(isset($_GET['c']))
{
    $controllerName = $_GET['c'];
}

if(isset($_GET['a']))
{
    $actionName = $_GET['a'];
}
//endregion

//region validate controller and action
if(file_exists(CONTROLLERSPATH . $controllerName . 'Controller.php'))
{
    require_once CONTROLLERSPATH . $controllerName . 'Controller.php';

    $className = '\\myf\\controller\\' . ucfirst($controllerName) . 'Controller';
    $controller = new $className($controllerName, $actionName);
    $actionMethod = 'action' . ucfirst($actionName);

    if(!method_exists($controller, $actionMethod))
    {
        //TODO: replace with actual 404 page - call
        die('404 method is not available');
    }
    else
    {
        $controller->{$actionMethod}();
    }
}
else
{
    //TODO: replace with actual 404 page - call
    die('404 controller is not available');
}
//endregion

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/styles/style.css">
    <title>Mask Your Face</title>
</head>

<body>
    <?php
        $controller->renderView();
    ?>
</body>

</html>
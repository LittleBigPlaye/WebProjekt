<?php

/**
 *  Alle
 */

//region load required files
// load required variables / defines / configs
require_once 'config' . DIRECTORY_SEPARATOR . 'init.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'database.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'imageSettings.php';

// load core files
require_once COREPATH . 'functions.php';
require_once COREPATH . 'controllerClass.php';
require_once COREPATH . '_baseModelClass.php';

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
        header('Location: index.php?c=errors&a=404');
    }
    else
    {
        $controller->{$actionMethod}();
    }
}
else
{
    header('Location: index.php?c=errors&a=404');
}
//endregion

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/desktop.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/icons/favicon.ico">
    <title>Mask Your Face</title>
</head>

<body>
    <?php
        $controller->renderView();
    ?>
</body>

</html>

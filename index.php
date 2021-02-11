<?php

/**
 * This file is the entry point to all views 
 * @author Hannes Lenz, John Klippstein, Robin Beck
 */

//region load required files
// load required variables / defines / configs
require_once 'config' . DIRECTORY_SEPARATOR . 'init.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'database.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'imageSettings.php';

// load core files
require_once COREPATH . 'controllerClass.php';
require_once COREPATH . 'baseModelClass.php';

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
        header('Location: index.php?c=errors&a=404&err=view');
    }
    else
    {
        $controller->{$actionMethod}();
    }
}
else
{
    header('Location: index.php?c=errors&a=404&err=controller');
}
//endregion

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Masken mit abwechslungsreicher gestaltung">
    <meta name="keywords" content="Masken, Produkte">
    
    <!-- authors -->
    <meta name="author" content="Hannes Lenz">
    <meta name="author" content="John Klippstein">
    <meta name="author" content="Robin Beck">

    <!-- styles -->
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

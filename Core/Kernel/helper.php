<?php

use Core\Kernel\App;

/**
 * @param $data
 */
function dd($data)
{
    echo "<pre>";
    die(var_dump($data));
    echo "</pre>";
}

/**
 * @param $path
 */
function redirect($path)
{
    header('Location: '.$path);
}

/**
 * @param $path
 * @param array $data
 * @throws Twig_Error_Loader
 * @throws Twig_Error_Runtime
 * @throws Twig_Error_Syntax
 */
function view($path, $data = [])
{
    $loader = new Twig_Loader_Filesystem('View');
    $twig = new Twig_Environment($loader);

    $twig->addFilter((new \Twig_Filter('auth', function () {
        return auth();
    })));
    $twig->addFilter((new \Twig_Filter('authName', function () {
        return auth()->name;
    })));

    $view = $path . '.view.php';
    $data = !empty($data) ? extract($data) : [] ;

    echo $twig->render($view, $data);

//    require 'View/'.$path.'.view.php';
}

/**
 * @return mixed
 */
function request()
{
    return App::get('request');
}

/**
 * @return mixed
 */
function auth()
{
    return App::get('session')->getUser();
}

/**
 * @return mixed
 */
function validation()
{
    return App::get('validation');
}

/**
 * @return mixed
 */
function session()
{
    return App::get('session');
}

/**
 * @param string $message
 */
function flashMessage($message = '')
{
    if (!empty($message)) {
        session()->setMessage($message);
    }
}
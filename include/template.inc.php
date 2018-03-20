<?php

function getView($templateName, $vars)
{
    $loader = new Twig_Loader_Filesystem(TEMPLATE_DIR);
    $twig = new Twig_Environment($loader, array('cache' => False, 'autoescape'=>false,
        'debug'=>false));
    return $twig->render($templateName, $vars);
}

function buildLayout($templateName, $vars) {
    $layoutVars = array('content' => getView($templateName, $vars));
    return getView('index.twig', $layoutVars);
}
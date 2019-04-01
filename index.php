<?php
//php part

require "vendor/autoload.php";
require_once 'bootstrap/Parser.php';
require_once 'xml/XmlBuilder.php';
require_once 'view/View.php';

header('Content-Type: text/html; charset=utf-8');
error_reporting(-1);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

$view = new View();

if (isset($_GET['id']) && isset($_GET['file'])) {
    try {
        $view->articleView($_GET['id'], $_GET['file']);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit();
}

$parser = new Parser("https://www.rbc.ru/v10/ajax/main/region/world/publicher/main_main?_=");
$parser->parse();
$articles = [];

try {
    $articles = $parser->getArticles();
    if (count($articles) == 0) {
        throw new Exception("no articles");
    }

} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}


$xmlBuilder = new XmlBuilder();
$xmlBuilder->addDataToXml($articles);
$fileName = $xmlBuilder->createXml();

try {
    $view->articlesView($fileName);
} catch (Exception $e) {
    echo $e->getMessage();
}


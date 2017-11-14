<?php
$value = $_REQUEST["value"];
$fromUnit = $_REQUEST["fromUnit"];
$toUnit = $_REQUEST["toUnit"];

$client = new SoapClient("http://www.webservicex.net/length.asmx?WSDL");
$parametersToSoap = array('LengthValue' => $value, 'fromLengthUnit' => $fromUnit, 'toLengthUnit' => $toUnit);

$resultWrapped = $client->ChangeLengthUnit($parametersToSoap);
$result = $resultWrapped->ChangeLengthUnitResult;

require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    // 'cache' => '/path/to/compilation_cache',
    'auto_reload' => true
));
$template = $twig->loadTemplate('result.html.twig');

$parametersToTwig = array("value" => $value, "fromUnit" => $fromUnit, "toUnit" => $toUnit, 'result' => $result);
echo $template->render($parametersToTwig);

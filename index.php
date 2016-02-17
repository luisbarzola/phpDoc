<?php
require 'autoload.php';
require 'vendor/autoload.php';

use Doc\app\DocBlockParser;
use phpDocumentor\Reflection\DocBlockFactory;

/**
 * Class TestClass bla bla
 */
class TestClass {
    /**
     * This is the short description.
     *
     * This is the 1st line of the long description
     * This is the 2nd line of the long description
     * This is the 3rd line of the long description
     *
     * @param bool|string $foo sometimes a boolean, sometimes a string (or, could have just used "mixed")
     * @param bool|int $bar sometimes a boolean, sometimes an int (again, could have just used "mixed")
     * @return string de-html_entitied string (no entities at all)
     */
    public function another_test($foo, $bar) {
        return strtr($foo,array_flip(get_html_translation_table(HTML_ENTITIES)));
    }
}

$reflectionMethod = new ReflectionMethod('TestClass', 'another_test');


$docComment = $reflectionMethod->getDocComment();

$factory = DocBlockFactory::createInstance();

$docBlock = $factory->create($docComment);

$summary = $docBlock->getSummary();

$description = $docBlock->getDescription();
$foundDescription = $description->render();

$tags = $docBlock->getTagsByName('param');


var_dump($summary);
var_dump($foundDescription);
var_dump($tags[0]->render());
var_dump($tags[1]->render());

$functionName = $reflectionMethod->getName();
var_dump($functionName);

$parameters = $reflectionMethod->getParameters();
var_dump($parameters[0]->name);
var_dump($parameters[1]->name);


$reflectionClass = new ReflectionClass('TestClass');

$classComment = $reflectionClass->getDocComment();

$reflectionClass->getMethod('fn')->getDocComment();

$docBlockClass = $factory->create($classComment);
$summaryClass = $docBlock->getSummary();

$description = $docBlock->getDescription();
$foundDescriptionClass = $description->render();
var_dump($summaryClass);
var_dump($foundDescriptionClass);

$methods = $reflectionClass->getMethods();
array_walk(
    $methods,
    function (&$v) {
        $v = $v->getName();
    }
);
var_dump($methods);

<?php
/**
 * Clase encargada de devolver las partes del comentario de una clase y de sus
 * funciones.
 */

namespace Doc\app;

use phpDocumentor\Reflection\DocBlockFactory;

/**
 * Clase encargada de devolver las partes del comentario de una clase y de sus
 * funciones.
 */
class DocBlock
{
    /**
     * @var \Reflection Instancia de ReflectionClass
     */
    protected $reflectionClass = null;

    /**
     * @var DocBlockFactory
     */
    protected $docBlockFactory = null;

    /**
     * @var array
     */
    protected $classMethods = null;

    /**
     * @var null Nombre de la clase
     */
    protected $class = null;

    public function __construct($class)
    {
        $this->class = $class;
        $this->reflectionClass = new \ReflectionClass($class);
        $this->docBlockFactory = DocBlockFactory::createInstance();

        $this->setMethods();
    }

    /**
     * Devuelve los métodos de la clase.
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->classMethods;
    }

    /**
     * Guarda los métodos de la clase
     *
     * @return void
     */
    protected function setMethods()
    {
        $methods = $this->reflectionClass->getMethods();

        array_walk(
            $methods,
            function (&$v) {
                $v = $v->getName();
            }
        );

        $this->classMethods = $methods;
    }

    public function getClassComment()
    {
        $classComment = $this->reflectionClass->getDocComment();

        $docBlockClass = $this->docBlockFactory ->create($classComment);

        return $docBlockClass->getSummary(). ' '. $docBlockClass->getDescription();
    }

    public function getClassName()
    {
        return $this->reflectionClass->getName();
    }

    public function getMethodDescription($method)
    {
        if (!in_array($method, $this->classMethods)) {
            throw new \Exception(
                'El método ' . $method . ' no pertenece a la clase '.
                $this->class . '.'
            );
        }

        $methodComment = $this->reflectionClass->getMethod($method)->getDocComment();

        $docBlockClass = $this->docBlockFactory ->create($methodComment);

        return $docBlockClass->getSummary(). ' '. $docBlockClass->getDescription();
    }

    public function getMethodPrototype($method)
    {
        if (!in_array($method, $this->classMethods)) {
            throw new \Exception(
                'El método ' . $method . ' no pertenece a la clase '.
                $this->class . '.'
            );
        }

        $parameters = $this
            ->reflectionClass->getMethod('another_test')->getParameters();

        $outputParameters = implode(
            ', ',
            array_map(
                function($parameter){return $parameter->name;},
                $parameters
            )
        );

        return $method . '(' . $outputParameters . ')';
    }
}
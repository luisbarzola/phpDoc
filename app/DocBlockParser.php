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
class DocBlockParser
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

    public function __construct($class)
    {
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
     */
    public function setMethods()
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


}
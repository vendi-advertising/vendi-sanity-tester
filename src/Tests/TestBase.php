<?php

namespace Vendi\SanityTester\Tests;

abstract class TestBase
{
    private $last_exception;

    private $name;

    abstract public function is_sane() : bool;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    final public function get_last_exception() : ? \Exception
    {
        return $this->last_exception;
    }

    final public function set_last_exception(\Exception $ex)
    {
        $this->last_exception = $ex;
    }

    final public function get_name() : string
    {
        return $this->name;
    }
}

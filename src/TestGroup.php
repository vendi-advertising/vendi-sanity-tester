<?php

namespace Vendi\SanityTester;

use Vendi\SanityTester\Tests\TestBase;

class TestGroup
{
    private $name;

    private $test_groups = [];

    private $tests = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function get_name() : string
    {
        return $this->name;
    }

    public function with_test_group(TestGroup $test_group) : self
    {
        $clone = clone $this;
        $clone->add_test_group($test_group);
        return $clone;
    }

    public function add_test_group(TestGroup $test_group)
    {
        $this->test_groups[$test_group->get_name()] = $test_group;
    }

    public function with_test(TestBase $test) : self
    {
        $clone = clone $this;
        $clone->add_test($test);
        return $clone;
    }

    public function add_test(TestBase $test)
    {
        $this->tests[] = $test;
    }

    public function get_test_groups() : array
    {
        return $this->test_groups;
    }

    public function get_tests() : array
    {
        return $this->tests;
    }

    public function has_test_groups() : bool
    {
        return count($this->get_test_groups()) > 0;
    }

    public function has_tests() : bool
    {
        return count($this->get_tests()) > 0;
    }
}

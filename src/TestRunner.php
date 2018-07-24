<?php

namespace Vendi\SanityTester;

final class TestRunner extends TestGroup
{
    public function run()
    {
        //Turn a bunch of error reporting stuff on
        \ini_set('display_errors', 1);
        \ini_set('display_startup_errors', 1);
        \error_reporting(\E_ALL);

        //We want to catch even warnings
        \set_error_handler(
                            function($errno, $errstr, $errfile, $errline, array $errcontext)
                            {
                                throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
                            }
        );

        echo sprintf('<h%1$d>%2$s</h%1$d>', 1, htmlspecialchars($this->get_name()));

        if($this->has_test_groups()){
            foreach($this->get_test_groups() as $tg){
                $this->_run_test_group($tg, 2);
            }
        }
    }

    public function _run_test_group(TestGroup $test_group, int $depth = 1)
    {
        echo sprintf('<h%1$d>%2$s</h%1$d>', $depth, htmlspecialchars($test_group->get_name()));

        if($test_group->has_test_groups()){
            foreach($test_group->get_test_groups() as $tg){
                $this->_run_test_group($tg, $depth + 1);
            }
        }

        if($test_group->has_tests()){
            echo '<ul>';
            foreach($test_group->get_tests() as $t){
                echo '<li>';
                $result = $t->is_sane();
                $color = $result ? 'green' : 'red';
                $msg = $result ? 'Success' : 'Failure';
                echo sprintf('<strong>%1$s - <span style="color: %2$s;">%3$s</span></strong>', htmlspecialchars($t->get_name()), $color, $msg);
                if(!$result){
                    echo '<pre>';
                    print_r($t->get_last_exception());
                    echo '</pre>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</ul>';
    }

    public function get_tests() : array
    {
        throw new \Exception('TestRunner doesn\'t support tests, use a TestGroup instead');
    }
}

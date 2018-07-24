<?php

namespace Vendi\SanityTester\Tests;

class WordPressPlugin extends TestBase
{
    private $plugin_file;

    public function __construct(string $plugin_name, string $plugin_file)
    {
        parent::__construct($plugin_name);
        $this->plugin_file = $plugin_file;
    }

    public function is_sane() : bool
    {
        if(!\defined('ABSPATH')){
            $this->set_last_exception(new \Exception('WordPress not found'));
            return false;
        }

        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        if(!\function_exists('is_plugin_active')){
            $this->set_last_exception(new \Exception('WordPress function is_plugin_active not found'));
            return false;
        }

        if(!\is_plugin_active($this->plugin_file)){
            $this->set_last_exception(new \Exception('WordPress plugin not active'));
            return false;
        }

        return true;
    }
}

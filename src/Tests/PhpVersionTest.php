<?php

namespace Vendi\SanityTester\Tests;

class PhpVersionTest extends TestBase
{
    private $php_major_version;
    private $php_minor_versions;

    public function __construct(int $php_major_version, array $php_minor_versions)
    {
        parent::__construct('PHP Version Check');
        $this->php_major_version = $php_major_version;
        $this->php_minor_versions = $php_minor_versions;
    }

    public function is_sane() : bool
    {
        try{
            if($this->php_major_version !== \PHP_MAJOR_VERSION){
                throw new \Exception(sprintf('Untested PHP major version: %1$s', PHP_VERSION ));
            }

            if(!in_array(PHP_MINOR_VERSION, $this->php_minor_versions)){
                throw new \Exception(sprintf('Untested PHP minor version: %1$s', PHP_VERSION ));
            }

            return true;
        }catch(\Exception $ex){
            $this->set_last_exception($ex);
            return false;
        }
    }
}

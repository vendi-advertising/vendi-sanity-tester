<?php

namespace Vendi\SanityTester\Tests;

class FileSystemTest extends TestBase
{
    private $path;

    public function __construct(string $name, string $path)
    {
        parent::__construct($name);
        $this->path = $path;
    }

    public function is_sane() : bool
    {
        try{
            stat($this->path);
            return true;
        }catch(\Exception $ex){
            $this->set_last_exception($ex);
            return false;
        }
    }
}

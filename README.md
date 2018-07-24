# Vendi Sanity Tester

## Sample
```
<?php

use Vendi\SanityTester\TestGroup;
use Vendi\SanityTester\TestRunner;
use Vendi\SanityTester\Tests\FileSystemTest;
use Vendi\SanityTester\Tests\PhpVersionTest;

define('VENDI_SANITY_ROOT', __DIR__ );

//The sanity checker is controlled via composer now
if(!file_exists(VENDI_SANITY_ROOT . '/vendor/autoload.php')){
    echo '<h1>Composer not loaded </h1>';
    exit;
}

//Load the plugin's autoloader
require_once VENDI_SANITY_ROOT . '/vendor/autoload.php';

//Make sure that the SanityTester actually exists
if(!class_exists('Vendi\SanityTester\TestRunner')){
    echo '<h1>Vendi SanityTester not found</h1>';
    exit;
}


//Now we can finally use the tester!!

          //The root runner
$runner = (new TestRunner('Sanity Tests'))

            //Add test group
            ->with_test_group(
                (new TestGroup('Composer'))

                    //Add individual tests
                    ->with_test(new FileSystemTest('Lock',          VENDI_SANITY_ROOT . '/composer.lock'))
                    ->with_test(new FileSystemTest('Vendor folder', VENDI_SANITY_ROOT . '/vendor/composer/'))
            )
            ->with_test_group(
                (new TestGroup('PHP'))
                    ->with_test(new PhpVersionTest(7, [1,2,3]))
            )
;

$runner->run();
```

## WordPress
If you need to test WordPress features it is up to you to make sure that WordPress is booted up first. The simplest way is usually to load `wp-load.php`. For instance, if your test file is in the root of a plugin at a URL that you are manually calling you can probably just use:
```
define( 'WP_USE_THEMES', false );
require '../../../wp-load.php' ;
```
The `define` line is essentially a way to tell WordPress that you want a lite mode.

You can then use the `WordPressPlugin` test:
```
$runner = (new TestRunner('Sanity Tests'))
            ->with_test_group(
                (new TestGroup('WordPress Plugins'))
                    ->with_test(new WordPressPlugin('ACF Pro', 'advanced-custom-fields-pro/acf.php')
            )
;
```

<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

/*
|-------------------------------------------------------------------------------
| Load the autoloader
|-------------------------------------------------------------------------------
|
| First, let's include the autoloader, which is generated automatically by
| Composer (PHP's package manager) after installing our dependencies.
| From now on, all classes in our dependencies will be usable without
| explicitly loading any files.
|
*/

require __DIR__ . '/vendor/autoload.php';

class MyFlarumRequestPlugin extends Pinpoint\Plugins\DefaultRequestPlugin
{
    public function __construct()
    {
        $blackUri = ['/favicon.ico'];
        // if uri in blackUri, skips it 
        if (!in_array($_SERVER['REQUEST_URI'], $blackUri)) {
            parent::__construct();
        }
    }
    public function __destruct()
    {
        // do nothing
    }
}
define('APPLICATION_NAME', 'cd.dev.test.php'); // your application name
define('APPLICATION_ID', 'cd.dev.flarum');  // your application id
define('PP_REQ_PLUGINS', MyFlarumRequestPlugin::class);
require_once __DIR__ . '/vendor/pinpoint-apm/pinpoint-php-aop/auto_pinpointed.php';

/*
|-------------------------------------------------------------------------------
| Configure the site
|-------------------------------------------------------------------------------
|
| A Flarum site represents your local installation of Flarum. It can be
| configured with a bunch of paths:
|
| - The *base path* is Flarum's root directory and contains important files
|   such as config.php and extend.php.
| - The *public path* is the directory that serves as document root for the
|   web server. Files in this place are accessible to the public internet.
|   This is where assets such as JavaScript files or CSS stylesheets need to
|   be stored in a default install.
| - The *storage path* is a place for Flarum to store files it generates during
|   runtime. This could be caches, session data or other temporary files.
|
| The fully configured site instance is returned to the including script, which
| then uses it to boot up the Flarum application and e.g. accept web requests.
|
*/

return Flarum\Foundation\Site::fromPaths([
    'base' => __DIR__,
    'public' => __DIR__ . '/public',
    'storage' => __DIR__ . '/storage',
]);

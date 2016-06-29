<?php

/**
 * An SDK for interacting with the TheP(aste)B.in API, using PHP.
 * @author https://github.com/ryancco
 */

namespace ThePB{

    /**
     * This class should not be instantiated; Rather, this class should be included
     * in projects using the require_once function. From there the autoloader will
     * register and \ThePB\Library will be available in your project.
     */
    ThePB::autoload();

    final class ThePB
    {

        /**
         * Register our autoloader
         */
        final public static function autoload()
        {
            spl_autoload_register(function ($className) {
                $filename = str_replace('ThePB\\', '', $className);
                $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename) . ".php";

                if (file_exists($filename)) {
                    require $filename;
                }
            }, true);
        }
    }
}

<?php

namespace ThePB\Library {

    final class Language
    {
        /**
         * Checks whether the specified language's syntax highlighting is supported
         * @param string $language Language to be checked for syntax highlighting support
         * @return boolean
         */
        public static function validate($language)
        {
            $api      = new API;
            $language = urlencode($language); // URL Encode user input
            $response = $api->get("/languages/validate/$language");
            if ($response->valid == "true") {
                return true;
            }
            return false;
        }

        /**
         * List of all syntax highlighting supported languages
         * @return object https://api.thepb.in/docs#!/languages/get_languages_list
         */
        function list() {
            $api      = new API;
            $response = $api->get("/languages/list");
            return $response;
        }
    }
}

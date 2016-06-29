<?php

namespace ThePB\Library {

    final class Oembed
    {

        /**
         * Generate an oembed object for the specified paste
         * @param string $url URL of paste to generate an oembed object for
         * @param string $maxWidth Maximum width of the iframe (optional)
         * @param string $maxHeight Maximum height of the iframe (optional)
         * @return object https://api.thepb.in/docs#!/oembed/get_oembed
         */
        final public function generate($url, $maxWidth = null, $maxHeight = null)
        {
            $params = array(
                'url' => $url,
            );
            $params = http_build_query($params);

            $api      = new API;
            $response = $api->get("/oembed?$params");
            return $response;
        }
    }
}

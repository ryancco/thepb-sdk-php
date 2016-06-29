<?php

namespace ThePB\Library {

    final class Key
    {
        final public static function validate($key)
        {
            $api      = new API;
            $response = $api->post("/keys/validate", array(
                "apikey" => $key,
            ));

            if ($response->valid == "true") {
                return true;
            }
            return false;
        }
    }
}

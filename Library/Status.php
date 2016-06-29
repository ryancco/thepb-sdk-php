<?php

namespace ThePB\Library {

    final class Status
    {
        /**
         * Fetch the API server uptime
         * @return object https://api.thepb.in/docs#!/status/get_status
         */
        final public static function getStatus()
        {
            $api      = new API;
            $response = $api->get("/status");
            return $response;
        }

        /**
         * Fetch the API server node module's versions
         * @return object https://api.thepb.in/docs#!/status/get_status_node
         */
        final public static function getNodeStatus()
        {
            $api      = new API;
            $response = $api->get("/status/node");
            return $response;
        }
    }
}

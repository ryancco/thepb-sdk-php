<?php

namespace ThePB\Library {

    final class View
    {

        /**
         * Get post by post ID
         * @param string $key UUIDv4 API key
         * @param string $postId ID of the post to be viewed
         * @return object https://api.thepb.in/docs#!/paste/get_paste_view_pid
         */
        final public function byPostId($key, $postId)
        {
            $api = new API;
            $api->setkey($key);
            $response = $api->get("/paste/view/$postId");
            $paste    = $response->paste;
            return $paste;
        }
    }
}

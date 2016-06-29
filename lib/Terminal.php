<?php
// TODO
// Considering this is CLI dependent, is there even a point?
class Terminal
{
    final public function submit($key)
    {
        $api = new API;
        $api->setKey($key);
        $response = $api->post("/paste/terminal", array(
            "recording" => array(
                "recorded" => "TBD",
                "speed"    => TBD,
                "sizes"    => array(
                    "cols" => TBD,
                    "rows" => TBD,
                ),
                "stdout"   => array(
                    "TBD"),
            ),
            "private"   => TBD,
        ));

        return $response->link;
    }
}

<?php

require(__DIR__."/thepb.php");

//Getting array of languages (once every 60 seconds)
print_r(thepb::getLangs());

//Validating API Key (once every 60 seconds)
print_r(thepb::validateKey('UUIDv4 key'));

$data = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";

//Pasting something with static method
print_r(thepb::post([
	'apikey'	=> 'UUIDv4 key', // required
	'lang'		=> 'php', // optional (default plain)
	'private'	=> true // optional (default false)
], $data));


//Pasting something with an object
$paste = new thepb();
$paste->setKey('UUIDv4 key'); // required
$paste->setLang('php'); // optional
$paste->private = true; // Accepts any truthy or falsey value. optional.
$paste->data = $data;
print_r($paste->send());

?>

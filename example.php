<?php

// // Create a post
// include_once '/lib/Paste.php';
// include_once '/lib/Visibility.php';

// $paste = new Paste;
// $paste->setContent("This is paste content! It isn't 30 characters long though so let's add a little!");
// $submit = $paste->submit("73efd6bd-6ea4-44bd-0000-000000000000");
// $id     = $submit->id;
// $url    = $submit->link;
// print_r($submit);

// // View a post
// include_once '/lib/View.php';

// $view = new View;
// $post = $view->byPostId("73efd6bd-6ea4-44bd-0000-000000000000", $id);
// print_r($post);

// // Oembed
// include_once '/lib/Oembed.php';

// $oembed   = new Oembed;
// $response = $oembed->generate($link);
// print_r($response);

// // Server status
// include_once '/lib/Status.php';

// $status = new Status;
// print_r($status->getStatus());
// print_r($status->getNodeStatus());

require 'ThePB.php';

use \ThePB\Library\Status;

$status = new Status;
print_r($status->getStatus());

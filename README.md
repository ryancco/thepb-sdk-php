# ThePB
An SDK for interacting with the TheP(aste)B.in API, using PHP.

## Contributors
@jdarmst
@LouisT
@ryancco

## Examples

The below is a basic example of creating a new post on TheP(aste)b.in
```php
require 'thepb-sdk-php/ThePB.php';

use \ThePB\Library\Paste;
use \ThePB\Library\Utilities\Visibility;

$paste = new Paste; // Create and store a new Paste object

// Set the content of this paste
$paste->setContent("This is some content I'd like to share with someone!");

// Set the language of this paste
// If this method is not called, the language defaults to 'plain'
$paste->setLanguage("plain");

// Set the visibility of this paste
// If this method is not called, the visibility defaults to 'VISIBILITY_PUBLIC'
$paste->setVisibility(Visibility::VISIBILITY_PUBLIC);

// Submit this paste object for posting and store the response object
// https://api.thepb.in/docs#!/paste/post_paste_submit
try {
    $response = $paste->submit('UUIDv4_API_KEY');
} catch (Exception $e) {
    echo $e->getMessage();
}

// Output the link to the newly posted paste
echo $response->link;
```
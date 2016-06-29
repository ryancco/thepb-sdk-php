<?php

include_once 'Language.php';
include_once 'Visibility.php';

class Paste
{
    /**
     * The content of this paste
     * @var string
     */
    private $content;

    /**
     * The language of this paste
     * @var string
     */
    private $language;

    /**
     * The visibility of this paste
     * @var string
     */
    private $visibility;

    /**
     * Retrieve the content of this paste
     * @return string The content of this paste
     */
    final public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content of this paste
     * @param string $content The content of this paste
     */
    final public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get the language of this paste
     * @return string The language of this paste
     */
    final public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the language of this paste
     * @param string $language The language of this paste
     */
    final public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get the visibility of this paste
     * @return string The visibility of this paste
     */
    final public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the visibility of this paste
     * @param string $visibility The visibility of this paste
     */
    final public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Initialize default properties of this paste
     */
    public function __construct()
    {
        $this->setLanguage('plain');
        $this->setVisibility(Visibility::VISIBILITY_PUBLIC);
    }

    /**
     * Submit the data of this object to the API as a new paste
     * @param string $key UUIDv4 API key
     * @param string $content The content of this paste (optional)
     * @param string $visibility The visibility of this paste (optional)
     * @param string $language The language of this paste (optional)
     * @return object https://api.thepb.in/docs#!/paste/post_paste_submit
     */
    final public function submit($key, $content = null, $visibility = null, $language = null)
    {
        if ($content) {
            $this->setContent($content);
        }

        if ($visibility) {
            $this->setVisibility($visibility);
        }

        if ($language) {
            $this->setLanguage($language);
        }

        $this->validate();

        $api = new API;
        $api->setKey($key);
        $response = $api->post("/paste/submit", array(
            'lang'    => $this->getLanguage(),
            'paste'   => $this->getContent(),
            'private' => var_export($this->getVisibility(), true),
        ));

        return $response;
    }

    /**
     * Perform a series of checks to ensure validity of this paste
     * @throws Exception If any checks are not passed
     */
    final private function validate()
    {
        if ($this->getContent() == null) {
            throw new Exception('Missing content exception');
        }
        if (!Language::validate($this->getLanguage())) {
            throw new Exception('Invalid language exception');
        }
        if (!Visibility::validate($this->getVisibility())) {
            throw new Exception('Invalid visibility exception');
        }
    }
}

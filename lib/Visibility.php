<?php

class Visibility
{
    /**
     * A paste that is publicly indexed and searchable (default)
     * @var boolean
     */
    const VISIBILITY_PUBLIC = false;

    /**
     * A paste that is only available via direct link
     * @var boolean
     */
    const VISIBILIY_PRIVATE = true;

    /**
     * Checks to ensure validity of the visibility setting
     * @param const|bool $visibility Const representation of a boolean value
     * @return boolean
     */
    final public static function validate($visibility)
    {
        if (!is_bool($visibility)) {
            return false;
        }
        return true;
    }
}

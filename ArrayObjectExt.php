<?php

/**
 * Created by PhpStorm.
 * User: lenove
 * Date: 25.01.2017
 * Time: 20:24
 */
class ArrayObjectExt extends ArrayObject
{

    // specify the delimiter
    protected $_pathDelimiter = '/';


    /**
     * Get value an array by using "root/branch/leaf" notation
     *
     * @param string $path   Path to a specific option to extract
     * @param mixed $default Value to use if the path was not found
     * @return mixed
     */
    public function getPathValue($path, $default = null)
    {
        // fail if the path is empty
        if (empty($path)) {
            throw new Exception('Path cannot be empty');
        }

        // remove all leading and trailing slashes
        $path = trim($path, $this->_pathDelimiter);

        // use current array as the initial value
        $value = $this;

        // extract parts of the path
        $parts = explode($this->_pathDelimiter, $path);

        // loop through each part and extract its value
        foreach ($parts as $part) {
            if (isset($value[$part])) {
                // replace current value with the child
                $value = $value[$part];
            } else {
                // key doesn't exist, fail
                return $default;
            }
        }

        return $value;
    }


    /**
     * Set path delimiter
     *
     * @param string $delimiter Delimiter used to split the path
     * @return ArrayObjectExt
     */
    public function setPathDelimiter($delimiter)
    {
        $this->_pathDelimiter = (string) $delimiter;
        return $this;
    }

}
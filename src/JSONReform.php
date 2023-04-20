<?php

namespace iamjohndev;

class JsonReform
{
    /**
     * Formats a JSON string or a PHP array into a human-readable format
     *
     * @param string|array $data The JSON string or PHP array to format
     * @param bool $isJson (optional) Set to true if $data is a JSON string, defaults to true
     * @param int $options (optional) Formatting options, see https://www.php.net/manual/en/function.json-encode.php
     * @param int $depth (optional) Maximum depth of nested structures, see https://www.php.net/manual/en/function.json-encode.php
     * @return string The formatted string
     */
    public static function format($data, $isJson = true, $options = 0, $depth = 512)
    {
        if ($isJson) {
            $data = json_decode($data, true, $depth, $options);
        }

        return self::dump($data);
    }

    /**
     * Dumps a PHP variable into a human-readable format
     *
     * @param mixed $data The PHP variable to dump
     * @param int $depth (optional) Maximum depth of nested structures, defaults to 512
     * @param int $options (optional) Formatting options, see https://www.php.net/manual/en/function.var-export.php
     * @return string The formatted string
     */
    public static function dump($data, $depth = 512, $options = 0)
    {
        return self::prettify(var_export($data, true), $depth, $options);
    }

    /**
     * Prettifies a string by removing redundant white spaces and adding line breaks
     *
     * @param string $string The string to prettify
     * @param int $depth (optional) Maximum depth of nested structures, defaults to 512
     * @param int $options (optional) Formatting options, see https://www.php.net/manual/en/function.var-export.php
     * @return string The prettified string
     */
    public static function prettify($string, $depth = 512, $options = 0)
    {
        $string = var_export($string, true);
        $string = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $string); // add extra indentation
        $string = preg_replace("/\]=>\n(\s+)/m", "] => ", $string); // remove line breaks after keys
        $string = preg_replace('/\s*$/m', '', $string); // remove trailing white spaces
        $string = "Array\n(\n" . $string . "\n)";

        return $string;
    }
}

<?php

namespace iamjohndev;

use InvalidArgumentException;

/**
 * A simple class for reading and formatting JSON data.
 */
class JsonReader
{
    /** @var array */
    private $data;

    /**
     * Creates a new JsonReader instance from a JSON string.
     *
     * @param string $json The JSON string to read.
     */
    public function __construct(string $json)
    {
        $this->data = json_decode($json, true);
    }

    /**
     * Creates a new JsonReader instance from a JSON file.
     *
     * @param string $filename The path to the JSON file to read.
     * @return JsonReader The JsonReader instance created from the file.
     * @throws InvalidArgumentException If the file does not exist or cannot be read.
     */
    public static function fromFile(string $filename): JsonReader
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new InvalidArgumentException("File not found or cannot be read: $filename");
        }

        $json = file_get_contents($filename);

        if ($json === false) {
            throw new InvalidArgumentException("Failed to read file: $filename");
        }

        return new self($json);
    }

    /**
     * Gets the value at the specified path in the JSON data.
     *
     * @param string $path The path to the value, in dot notation.
     * @param mixed $default The default value to return if the path is invalid.
     * @return mixed The value at the specified path, or the default value if the path is invalid.
     */
    public function getValue(string $path, $default = null)
    {
        $keys = explode('.', $path);
        $value = $this->data;

        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return $default;
            }
            $value = $value[$key];
        }

        return $value;
    }

    /**
     * Returns the JSON string in the specified format.
     *
     * @param string $format The format to use (one of 'json', 'pretty', 'minified').
     * @return string The JSON string in the specified format.
     */
    public function format(string $format = 'json'): string
    {
        switch ($format) {
            case 'json':
                return json_encode($this->data);
            case 'pretty':
                return json_encode($this->data, JSON_PRETTY_PRINT);
            case 'minified':
                return json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            default:
                throw new InvalidArgumentException("Invalid format: $format");
        }
    }
}

<?php

declare(strict_types=1);

namespace iamjohndev;

use InvalidArgumentException;

/**
 * A simple class for reading and formatting JSON data.
 */
class JSONReform
{
    protected array $data;

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
     * Gets the value at the specified path in the JSON data.
     *
     * @param string $path The path to the value, in dot notation.
     * @param mixed $default The default value to return if the path is invalid.
     * @return mixed The value at the specified path, or the default value if the path is invalid.
     */
    public function getValue(string $path, mixed $default = null): mixed
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
     *
     * @throws \InvalidArgumentException if an invalid format is provided.
     */
    public function format(string $format = 'json'): string
    {
        return match ($format) {
            'json' => json_encode($this->data),
            'pretty' => json_encode($this->data, JSON_PRETTY_PRINT),
            'minified' => json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            default => throw new InvalidArgumentException("Invalid format: $format"),
        };
    }
}

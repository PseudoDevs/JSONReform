# JsonReform

A simple PHP library for reading and formatting JSON data.

## Installation

Install via Composer:
`composer require iamjohndev/json-reform`


## Usage

```php
    use iamjohndev\JSONReform;
    
    // Read JSON data from a string
    $json = '{"name": "John", "age": 30}';
    $reader = new JSONReform($json);
    
    // Get a value from the JSON data
    $name = $reader->getValue('name'); // "John"
    
    // Format the JSON data
    $prettyJson = $reader->format('pretty'); // "{\n    "name": "John",\n    "age": 30\n}"
    
    // Read JSON data from a file
    $reader = JSONReform::fromFile('data.json');
    
    // Get a nested value from the JSON data
    $value = $reader->getValue('data.persons.0.name'); // "John"
```

# API
```php
JSONReform::__construct(string $json)
Creates a new JSONReform instance from a JSON string.

JSONReform::fromFile(string $path)
Creates a new JSONReform instance from a JSON file.

JSONReform::getValue(string $path, mixed $default = null): mixed
Gets the value at the specified path in the JSON data.

JSONReform::format(string $format = 'json'): string
Returns the JSON string in the specified format.
```

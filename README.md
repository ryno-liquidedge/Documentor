# Documentor README

## Overview

`Documentor` is a PHP class designed to automatically generate Markdown documentation for a specified class. It utilizes reflection and a custom `ClassLoader` factory to extract information about class methods and format them into clean and easily readable Markdown output.

This package is part of the `LiquidedgeApp` namespace and enables developers to automate the process of creating class-level documentation in a user-friendly format.

---

## Features

- **Automated Markdown Documentation**: Generate Markdown documentation for all methods of a specified class.
- **Reflection-Based Analysis**: Leverage PHP Reflection to extract detailed information about class methods.
- **Extensibility**: Built with a factory-based `ClassLoader`, enabling easy extension and customization.

---

## Installation

1. Clone the repository from GitHub to your local environment:

```shell script
git clone https://github.com/your-username/your-repo-name.git
```

2. Make sure your project meets the following requirements:
   - PHP 8.3 or later
   - A compatible autoloader (e.g., Composer) for the `LiquidedgeApp` namespace.

3. Include the class into your project via autoloading or manual inclusion:

```php
use LiquidedgeApp\Documentor\Documentor;
```

---

## Usage

1. Instantiate the `Documentor` class: 

```php
$documentor = new \LiquidedgeApp\Documentor\Documentor();
```

2. Pass the fully qualified name of the target class to the `create_markdown_doc()` method to generate Markdown documentation:

```php
try {
       $classname = 'Namespace\YourClassName';
       $documentation = $documentor->create_markdown_doc($classname);
       echo $documentation; // Print or save the generated Markdown content
   } catch (\ReflectionException $e) {
       echo 'Error: ' . $e->getMessage();
   }
```

---

## Example

If the target class has methods like the following:

```php
namespace MyApp;

class Example {
    public function methodOne() {
        // ...
    }

    public function methodTwo($param) {
        // ...
    }
}
```

Running the `create_markdown_doc()` will generate Markdown similar to this:

```markdown
### methodOne

**Parameters**: None  
**Description**: No details provided.

---

### methodTwo

**Parameters**:
- `$param`

**Description**: No details provided.
```
You can customize the generated documentation format by modifying the `ClassLoader` factory logic.

---

## Exception Handling

- **`\ReflectionException`**: Thrown when there are issues with PHP Reflection, such as invalid class names or inaccessible methods.

---

## Contributing

Feel free to contribute to this repository by submitting issues, feature requests, or pull requests. To contribute:

1. Fork the repository.
2. Create a new branch for your feature: `git checkout -b feature-name`.
3. Commit your changes: `git commit -m 'Add some feature'`.
4. Push the branch: `git push origin feature-name`.
5. Open a pull request.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for more information.

---

## Future Improvements

- Add support for more detailed class property documentation.
- Include an option to specify custom Markdown templates.
- Support for documenting private and protected methods.
- CLI tool for easier generation of class documentation.

---

## Contact

For further questions or assistance, please contact the repository owner or open an issue on GitHub. 

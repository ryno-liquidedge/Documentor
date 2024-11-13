<?php

namespace LiquidedgeApp\Documentor\factory;

class ClassLoader {
	//--------------------------------------------------------------------------------
	protected \ReflectionClass $reflection;

	protected mixed $class_name;
	//--------------------------------------------------------------------------------

	/**
	 * @throws \ReflectionException
	 */
	public function __construct($options = []) {

		$options = array_merge([
			"classname" => false,
		], $options);

		if ($options["classname"]) $this->load_class($options["classname"]);

	}
	//--------------------------------------------------------------------------------

	/**
	 * @throws \ReflectionException
	 */
	public function load_class($classname): \ReflectionClass {
		if (!$classname) throw new \Exception("Class Name not set.");
		if (!class_exists($classname)) throw new \Exception("Class Name not found.");

		$this->class_name = $classname;

		return $this->reflection = new \ReflectionClass($classname);
	}

	//--------------------------------------------------------------------------------
	public function get_class_filename(): bool|string {
		if ($this->class_name) {
			return $this->reflection->getFileName();
		}
		return ""; // Class not found
	}

	//--------------------------------------------------------------------------------
	public function get_namespace(): string {
		if ($this->class_name) {
			return $this->reflection->getNamespaceName();
		}
		return ""; // Class not found
	}

	//--------------------------------------------------------------------------------
	public function get_class_methods(): array|string {
		if ($this->class_name) {
			return $this->reflection->getMethods();
		}
		return ""; // Class not found
	}

	//--------------------------------------------------------------------------------
	public function get_method_doc_string($method): bool|string|null {
		// Check if the class exists
		if ($this->class_name) {
			// Use reflection to get the method
			if ($this->reflection->hasMethod($method)) {
				$method = $this->reflection->getMethod($method);
				return $method->getDocComment(); // Get the doc comment of the method
			}
		}
		return null; // Method not found
	}
	//--------------------------------------------------------------------------------

	/**
 * Converts a PHPDoc comment to Markdown format.
 *
 * This function takes a PHPDoc comment from a method and converts it to a
 * Markdown-formatted string. It supports the following annotations:
 * -
 * @param string $method The name of the method to get the doc comment for.
 * @return string : Converts the annotation to a Markdown heading with the return
 *   type.
 * - Description: The general description of the method is formatted as a
 *   Markdown paragraph.
 */
public function get_method_markdown(string $method): string {

    $doc_comment = $this->get_method_doc_string($method);

    // Remove the starting and ending comment block lines (/** and */)
    $doc_comment = trim($doc_comment);
    $doc_comment = preg_replace('/^\s*\/\*\*|\*\/\s*$/', '', $doc_comment);
    $doc_comment = "## {$method}\n{$doc_comment}\n"; // Add a newline after method name

    // Replace line breaks with newlines for easier processing
    $doc_comment = str_replace("\n", "\n\n", $doc_comment);

    // Convert @param annotations to Markdown
    $doc_comment = preg_replace_callback('/@param\s+([^\s]+)\s+\$([^\s]+)\s+(.*)/', function ($matches) {
        // The @param annotation is in the format "@param <type> $<name> <description>"
        // We want to keep the parameter and description on the same line and format cleanly.
        return "### `\$" . $matches[2] . "` (" . $matches[1] . "): " . $matches[3] . "\n\n";
    }, $doc_comment);

    // Convert @return annotation to Markdown
    $doc_comment = preg_replace_callback('/@return\s+([^\s]+)\s+(.*)/', function ($matches) {
        // The @return annotation is in the format "@return <type> <description>"
        // We want to format it as a Markdown heading with the return type,
        // and the description on the same line.
        return "### Return (" . $matches[1] . "): " . $matches[2] . "\n\n";
    }, $doc_comment);

    // Add general text to Markdown (description)
    // Replace the `*` line prefix with Markdown-friendly formatting (paragraphs)
    $doc_comment = preg_replace('/^\*\s+/', '', $doc_comment);

    // Ensure paragraphs are prepended with two newlines, but no newlines before <p> tags
    $doc_comment = preg_replace_callback('/<p>(.*?)<\/p>/', function($matches) {
        // Return the paragraph without newlines before it
        return $matches[1];
    }, $doc_comment);

    // Format specific options (id, label, value, data) on new lines with added newlines after each description
    $doc_comment = preg_replace_callback('/`(id|label|value|data|options\[.*?\])`:\s*(.*?)(\n|$)/', function($matches) {
        // Format these specific options to appear on a new line with markdown bullet points
        return "\n- `" . $matches[1] . "`: " . $matches[2] . "\n\n";
    }, $doc_comment);

    // Remove empty code blocks
    $doc_comment = preg_replace('/```\s*```/', '', $doc_comment);

    // Ensure correct Markdown structure (e.g., blank lines between sections)
    $doc_comment = preg_replace('/\n\s*\n/', "\n", $doc_comment); // Remove consecutive newlines

    // Add a final newline to the end for cleaner output
    $doc_comment .= "\n";

    return $doc_comment;
}






	//--------------------------------------------------------------------------------

}
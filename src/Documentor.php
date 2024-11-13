<?php

namespace LiquidedgeApp\Documentor;

class Documentor {

	protected factory\ClassLoader $classloader;

	//--------------------------------------------------------------------------------

	public function __construct() {
		$this->classloader = new \LiquidedgeApp\Documentor\factory\ClassLoader();
	}

	//--------------------------------------------------------------------------------

	/**
	 * @throws \ReflectionException
	 */
	public function create_markdown_doc($classname): string {
		$this->classloader = new \LiquidedgeApp\Documentor\factory\ClassLoader();
		$this->classloader->load_class($classname);

		$markdown_arr = [];

		foreach ($this->classloader->get_class_methods() as $method_data){
			$markdown_arr[] = $this->classloader->get_method_markdown($method_data->name);
		}

		return implode("\n\n", $markdown_arr);
	}
	//--------------------------------------------------------------------------------
}
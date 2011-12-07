<?php
/**
 * Global factory class that loads any class and instantiates an object of
 * this type with an arbitrary number of arguments.
 */
class Factory {
	/**
	 * Tells wether the given path is loadable or not (i.e. the file exists or not).
	 * @param string $path The path leading to a class file
	 * @return boolean True if the file exists, false otherwise
	 */
	public static function isLoadable($path) {
 		return file_exists($path);
	}

	/**
	 * Instantiates an object from a class defined in the given file with the given arguments.
	 * Guesses the class name if none is provided.
	 * @param string The path leading to the class file
	 * @param array $args The arguments that will be used to construct the new instance
	 * @param mixed $class The class name (it will be guessed if false)
	 * @return object An instance of the class defined in the given class file
	 */
	public static function & load($path, $args = array(), $class = false) {
		require_once $path;
		if ($class === false) {
			$class = self::guessClassName($path);
		}
		$reflection = new ReflectionClass($class);
		$instance = call_user_func_array(array(&$reflection, 'newInstance'), $args);
		return $instance;
	}

	/**
	 * Guesses the class name based on a file name.
	 * @param string $path The path leading the class file
	 * @return string A potential class name defined in the class file
	 */
	private static function guessClassName($path) {
		$file = basename($path);
		$class = substr($file, 0, strrpos($file, '.'));
		return $class;
	}
}

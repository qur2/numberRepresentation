<?php
/**
 * Utility providing Klingon representation of numbers.
 */
class KlingonNumber {
	/**
	 * The multiples are the numbers that can be prefixed by a cipher.
	 */
	private static $multiples = array(
		1000000 => "'uy'",
		100000 => "blp",
		10000 => "netlh",
		1000 => "SaD",
		100 => "vatlh",
		10 => "maH",
	);

	/**
	 * The ciphers are the basc symbols and cannot be prefixed. 
	 */
	private static $ciphers = array(
		9 => "Hut",
		8 => "chorgh",
		7 => "Soch",
		6 => "jav", 
		5 => "vagh",
		4 => "loS",
		3 => "wej",
		2 => "cha'",
		1 => "wa'",
	);

	/**
	 * Zero is separated from the other elements.
	 */
	private static $zero = "pagh";


	/**
	 * Constructor. Sets the given number as an object property and decomposes it.
	 */
	public function __construct($number) {
		if (!is_numeric($number))
			throw new RuntimeException(self::getErrorMessage($number));
		if (0 > $number)
			throw new RuntimeException(self::getErrorMessage($number, 'negative-warning'));
		$this->number = $number;
		$this->decompose();
	}

	/**
	 * Utility function to provide a name for various cases (e.g. error messages).
	 * @return string The name of the class splitted before each upper letter.
	 */
	public static function getName() {
		$name = preg_replace("/([a-z])([A-Z])/","\\1 \\2", __CLASS__);
		$name = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2", $name);
		return $name;
	}

	/**
	 * Generates an error message.
	 * @param mixed $input The input to display in the error message.
	 */
	public static function getErrorMessage($input, $messageKey = 'repr-error') {
		$messages = array(
			'repr-error' => '"%s" cannot be represented as a %s',
			'negative-warning' => '"%s" cannot be represented as a %s since negative numbers are not supported',
			'float-warning' => '"%s" cannot be represented as a %s since floats are not supported',
		);
		return sprintf($messages[$messageKey], $input, self::getName());
	}

	/**
	 * Tells if the given number is representable or not.
	 * @return Boolean true if the number is representable, false otherwise.
	 */
	public function isRepresentable() {
		return $this->number <= self::getGreatest();
	}

	/**
	 * Computes the greatest number representable using the static properties 
	 * ciphers and multiples.
	 * @return int The greatest integer that can be represented.
	 */
	public static function getGreatest() {
		reset(self::$ciphers);
		$greatestDigit = key(self::$ciphers);
		$greatestNumber = 0;
		foreach (self::$multiples as $multiple => $word)
			$greatestNumber += $multiple * $greatestDigit;
		return $greatestNumber + $greatestDigit;
	}

	/**
	 * Decomposes a number in a combination of ciphers and multiples.
	 * This structure allows to easily represent the number.
	 */
	private function decompose() {
		if (!$this->isRepresentable())
			throw new RuntimeException(self::getErrorMessage($this->number));
		$this->parts = array();
		$number = $this->number;
		if (0 == $number)
			$this->parts[] = array(0 => 0);

		$multiples = self::$multiples;
		reset($multiples);
		while ($number > 0 && list($base, $label) = each($multiples)) {
			$n = floor($number / $base);
			if (0 < $n) {
				$this->parts[] = array($base => $n);
				$number -= $n * $base;
			}
			elseif ($number == $base) {
				$this->parts[] = array($base => 0);
				$number -= $base;
			}
		}
		if (0 < $number)
			$this->parts[] = array($number => 0);
	}

	/**
	 * Generates the string output of the number. It uses the decomposed structure
	 * set on instance construction.
	 * @return string The Klingon representation of the number.
	 */
	public function __toString() {
		$output = array();
		$words = self::$multiples + self::$ciphers + array(0 => self::$zero);
		foreach ($this->parts as $part) {
			list($base, $n) = each($part);
			if ($n)
				$output[] = $words[$n];
			$output[] = $words[$base];
		}
		return join('', $output);
	}
}

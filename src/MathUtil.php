<?php
namespace froggdev\PhpUtils;

final class MathUtil
{	
	/**
	 * Prevent class to be instanciated
	 */
	private function __construct() {}
	
  /**
   * Get the factoriel of a number_format
   *
   * @param int $n
   * @return int
   */
  public static function factoriel($n)
  {
    if($n==0) return 1; else return $n*self::factoriel($n-1);
  }
}

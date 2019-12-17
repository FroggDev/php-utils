<?php
namespace froggdev\PhpUtils;

final Class StringUtil
{
	/**
	 * Prevent class to be instanciated
	 */
	private function __construct() {}
	
  /**
   * Split a string and ignore empty
   *
   * @param string $value
   * @param string $delimiter
   * @return array
   */
  public static function split(string $value, string $delimiter=','):array
  {
    return preg_split("@${delimiter}@", $value, NULL, PREG_SPLIT_NO_EMPTY);
  }
}

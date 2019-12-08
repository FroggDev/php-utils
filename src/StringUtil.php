<?php
namespace froggdev\PhpUtils;

Abstract Class StringUtil
{
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

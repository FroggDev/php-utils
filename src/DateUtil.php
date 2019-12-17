<?php
namespace froggdev\PhpUtils;

final class DateUtil
{
	/**
	 * Prevent class to be instanciated
	 */
	private function __construct() {}
	
  /**
   * 
   * @param int $numOfMonth
   * @param \DateTime|null $now
   * @return \DateTime
   */
  public static function getNextYearSpecificMonth(int $numOfMonth , ?\DateTime $date = new \DateTime('now') ) : \DateTime
  {        
    // Get current month
    $currentMonth = $date->format('m');

    // Get num of month until next year specific month
    //$modifier = $currentMonth <= $numOfMonth ? 12+$numOfMonth-$currentMonth : 12-$currentMonth+$numOfMonth;

    // Keep same year if <= $numOfMonth (special request)
    $modifier = $currentMonth <= $numOfMonth ? $numOfMonth-$currentMonth : 12-$currentMonth+$numOfMonth;

    // Return current date with added num of month until next specific month of next year
    return $date->modify('+'.$modifier.' month');
  }
}

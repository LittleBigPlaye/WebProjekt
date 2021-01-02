<?
namespace myf\core;

/**
 * Checks if a given string is a number with the given amount of decimals
 *
 * @param [type] $number
 * @param [type] $numberOfDecimals
 * @return void
 */
function validateNumberInput($number, $numberOfDecimals)
{
    if(is_numeric($number) && preg_match('/(^[1-9]+[0-9]*)| (^[0-9]+\.[0-9]{'.$numberOfDecimals.'}$)/', $number))
    {
        return true;
    }
    else
    {
        return false;
    }
}
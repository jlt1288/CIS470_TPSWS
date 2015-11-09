<?php
/*	Scripts used by strings to make doing things easier.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/08/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/08/2015
*----------------------------------------------------------------------------
*/

// Check to see if word exists in the given string.
function containsWord($str, $word)
{
   	return !!preg_match('#\b' . preg_quote($word, '#') . '\b#i', $str);
}
?>
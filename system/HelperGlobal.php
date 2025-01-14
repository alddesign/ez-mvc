<?php
declare(strict_types = 1);
/**
 * No Namespace
 * Defining some shorthand functions in gloabal scope.s
 */

/**
 * Shorthand for \Alddesign\EzMvc\System\Helper::url($url)
 * @return string
 */
function u(string $url)
{
	return \Alddesign\EzMvc\System\Helper::url($url);
}

/**
 * Shorthand for \Alddesign\EzMvc\System\Helper::h($text)
 * @return string
 */
function h($text)
{
	return \Alddesign\EzMvc\System\Helper::h($text);
}

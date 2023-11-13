<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Request
{
 	/** 
	 * Checks if a GET request parameter exists and stores its value in $outVar.
	 * 
	 * @param string $name The name of the request parameter.
	 * @param string &$outVar The value of the request parameter will be stored in this variable (reference).
	 * @param mixed $default The value to assing to $outVar if the request parameter doesnt exist.
	 * @return bool TRUE if the request parameter exists, otherwise FALSE
	 */
	public static function get(string $name, &$outVar, $default = '')
	{
		if(isset($_GET[$name]))
		{
			$outVar = $_GET[$name];
			return true;
		}

		$outVar = $default;
		return false;
	}

	/**
	 *  Same as Request::get() with typecasting to string. 
	 *  @return bool
	 */
	public static function getString(string $name, string &$outVar, string $default = '')
	{
		$result = self::get($name, $outVar, $default);
		$outVar = strval($outVar);

		return $result;
	}

	/**
	 *  Same as Request::get() with conversion to int. 
	 *  If the request parameter cannot be converted to int, $default applies.
	 *  @return bool
	 */
	public static function getInt(string $name, int &$outVar, int $default = 0)
	{
		$result = self::get($name, $outVar, $default);
		$outVar = filter_var($outVar, FILTER_VALIDATE_INT);
		$outVar = $outVar === false ? $default : $outVar;

		return $result;
	}

	/**
	 *  Same as Request::get() with conversion to float. 
	 *  If the request parameter cannot be converted to float, $default applies.
	 *  @return bool
	 */
	public static function getFloat(string $name, float &$outVar, float $default = 0.0)
	{
		$result = self::get($name, $outVar, $default);
		$outVar = filter_var($outVar, FILTER_VALIDATE_FLOAT);
		$outVar = $outVar === false ? $default : $outVar;

		return $result;
	}

	/**
	 *  Same as Request::get() with conversion to bool. true, 1, 'yes', 'on', '1', 'true' will convert to TRUE.
	 *  @return bool
	 */
	public static function getBool(string $name, bool &$outVar)
	{
		$result = self::get($name, $outVar2);
		$outVar2 = gettype($outVar2) === 'string' ? strtolower($outVar2) : $outVar2;
		$outVar = in_array($outVar2, [true,1,'yes','on','true','1'], true);

		return $result;
	}

 	/** 
	 * Returns the value of a GET request parameter.
	 * 
	 * @param string $name The name of the request parameter.
	 * @param mixed $default The value if the request parameter doesnt exist.
	 * @return mixed The value of the request parameter, if it exits, otherwise $default.
	 */
	public static function getVal(string $name, $default = '')
	{
		return self::get($name, $value) ? $value : $default; 
	}

 	/** 
	 * Checks if a POST request parameter exists and stores its value in $outVar.
	 * 
	 * @param string $name The name of the request parameter.
	 * @param string &$outVar The value of the request parameter will be stored in this variable (reference).
	 * @param mixed $default The value to assing to $outVar if the request parameter doesnt exist.
	 * @return bool TRUE if the request parameter exists, otherwise FALSE
	 */
	public static function post(string $name, &$outVar, $default = '')
	{
		if(isset($_POST[$name]))
		{
			$outVar = $_POST[$name];
			return true;
		}

		$outVar = $default;
		return false;
	}

		/**
	 *  Same as Request::post() with conversion to string. 
	 *  @return bool
	 */
	public static function postString(string $name, string &$outVar, string $default = '')
	{
		$result = self::post($name, $outVar, $default);
		$outVar = strval($outVar);

		return $result;
	}

	/**
	 *  Same as Request::post() with conversion to int. 
	 *  If the request parameter cannot be converted to int, $default applies.
	 *  @return bool
	 */
	public static function postInt(string $name, int &$outVar, int $default = 0)
	{
		$result = self::post($name, $outVar, $default);
		$outVar = filter_var($outVar, FILTER_VALIDATE_INT);
		$outVar = $outVar === false ? $default : $outVar;

		return $result;
	}

	/**
	 *  Same as Request::post() with conversion to float. 
	 *  If the request parameter cannot be converted to float, $default applies.
	 *  @return bool
	 */
	public static function postFloat(string $name, float &$outVar, float $default = 0.0)
	{
		$result = self::post($name, $outVar, $default);
		$outVar = filter_var($outVar, FILTER_VALIDATE_FLOAT);
		$outVar = $outVar === false ? $default : $outVar;

		return $result;
	}

	/**
	 *  Same as Request::get() with conversion to bool. true, 1, 'yes', 'on', '1', 'true' will convert to TRUE.
	 *  @return bool
	 */
	public static function postBool(string $name, bool &$outVar)
	{
		$result = self::get($name, $outVar2);
		$outVar2 = gettype($outVar2) === 'string' ? strtolower($outVar2) : $outVar2;
		$outVar = in_array($outVar2, [true,1,'yes','on','true','1'], true);

		return $result;
	}

 	/** 
	 * Returns the value of a POST request parameter.
	 * 
	 * @param string $name The name of the request parameter.
	 * @param mixed $default The value if the request parameter doesnt exist.
	 * @return mixed The value of the request parameter, if it exits, otherwise $default.
	 */
	public static function postVal(string $name, $default = '')
	{
		return self::get($name, $value) ? $value : $default; 
	}

}
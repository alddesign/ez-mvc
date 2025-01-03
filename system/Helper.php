<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

require_once(__DIR__ . '/HelperGlobal.php');

abstract class Helper
{
	private static $starts = [];
    /** 
	 * A better implementation of PHP function var_dump();
	 * 
	 * Provides syntax-highlighted insight even into nested objects,arrays, etc.
	 * 
	 * ```
	 * //Example usage:
	 * Helper::xout(['cars' => ['audi','bmw'], 'nothing' => (object)['name' => 'Mario', 'age' => 34]]);  
	 * ```
	 * 
	 * @param mixed $value The variable to print out
	 * @param bool $dontDie Default = false. If set to true the script will not be aborted after execution of this function.
	 * @return void
	 */
	public static function xout($value, bool $dontDie = false, bool $initCall = true)
	{
		//You can define your own syntax coloring here.
		$baseColor = 'black';
		$objectClassColor = 'gray';
		$arrayTypeColor = 'blue';
		$objectTypeColor = 'blue';
		$stringTypeColor = 'red';
		$integerTypeColor = 'orange';
		$doubleTypeColor = 'teal';
		$resourceTypeColor = 'purple';
		$resourceClosedTypeColor = 'plum';
		$booleanTypeColor = 'green';
		$nullTypeColor = 'gray';
	
		$result = $initCall ? '<div id="xout-container" style="font-family: Courier New; font-weight: bold; font-size: 15px; color:'.$baseColor.';">' : '';
	
		$isSimpleVar = false;
		$valueType = gettype($value);
		switch($valueType)
		{
			case 'array' : $result .= '<span>ARRAY</span><br />'.htmlspecialchars('['); break;
			case 'object' : $result .= '<span>OBJECT</span> <span style="color:'.$objectClassColor.';">' . get_class($value) . '</span><br />'.htmlspecialchars('('); break;
			default : $value = [$value]; $isSimpleVar = true; break;
		}
	
		$result .= '<ul style="list-style-type: none; margin: 0;">';
	
		foreach ($value as $key => $val)
		{
			$valType = gettype($val);
			if ($valType === 'array' || $valType === 'object')
			{
				if ($valueType === 'array')
				{
					$result .= '<li><span style="color:'.$arrayTypeColor.';">[' . htmlspecialchars(strval($key)) . ']</span><b style="color:'.$baseColor.';"> '.htmlspecialchars('=>').' </b><span>' . self::xout($val, $dontDie, false) . '</span></li>';
				}
				if ($valueType === 'object')
				{
					$result .= '<li><span style="color:'.$objectTypeColor.';">' . htmlspecialchars(strval($key)) . '</span><b style="color:'.$baseColor.';"> '.htmlspecialchars('->').' </b><span>' . self::xout($val, $dontDie, false) . '</span></li>';
				}
			}
			else
			{
				$color = 'black';
				switch($valType)
				{
					case 'string' : $color = $stringTypeColor; $val = '"'.$val.'"'; break;
					case 'integer' : $color = $integerTypeColor; $val = strval($val); break;
					case 'double' : $color = $doubleTypeColor; $val = strval($val); break;
					case 'resource' : $color = $resourceTypeColor; $val = 'resource ('.get_resource_type($val).')'; break;
					case 'resource (closed)' : $color = $resourceClosedTypeColor; $val = 'resource (closed)'; break;
					case 'boolean' : $color = $booleanTypeColor; $val = ($val === true) ? 'TRUE' : 'FALSE'; break;
					case 'NULL' : $color = $nullTypeColor; $val = 'NULL'; break;
				}
	
				$result .= '<li>';
				if(!$isSimpleVar)
				{
					if($valueType === 'array')
					{
						$result .= '<span style="color:'.$arrayTypeColor.';">[' . htmlspecialchars(strval($key)) . ']</span><b style="color:'.$baseColor.';"> '.htmlspecialchars('=>').' </b>';
					}
					if($valueType === 'object')
					{
						$result .= '<span style="color:'.$objectTypeColor.';">' . htmlspecialchars(strval($key)) . '</span><b style="color:'.$baseColor.';"> '.htmlspecialchars('->').' </b>';
					}
				}
				$result .= '<span style="color:'.$color.';">' . htmlspecialchars($val) . '</span></li>';
			}
		}
	
		$result .= '</ul>';
	
		if(!$isSimpleVar)
		{
			switch($valueType)
			{
				case 'array' : $result .= htmlspecialchars(']'); break;
				case 'object' : $result .= htmlspecialchars(')'); break;
			}
		}
	
		$result .= $initCall ? '</div>' : '';
	
		if($initCall) //Finished
		{
			echo($result);
			if(!$dontDie)
			{
				die();
			}
		}
		else //End of recursive call
		{
			return $result; 
		}
	}

	/** 
	 * Shorthand call of **throw new Exception();** with placeholders.
	 * 
	 * ```
	 * //Example usage:
	 * Helper::ex("%d errors while trying to delete user '%s'.", 4, "admin"); 
	 * ```
	 */
	public static function ex(string $message, ...$params)
	{
		throw new \Exception(vsprintf($message, $params));
	}

	/** 
	 * A better implementation of PHP function empty();
	 * 
	 * @param mixed $var The variable to check
	 * @param bool $zeroIsEmpty Indicates whether a int/doube zero is considered empty
	 * @return boolean
	 */
	public static function e($var, bool $zeroIsEmpty = false)
	{
		return
		(
			($zeroIsEmpty && $var === 0) ||
			($zeroIsEmpty && $var === 0.0) ||
			$var === '' ||
			$var === [] ||
			$var === (object)[] ||
			$var === null
		);
	}

	/**
	 * Adds a trailing slash to an url, path or whatever if it doesnt exist
	 * @return string
	 */
	public static function addTrailingSlash(string $value)
	{
		$value = strval($value);
		if($value === '') 
		{
			return '/';
		}

		return mb_substr($value, mb_strlen($value) - 1, 1) === '/' ? $value : $value . '/';
	}

	/**
	 * Removes the trailing slash of an url, path or whatever if there is one
	 * @return string
	 */
	public static function removeTrailingSlash(string $value)
	{
		$value = strval($value);
		if($value === '' || $value === '/') 
		{
			return '';
		}

		return mb_substr($value, mb_strlen($value) - 1, 1) === '/' ? mb_substr($value, 0, mb_strlen($value) - 1) : $value;
	}

	/**
	 * Adds a starting slash to an url, path or whatever if it doesnt exist
	 * @return string
	 */
	public static function addStartingSlash(string $value)
	{
		$value = strval($value);
		if($value === '') 
		{
			return '/';
		}

		return mb_substr($value, 0, 1) === '/' ? $value : '/'. $value;
	}

		/**
	 * Adds a starting slash to an url, path or whatever if it doesnt exist
	 * @return string
	 */
	public static function addStartingAndTrailingSlash(string $value)
	{
		return self::addStartingSlash(self::addTrailingSlash($value));
	}

	/**
	 * Removes the starting slash of an url, path or whatever if there is one
	 * @return string
	 */
	public static function removeStartingSlash(string $value)
	{
		$value = strval($value);
		if($value === '' || $value === '/') 
		{
			return '';
		}

		return mb_substr($value, 0, 1) === '/' ? mb_substr($value, 1) : $value;
	}

	/**
	 * Converts relative urls to absolte urls (based on base-url). Already absolute urls stay untouched.
	 * @example: $mainUrl = Helper::url("/Main/index");
	 * 
	 * @return string
	 */
	public static function url(string $url)
	{
		$isAbsoluteUrl = parse_url($url, PHP_URL_SCHEME) !== null; //Check if url starts with http:// for example
		
		if($isAbsoluteUrl)
		{
			return $url;
		}
		else
		{
			return self::removeTrailingSlash(EZ_BASE_URL) . self::addStartingSlash($url);
		}
	}

	/**
	 * Converts and echoes relative urls to absolte urls (based on base-url). Already absolute urls stay untouched.
	 * @example: Helper::echoUrl("/Main/index");
	 * 
	 * @return void
	 */
	public static function echoUrl(string $url)
	{
		echo self::url($url);
	}

	/** 
	 * Checks if a session variable exists and stores its value in $outVar.
	 * @return bool TRUE if variable exists, otherwise FALSE
	 */
	public static function session(string $name, &$outVar, $default = '')
	{
		if(!isset($_SESSION[$name]) || Helper::e($_SESSION[$name]))
		{
			$outVar = $default;
			return false;
		}

		$outVar = $_SESSION[$name];
		return true;
	}

	/** 
	 * Returns the value of a session variable. 
	 * @return mixed The session variable or $default
	 */
	public static function sessionVal(string $name, $default = false)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
	}


	/**
	 * Sets a value in the session array
	 * @param string $name Name of the session value
	 */
	public static function sessionSet(string $name, $value)
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Unsets an element in the session array
	 * @param string $name Name of the session value
	 */
	public static function sessionUnset(string $name)
	{
		if(isset($_SESSION[$name]))
		{
			unset($_SESSION[$name]);
		}
	}

	/**
	 * Redirects to given url. 
	 * 
	 * @return bool FALSE if redirect is not possible, otherwise redirect happens
	 */
	public static function redirect(string $url, bool $literalUrl = false)
	{
		if(headers_sent())
		{
			return false;
		}

		$url = $literalUrl ? $url : self::url($url);

		header('Location: ' . $url);
		die;
	}

	/**
	 * Short for htmlspecialchars()
	 */
	public static function h($text)
	{
		return htmlspecialchars((string)$text);
	}

	public static function start(int $i = 0)
	{
		self::$starts[$i] = microtime(true);
	}

	public static function end(int $i = 0, int $decimals = 3)
	{
		$e = microtime(true);
		if(!isset(self::$starts[$i]))
		{
			return -1.0;
		}
		
		$s = self::$starts[$i];
		unset(self::$starts[$i]);
		return round($s - $e, $decimals);
	}
}


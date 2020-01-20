<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Helper
{
    /** 
	 * A better implementation of PHP function var_dump();
	 * 
	 * Provides syntax-highlighted insight even into nested objects,arrays, etc.
	 * 
	 * ```
	 * //Example usage:
	 * $something = ['cars' => ['audi','bmw'], 'nothing' => (object)['name' => 'Mario', 'age' => 34]];
	 * Helper::xout($something);  
	 * ```
	 * 
	 * @param mixed $value The variable to print out
	 * @param bool $dontDie Default = false. If set to true the script will not be aborted after execution of this function.
	 */
	public static function xout($value, bool $dontDie = false)
	{
		self::xoutInternal($value, $dontDie, true);
	}

	/** @ignore */
	private static function xoutInternal($value, bool $dontDie, bool $initCall)
	{
		$result = $initCall ? '<div id="xout-container" style="font-family: Courier New; font-weight: bold; font-size: 15px;">' : '';
		
		if(gettype($value) === 'array')
		{
			$isSimpleVar = false;
			$result .= '<span>ARRAY</span><br />'.htmlspecialchars('[');
			$result .= '<ul style="list-style-type: none; margin: 0; padding: 0 0 0 20px;">';
		}
		if(gettype($value) === 'object')
		{
			$isSimpleVar = false;
			$result .= '<span>OBJECT</span> <span style="color:grey;">' . get_class($value) . '</span><br />'.htmlspecialchars('(');
			$result .= '<ul style="list-style-type: none; margin: 0; padding: 0 0 0 20px;">';
		}
		if(gettype($value) !== 'array' && gettype($value) !== 'object')
		{
			$isSimpleVar = true;
			$result .= '<ul style="list-style-type: none; margin: 0; padding: 0;">';
			$value = [$value];
		}
		
		foreach ($value as $key => $val)
		{
			if (gettype($val) === 'array' || gettype($val) === 'object')
			{
				if (gettype($val) === 'array')
				{
					$result .= '<li><span style="color:blue;">[' . htmlspecialchars(strval($key)) . ']</span><b style="color:black;"> '.htmlspecialchars('=>').' </b><span>' . self::xoutInternal($val, $dontDie, false) . '</span></li>';
				}
				if (gettype($val) === 'object')
				{
					$result .= '<li><span style="color:blue;">' . htmlspecialchars(strval($key)) . '</span><b style="color:black;"> '.htmlspecialchars('->').' </b><span>' . self::xoutInternal($val, $dontDie, false) . '</span></li>';
				}
			}
			else
			{
				$color = 'black';
				switch(gettype($val))
				{
					case 'string' : $color = 'red'; $val = htmlspecialchars('\'').$val.htmlspecialchars('\''); break;
					case 'integer' : $color = 'orange'; break;
					case 'double' : $color = 'teal'; break;
					case 'resource' : $color = 'black'; break;
					case 'boolean' : $color = 'green'; $val = ($val === true) ? 'TRUE' : 'FALSE'; break;
					case 'NULL' : $color = 'grey'; $val = 'NULL'; break;
				}
					
				$result .= '<li>';
				if(!$isSimpleVar)
				{
					if(gettype($value) === 'array')
					{
						$result .= '<span style="color:blue;">[' . htmlspecialchars(strval($key)) . ']</span><b style="color:black;"> '.htmlspecialchars('=>').' </b>';
					}
					if(gettype($value) === 'object')
					{
						$result .= '<span style="color:blue;">' . htmlspecialchars(strval($key)) . '</span><b style="color:black;"> '.htmlspecialchars('->').' </b>';
					}
				}
				$result .= '<span style="color:'.$color.';">' . htmlspecialchars(strval($val)) . '</span></li>';
			}
		}
		
		$result .= '</ul>';
		
		if(!$isSimpleVar)
		{
			switch(gettype($value))
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
	 * Shorthand call of throw new Exception(); with up to 8 placeholders 
	 * 
	 * ```
	 * //Example usage:
	 * Helper::ex("%d errors while trying to delete user '%s'.", 4, "admin"); 
	 * ```
	 * 
	 * @param string $message The Exception message to show
	 * @param mixed $p1 (optional) placeholder
	 * @param mixed $p2 (optional) placeholder
	 * @param mixed $p3 (optional) placeholder
	 * @param mixed $p4 (optional) placeholder
	 * @param mixed $p5 (optional) placeholder
	 * @param mixed $p6 (optional) placeholder
	 * @param mixed $p7 (optional) placeholder
	 * @param mixed $p8 (optional) placeholder
	 */
	public static function ex(string $message, $p1 = '', $p2 = '', $p3 = '', $p4 = '', $p5 = '', $p6 = '', $p7 = '', $p8 = '')
	{
		throw new \Exception(sprintf($message, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8));
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
		$type = gettype($var);
		switch($type)
		{
			case 'boolean'	: return false;
			case 'integer'	: return ($zeroIsEmpty && $var === 0) ? true : false;
			case 'double'	: return ($zeroIsEmpty && $var === 0.0) ? true : false;
			case 'string'	: return ($var === '');
			case 'array'	: return ($var === []);
 			case 'object'	: return ($var == (object)[]);
			case 'resource'	: return false;
			case 'NULL'		: return true;
			default			: return false;
		}
	}

	public static function addTrailingSlash(string $url)
	{
		$url = strval($url);
		if($url === "") 
		{
			return "/";
		}

		return mb_substr($url, mb_strlen($url) - 1, 1) === "/" ? $url : $url . "/";
	}

	public static function removeTrailingSlash(string $url)
	{
		$url = strval($url);
		if($url === "" || $url === "/") 
		{
			return "";
		}

		return mb_substr($url, mb_strlen($url) - 1, 1) === "/" ? mb_substr($url, 0, mb_strlen($url) - 1) : $url;
	}

	public static function addStartingSlash(string $url)
	{
		$url = strval($url);
		if($url === "") 
		{
			return "/";
		}

		return mb_substr($url, 0, 1) === "/" ? $url : "/". $url;
	}

	public static function removeStartingSlash(string $url)
	{
		$url = strval($url);
		if($url === "" || $url === "/") 
		{
			return "";
		}

		return mb_substr($url, 0, 1) === "/" ? mb_substr($url, 1) : $url;
	}

	/** @return string */
	public static function url(string $url)
	{
		$baseUrl = Config::system("base-url");
		$urlPos = mb_strpos($url, $baseUrl);
		
		if($urlPos === 0)
		{
			return $url;
		}
		else
		{
			return self::removeTrailingSlash($baseUrl) . self::addStartingSlash($url);
		}
	}

	/** @return void */
	public static function echoUrl(string $url)
	{
		echo self::url($url);
	}

	/** @return bool */
	public static function get(string $name, &$outVar, $default = "")
	{
		if(!isset($_GET[$name]) || Helper::e($_GET[$name]))
		{
			$outVar = $default;
			return false;
		}

		$outVar = $_GET[$name];
		return true;
	}

	/** @return bool */
	public static function post(string $name, &$outVar, $default = "")
	{
		if(!isset($_POST[$name]) || Helper::e($_POST[$name]))
		{
			$outVar = $default;
			return false;
		}

		$outVar = $_POST[$name];
		return true;
	}

	/** @return bool */
	public static function session(string $name, &$outVar, $default = "")
	{
		if(!isset($_SESSION[$name]) || Helper::e($_SESSION[$name]))
		{
			$outVar = $default;
			return false;
		}

		$outVar = $_SESSION[$name];
		return true;
	}

	public static function redirect(string $url)
	{
		$url = self::url($url);

		header('Location: ' . $url);
		die();
	}
}
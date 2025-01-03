<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

class RoutingData
{
    public $path = '';
    public $requestPath = '';
    public $controller = '';
    public $action = '';
    public $id = '';
    public $params = [];

	public function __construct()
	{

	}
	
}
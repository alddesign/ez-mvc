# ez-mvc

## Table of content
- [Installation](#installation)
- [Basics](#basics)
- [Overview](#overview)
- [Trivia](#trivia)

## Installation
- Requires a Webserver with [PHP](https://www.php.net/downloads) 7.0 or higher
- Requires [PHP Composer](https://getcomposer.org/)
- Install via Composer: 
    - Run `composer create-project alddesing/ez-mvc` in the directory where you want ez-mvc to be installed
    - Run `composer update` in the same directory
- Open http://your-host/path-to-ez-mvc/ in your webbrowser
 

Now you should see the ez-mvc sample application. A little application which should demonstrate how to use ez-mvc.

**PLEASE: Do not delete the sample app right away. It has plenty of documentation und examples. This document is just a guidline**

## Basics
ez-mvc is a simple PHP Model View Controller framework. It provides the absolute basic functionalities to build MVC webapps. Its much easier than [Laravel](#https://laravel.com/) or even [CodeIgniter](https://codeigniter.com/) for example. But if follows the same approach.

- ez-mvc comes without any third party software, only requires composer for quick installation
- ez-mvc has no frontend design capabilities built-in.
- When talking about the ez-mvc root directory: its the directory with the `index.php` file. All paths are realtive to it.
- Create your app (models, views, controllers, config) only in the `/app` folder.
- Assets line js, css, images, can be placed in the `/assets` folder
- The only other file (besides your files in `/app`) you need to edit is `/system/system.config.php`. This file is the base configuration for ez-mvc
- Of course you can customize or extend ez-mvc´s core if you really wnat to. Its located in the `/system` folder

## Overview
Ez-mvc provides the following features:
- **Model** 
    - The model handles the DB connection
    - ez access to DB via PDO
    - Security layer
    - Supports various DB types
    - *See: `/app/models/DefaultModel.php`*
    - *Sample DB: `/app/sample-database.sqlite`*
- **View**
    - A view displays data from controller/config as HTML
    - Supports nested views (child views). So that its ez to crate modular pages 
    templates, headers,...
    - Data can be passed through multiple levels of nested views, which is very powerfull and unique 
    - *See: `/app/views/*.php`*
- **Controller**
    - A controller fetches data from the model/config and prepares it for the views
    - A controller has "actions" which provide backend functionality, display a view, or even both.
    - *See: `/app/controllers/*.php`*
- **Config**
    - The App config allow you to build a solid set of configuration data which is accessible throughout the entire app (model, view, controller)
    - *See: `/app/config/app.config.php`*
- **Routing**
    - ez-mvc has build-in routing, and the best thing: you dont need to care about that (i know sometimes you want to, but this is ez-mvc)
    - Routing happens based on controller/action/parameters and is part of the URL.
    - Example: http://your-host/path-to-ez-mvc/Product/list = Controller "Product", action "list" and displays the product list of the sample app.
- **Helpers**

    The Helper class offers functionality which makes your life ez.
    - Session handling
    - Generating URLs
    - Redirects
    - GET/POST data fetching
    - Useful mothods for PHP programming in general. Checkout `Helper::xout($someVar);`
    - *See: Example usage in almost all files of the sample app*
    - *See: `/system/Helper.php`*

## Trivia
- Checkout ez-mvc on Github: [alddesign/ez-mvc](https://github.com/alddesign/ez-mvc)
- Written in [Visual Studio Code](https://code.visualstudio.com/download)
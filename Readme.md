# ez-mvc

## Table of contents
- [Installation](#installation)
- [Basics](#basics)
- [Overview](#overview)
- [Trivia](#trivia)

## Installation
- Requires 
    - Apache2 with mod_rewrite enabled
    - PHP 7.1 or higher
    - [PHP Composer](https://getcomposer.org/)
- Install via Composer: 
    - Run `composer create-project alddesign/ez-mvc=dev-master` in the directory where you want ez-mvc to be installed. (Or download from github and extract manually).
    - Run `composer update` in the newly created directory. 
    - This is your **ez-mvc root** directory from now on.
- Change RewriteBase in the `.htaccess` with your `/path-to-ez-mvc/`. This is the path to your ez-mvc root directory (relative to your webserver root directory).
- Change the `base-url` in `/system/system.config.php` to the url that points to your ez-mvc root directory. For example: `http://your-host/path-to-ez-mvc` 
- Open http://your-host/path-to-ez-mvc/ in your webbrowser

Now you should see the ez-mvc sample application. A little application which should demonstrate how to use ez-mvc.

**PLEASE: Do not delete the sample application right away. It has plenty of documentation und examples. This document is just a guidline.**

## Basics
Ez-mvc is a simple PHP Model View Controller framework. It provides the absolute basic functionalities to build MVC webapps. Its much more simple than [Laravel](https://laravel.com/) or even [CodeIgniter](https://codeigniter.com/). But if follows the same approach.

- Ez-mvc comes without any third party software, only requires composer for quick installation
- Ez-mvc has no frontend capabilities built-in (CSS/JS).
- When talking about the ez-mvc root directory: its the directory with the `index.php` file. All paths are realtive to it.
- Create your app (models, views, controllers, config) only in the `/app` folder.
- Assets like JS, CSS, images, can be placed in the `/assets` folder
- The only system file you need to edit is `/system/system.config.php`. This file is the base configuration for ez-mvc
- Of course you can customize or extend ez-mvc´s core if you really want to. Its located in the `/system` folder

## Overview
Ez-mvc provides the following features:  
**Model**
- The model handles the DB connection
- ez access to DB via PDO
- Database abstraction layer for your project
- Supports various DB types
- *See: `/app/models/DefaultModel.php`*
- *Sample DB: `/app/sample-database.sqlite`*  

**View**
- A view displays data provided by a controller as HTML
- Supports nested views (child views). So that its ez to crate pages in a modular fashion
- Data can be passed through multiple levels of nested views, which is very powerfull and a little bit unique 
- *See: `/app/views/*.php`*  

**Controller**
- A controller fetches data from the model/config and prepares it for the views
- A controller has "actions" which provide backend functionality, display a view, or even both.
- *See: `/app/controllers/*.php`*  

**Config**
- The App config allow you to build a solid set of settings, preferences, and so on which is accessible throughout the entire app (model, view, controller)
- *See: `/app/config/app.config.php`*  

**Routing**
- Ez-mvc has build-in routing, and the best thing: you dont need to care about it (i know sometimes you want to, but this is ez-mvc)
- Routing happens based on the URL.
- The format is always the same: http://your-host/path-to-ez-mvc/Controller/Action/parameter1/parameter2/...
- Example: http://your-host/path-to-ez-mvc/Product/list. Controller is "Product" (/app/controllers/Product.php). Action is "list" (Method list() in /app/controllers/Product.php). 

**Helpers**  
The Helper class offers functionality which makes your life ez-er.
- Session handling
- Generating URLs
- Redirects
- GET/POST data fetching
- Useful mothods for PHP programming in general. Checkout `Helper::xout($someVar);`
- *See: Example usage in almost all files of the sample app*
- *See: `/system/Helper.php`*  

## Trivia
- Checkout ez-mvc on Github: [alddesign/ez-mvc](https://github.com/alddesign/ez-mvc)
- Some desing patterns used in the framework are considert bad practice (Singletons, static classes, lazy stuff...). And yes, i dont care.

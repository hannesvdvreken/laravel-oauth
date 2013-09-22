<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

// fake App class
class FakeApp extends ArrayObject
{
}

// create alias for Facade Classes
class_alias('Illuminate\\Support\\Facades\\URL', 'URL');
class_alias('Illuminate\\Support\\Facades\\App', 'App');
class_alias('Illuminate\\Support\\Facades\\Config', 'Config');
class_alias('Illuminate\\Support\\Facades\\Redis', 'Redis');

<?php

// fake App class
class FakeApp extends ArrayObject 
{
}

// create alias for Facade Classes
class_alias('Illuminate\\Support\\Facades\\URL', 'URL');
class_alias('Illuminate\\Support\\Facades\\App', 'App');
class_alias('Illuminate\\Support\\Facades\\Config', 'Config');
class_alias('Illuminate\\Support\\Facades\\Redis', 'Redis');
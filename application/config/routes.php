<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['/'] = 'welcome/index';
$route['posts/([0-9]{4}+)'] = 'welcome/posts/$1';

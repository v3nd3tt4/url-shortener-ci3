<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

// Security headers hook
$hook['post_controller_constructor'][] = array(
    'class'    => 'Security_headers',
    'function' => 'add_security_headers',
    'filename' => 'Security_headers.php',
    'filepath' => 'hooks'
);

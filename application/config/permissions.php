<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['allowed_permission_ips'] = array(
    'ADMIN_GLOBAL' => array(
        '10.23.10.0/23',    // Office Internal Network
    ),
    'SCRIPTS' => array(
        '127.0.0.1/32',     // Localhost
        '10.23.10.0/23',    // Office Internal Network
	),
);

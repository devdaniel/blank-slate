<?php
$cdn = base_url();

$config['cdn'] = $cdn;

$config['css_paths'] = array(
    'bootstrap'                 => '//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css',
    'bootstrap-select'          => $cdn.'css/bootstrap-select.min.css',
    'font-awesome'              => $cdn.'css/font-awesome.min.css',
    'font-awesome-ie7'          => $cdn.'css/font-awesome-ie7.min.css',
    'jqueryui'                  => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css',
    'main'                      => $cdn.'css/main.css',
);

$config['js_paths'] = array(
    'bootstrap'                 => '//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',
    'bootstrap-select'          => $cdn.'js/bootstrap-select.min.js',
    'html5shiv'                 => $cdn.'js/html5shiv.js',
    'jquery'                    => '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
    'jquery.tablesorter'        => $cdn.'js/jquery.tablesorter.min.js',
    'jqueryui'                  => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
    'main'                      => $cdn.'js/main.js',
);

<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '171102420959-518k7pem9e7t1es1odde8at8najclll3.apps.googleusercontent.com';
$config['google']['client_secret']    = 'dh2kXiBQ4IHBkbJ3WtMdstVn';
// $config['google']['client_id']        = '26970010818-533tml8k4v68488mk7cee7k7utu25cf9.apps.googleusercontent.com';
// $config['google']['client_secret']    = 'AreBFw_zl02rfOgDjagbj-KB';
$config['google']['redirect_uri']     = 'https://www.somaiya.edu/user_authentication/';
//$config['google']['redirect_uri']     = 'https://stage.somaiya.edu/user_authentication/';
$config['google']['application_name'] = 'Login to CodexWorld.com';
$config['google']['api_key']          = 'AIzaSyBxY1_uE5bI7GN5trFgAeKwSzEvE09dm0A';
$config['google']['scopes']           = array();
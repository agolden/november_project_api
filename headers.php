<?php
//print_r($_SERVER);
//print_r(getallheaders());
//print_r(apache_request_headers());
//echo apache_request_headers()["Api-Token"];
//echo $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
echo $_SERVER['HTTP_AUTHORIZATION'];
?>
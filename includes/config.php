<?php
if($_SERVER['HTTP_HOST']=='localhost'){
    $request_uri_segments = explode('/', $_SERVER['REQUEST_URI']);
    $first_segment = '/' . $request_uri_segments[1];
    $url_config="https://" . $_SERVER['HTTP_HOST'] . $first_segment ."";
    
$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$path = parse_url($current_url, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$last_segment = end($segments);

    $request_uri_segments = explode('/', $_SERVER['REQUEST_URI']);
    $first_segment = '/' . $request_uri_segments[1];
    $url_config="https://" . $_SERVER['HTTP_HOST'] . $first_segment ."";
   
$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$path = parse_url($current_url, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$last_segment = end($segments);
$server="localhost";
$username="root";
$password="";
$database_name="scanworld";

}
elseif($_SERVER['HTTP_HOST'] == 'scansworld.companyonline.in') {
   $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $path = parse_url($current_url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $last_segment = end($segments);
    
     $server = "localhost";
    $username = "webcreatah_scansworld";
    $password = "[5b_#]*u;_BE";
    $database_name = "scanworld";
    
}

else {
   
}

$con = mysqli_connect("$server","$username","$password","$database_name");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


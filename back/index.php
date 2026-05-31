<?php
     include_once("routes/routes.php");
     $route = new Routes();
     $uri = $_SERVER["REQUEST_URI"];
     $requestType = $_SERVER["REQUEST_METHOD"];
     $route->getUrl($uri, $requestType);
?>
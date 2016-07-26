<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 2/12/14
 * Time: 10:14 PM
 */

function ____gis_exception_handler_http(Exception $e) {

    echo "<!--\n";
    echo "Exception: " . get_class($e) . ": '" . $e->getMessage() . "' (Code: {$e->getCode()})\n";
    echo "Thrown in: {$e->getFile()}({$e->getLine()})\n";
    echo $e->getTraceAsString();
    echo "\n-->\n";
    echo "<div style='border:3px solid orangered;font-family: Arial;padding:10px;background-color: whitesmoke;border-radius: 5px;'>";

    echo "<h1 style='font-size: 20px;font-weight:normal;'><code><b>" . get_class($e) . ":</b></code></h1>";
    echo "<h1 style='font-size: 18px;font-weight:normal;border: 1px solid brown;border-radius:5px;padding:5px;background-color:white;'><code>" . htmlentities($e->getMessage()) ."</code></h1>";
    echo "<h1 style='font-size: 18px;font-weight:normal;'>Exception-Code: {$e->getCode()}</h1>";
    echo "<div><b>Thrown in:</b> <code>" . dirname($e->getFile()) . "/<b>". basename($e->getFile()) .  "(" . $e->getLine() . ")</code></b></div>";
    echo "<pre>";
    foreach (explode("\n", $e->getTraceAsString()) as $line) {
        if (! preg_match ("/\\/gis.*\:/", $line))
            echo "<b>$line</b>\n";
        else
            echo "$line\n";
    }
    echo "</pre>";


    if ($e->getPrevious() !== NULL) {
        echo "<h1>Previous Exception:</h1>";
        ____gis_exception_handler_http($e->getPrevious());
    }
    echo "</div>";
}

function ____gis_exception_handler_cli (Exception $e) {

    echo "\n+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
    echo "\n| GIS CLI Exception Handler: " . get_class($e);
    echo "\n+---------------------------------------------------------------------------------------------------------";
    echo "\n|";
    echo "\n| MESSAGE: {$e->getMessage()}";
    echo "\n| ";
    echo "\n| CODE:    {$e->getCode()}";
    echo "\n|";
    echo "\n+---------------------------------------------------------------------------------------------------------";
    echo "\n\n";
    echo "Thrown in: {$e->getFile()}({$e->getLine()})\n";
    echo $e->getTraceAsString();
    echo "\n\n";
}

function ____gis_error_handler_http ($num, $str, $file, $line, $context = null) {
    ____gis_exception_handler_http(new ErrorException($str, 0, $num, $file, $line));
}
function ____gis_error_handler_cli ($num, $str, $file, $line, $context = null) {
    ____gis_exception_handler_cli(new ErrorException($str, 0, $num, $file, $line));
}

if (php_sapi_name() !== 'cli' && strtolower(@$_SERVER["HTTP_X_REQUESTED_WITH"]) !== "xmlhttprequest") {
    set_exception_handler("____gis_exception_handler_http");
    // set_error_handler("____gis_error_handler_http");
} else {
    set_exception_handler("____gis_exception_handler_cli");
    //set_error_handler("____gis_error_handler_cli");
}
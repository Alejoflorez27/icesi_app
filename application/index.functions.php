<?php

function loadFiles($dir)
{
    $path = $dir . "/*";
    foreach (glob($path) as $file) {
        if (is_file($file)) {
            if (strtolower(strrchr($file, ".")) == ".php") {
                if (substr(strrchr($file, "/"), 1, 3) != 'job') {
                    require_once $file;
                }
            }
        } else if (is_dir($file)) {
            loadFiles($file);
        }
    }
}


function loadConf($arr, $prefix = "")
{
    foreach ($arr as $k => $v) {
        if (!is_array($v)) {
            define($prefix . $k, $v);
        } else {
            loadConf($v, $prefix . $k . "_");
        }
    }
}

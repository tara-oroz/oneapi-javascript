<?php
if(sizeof($argv) < 3) die("Wrong number of arguments");
$domain = isset($argv[3]) ? $argv[3] : 'FM';

$basedir=pathinfo($_SERVER['PHP_SELF'],PATHINFO_DIRNAME) . "/../";

$fname = $argv[1];
echo "fname:" . $fname;
$fnameout = $argv[2];
$fh = fopen($fname, "r");

$fhout = fopen($fnameout, "w");
fwrite($fhout, "if(typeof(window['" . $domain . "']) == 'undefined') {\n");

while (($lin = fgets($fh)) !== FALSE) {    
    if(strpos($lin, "#") !== false) {
        $lin = substr($lin, 0,strpos($lin, "#"));
    }
    $lin = trim($lin);
    
    if(strlen($lin) > 0) {
        echo "[" . $lin . "]\n";
        fwrite($fhout, "// file: " . $lin . "\n");
        $ct = file_get_contents($basedir . $lin);
        fwrite($fhout, $ct . "\n");
    }
}
fwrite($fhout, "}\n");
fclose($fh);
fclose($fhout);
?>

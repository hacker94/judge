<?php
$con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
	mysql_select_db("hacker94", $con);
	mysql_query("SET NAMES 'utf8'");
    
    $out = fopen("result.txt", "w");
     $current_dir = opendir('ans/');  
     while(($file = readdir($current_dir)) !== false) {    
            if ($file != '.' && $file != '..') {
         echo $file.' ';
         
    $ansxml = simplexml_load_file("ans/".$file);
    $score = $ansxml->score;
    $id =  explode('.', $file);
    $id = $id[0];
    
	$result = mysql_query("SELECT * FROM judge WHERE id='".$id."'");
    $row = mysql_fetch_array($result);
    $name = $row['name'];
    
    fwrite($out, $id . "\t" . $name. "\t" . $score . "\r\n");
    
    
            }}fclose($out);mysql_close($con);
?>
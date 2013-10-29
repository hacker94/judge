<?php
error_reporting(0);
$id = $_GET['id'];
$con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
mysql_select_db("hacker94", $con);
mysql_query("SET NAMES 'utf8'");
$result = mysql_query("SELECT * FROM judge WHERE id='".$id."'");
$row = mysql_fetch_array($result);
$name = $row['name'];

$time = time();
$query = mysql_query("select id from judge_online where id='$id'"); 
if(!mysql_num_rows($query)){//如果不存在访客IP 
    //将访客信息插入到数据表中 
    mysql_query("insert into judge_online (id,time) values ('$id','$time')"); 
}else{//如果存在，则更新该用户访问时间 
    mysql_query("update judge_online set time='$time' where id='$id'"); 
} 
//删除已过期的记录 
$outtime = $time-60; 
mysql_query("delete from judge_online where time<$outtime"); 
//统计总记录数，即在线用户数 
list($totalonline) = mysql_fetch_array(mysql_query("select count(*) from judge_online"));  
echo $totalonline.'|';//输出在线总数 
$result = mysql_query("select * from judge_online");
while ($row = mysql_fetch_array($result)) {
    $id = $row['id'];
    $row2 = mysql_fetch_array(mysql_query("SELECT * FROM judge WHERE id='".$id."'"));
    $name = $row2['name'];
    echo $id.' '.$name.';';
}
    
mysql_close(); 
?>
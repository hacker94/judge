<!DOCTYPE HTML>
<?php
$con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
mysql_select_db("hacker94", $con);
mysql_query("SET NAMES 'utf8'");
//check id and name matched
$result = mysql_query("SELECT * FROM judge_id_name WHERE id='".$_POST['id']."'");
$row = mysql_fetch_array($result);
if (!$row || ($row['name'] != $_POST['name'])) {
	echo '<a href="index.php">ID and NAME mismatched! Click to get back.</a>';
	mysql_close($con);
	exit();
}
//check dulplicate and write
$result = mysql_query("SELECT * FROM judge WHERE id='".$_POST['id']."'");
if ($row = mysql_fetch_array($result)) {
	echo '<a href="index.php">ID exists! Click to get back.</a>';
	mysql_close($con);
	exit();
}
mysql_query("INSERT INTO judge (id,name,pw,phone,ac,grade) VALUES ("."'".$_POST['id']."',"."'".$_POST['name']."',"."'".$_POST['pw']."',"."'".$_POST['phone']."',"."'".$_POST['ac']."',"."'".$_POST['grade']."'".")");
mysql_close($con);
setcookie("id", $_POST['id'], time() + 24 * 60 * 60);
echo "<script language='javascript' type='text/javascript'>";
echo "window.location.href='judgeindex.php'";
echo "</script>";
?>
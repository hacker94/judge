<?php
	error_reporting(0);
	$id = $_COOKIE["id"];
    $con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
	mysql_select_db("hacker94", $con);
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query("SELECT * FROM judge WHERE id='".$id."'");
    $row = mysql_fetch_array($result);
    $name = $row['name'];
	if (!file_exists("ans/".$id.".xml")) {
		$out = new DOMDocument("1.0", "utf-8");
		$root=$out->createElement('root');// root node 
		$out->appendChild($root);
		$out->save("ans/".$id.".xml"); 
	}
	$out = simplexml_load_file("ans/".$id.".xml");
	if ($out->score) {
		$score = $out->score;
	} else {
		$tiku = simplexml_load_file("tiku.xml");
		$pd = $tiku->pd;
		$xz = $tiku->xz;
		$tk = $tiku->tk;
		$score = 0;
		
		for ($i = 1; $i <= $pd['cnt']; $i++) {
			$s = "pd".$i;
			if (isset($_POST[$s])) {
				$ans = 'T';
			} else {
				$ans = 'F';
			}
			if ($ans == $pd->tm[$i - 1]->ans) {
				$score += 5;
			}
		}
		
		for ($i = 1; $i <= $xz['cnt']; $i++) {
			$s = "xz".$i;
			if (isset($_POST[$s])) {
				$ans = $_POST[$s];
			} else {
				$ans = '';
			}
			if ($ans == $xz->tm[$i - 1]->ans) {
				$score += 5;
			}
		}
		for ($i = 1; $i <= $tk['cnt']; $i++) {
			for ($j = 1; $j < $tk->tm[$i - 1]['cnt']; $j++) {
				$s = "tk".$i.'_'.$j;
				if (isset($_POST[$s])) {
					$ans = $_POST[$s];
				} else {
					$ans = '';
				}
				if ($ans == ($tk->tm[$i - 1]->ans[$j - 1])) {
					$score += 5;
				}
			}
		}
		$out->addChild("score", $score);
		$out->asXML("ans/".$id.".xml");
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>在线评测</title>
	<link rel="stylesheet" type="text/css" href="mycss.css" />
    <style>
		body {
            background: url(2.jpg);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-attachment:fixed;
        }
		p#bh {
			color: #FF0;
			font-size:34px;
			position: fixed;
			left: 100px;
			max-width: 34px;
			top: auto;
			bottom: auto;
			font-weight: bold;
			font-family: Microsoft YaHei;
		}
		h1#title {
			margin-top: 50px;
			color: #FF0;
			font-family: 'Arial Narrow',Arial,sans-serif;
			font-family: Microsoft YaHei;
			font-weight: bold;
		}
        #text {
            font-family: Microsoft YaHei;
        }
    </style>
    <script type="text/javascript">
		function bodyOnLoad() {
			//set timer
			var date = new Date();
			var h = checkTime(date.getHours());
			var m = checkTime(date.getMinutes());
			var s = checkTime(date.getSeconds());
			document.getElementById("timer").innerHTML = "现在的时间是 " + h + ":" + m + ":" + s;
			setTimeout("bodyOnLoad()", 500);
		}
		function checkTime(i) {
			if (i < 10) {
				return "0" + i;
			} else {
				return i;
			}
		}
		function logout() {
			document.cookie = "id=12061163; expires=" + new Date(0).toGMTString() + ";";
		}
		function formSubmit() {
			var form = document.getElementById("form");
			form["action"] = "checkanswer.php";
			form["target"] = "_self";
			form.submit();
		}
	</script>
</head>
<body onload="bodyOnLoad()" onselectstart="return false">
<div id="container">
    <header style="text-align:center">
        <h1 id="title">信息基础部<br/>“沙航论剑”学生党的理论和历史知识知识竞赛网络初赛</h1>
		<!--<img style="float:right" src="logo.png" />-->
        <div style="clear:both;"></div>
    </header>
	<p id="bh">北京航空航天大学沙河校区</p>
    <div id="main">
		<p><a href="index.php" onClick="logout()">注销&nbsp <?php echo $name.'&nbsp'.$id;?></a></p>
		<p class="gang" />
		<p class="score">你的客观题成绩是：<span class="score"><?php echo $score; ?></span>分，每空5分，论述题人工批卷请耐心等待 ^_^</p>
    </div>
</body>
</html>
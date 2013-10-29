<!DOCTYPE html>

<?php

error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
mb_internal_encoding('utf-8');
//check authorization
$ok = false;
if (isset($_COOKIE["id"])) {
	$ok = true;
	$id = $_COOKIE["id"];
    $con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
	mysql_select_db("hacker94", $con);
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query("SELECT * FROM judge WHERE id='".$id."'");
    $row = mysql_fetch_array($result);
    $name = $row['name'];
} else {
	$con = mysql_connect("hacker94.gotoftp5.com", "hacker94", "q1a2z3x4");
	mysql_select_db("hacker94", $con);
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query("SELECT * FROM judge WHERE id='".$_POST['id']."'");
	if ($row = mysql_fetch_array($result)) {
		if ($_POST['pw'] == $row['pw']) {
			$ok = true;
			$id = $row['id'];
			$name = $row['name'];
			setcookie("id", $id, time() + 24 * 60 * 60);
		}
	}
	mysql_close($con);
}

if (!$ok) {
	echo '<a href="index.php">Login failed! Click to get back.</a>';
	exit();
}
echo "<script language='javascript' type='text/javascript'>";
echo "window.location.href='checkanswer.php'";
echo "</script>";
exit();
//check time
date_default_timezone_set('Asia/Shanghai'); 
if (time() < mktime(22, 10, 0, 10, 28, 2013)) {
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='notstart.html'";
	echo "</script>";
	exit();
}
//check over
if ($out = simplexml_load_file("ans/".$id.".xml")) {
	if ($out->score) {
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='checkanswer.php'";
		echo "</script>";
		exit();
	}
}
//load tiku
$tiku = simplexml_load_file("tiku.xml");
$pd = $tiku->pd;
$xz = $tiku->xz;
$tk = $tiku->tk;

function printPd($pd) {
	global $id;
	global $out;
	$i = 0;
	foreach ($pd->tm as $tm) {
		echo '<div class="pdtm">';
		if ($out && $out->pd->ans[$i] == 'T') {
			echo '<p><input type="radio" checked="checked" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="T" />&nbsp<input type="radio" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="F" />'.$tm->ques.'</p>';
		} else if ($out && $out->pd->ans[$i] == 'F') {
			echo '<p><input type="radio" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="T" />&nbsp<input type="radio" checked="checked" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="F" />'.$tm->ques.'</p>';
		} else {
			echo '<p><input type="radio" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="T" />&nbsp<input type="radio" id="pd'.$tm["id"].'" name="pd'.$tm["id"].'" value="F" />'.$tm->ques.'</p>';
		}
		echo '</div>';
		$i++;
	}
}

function printXz($xz) {
	global $id;
	global $out;
	$i = 0;
	foreach ($xz->tm as $tm) {
		echo '<div class="xztm">';
		echo "<p>".$tm->ques."</p>";
		echo '<div class="xzxx">';
		$j = 0;
		foreach ($tm->opt->op as $op) {
			if ($out && (ord($out->xz->ans[$i]) == ord('A') + $j)) {
				echo '<p><input type="radio" checked="checked" id="xz'.$tm["id"].$op["id"].'" name="xz'.$tm["id"].'" value="'.$op["id"].'" /> <label for="xz'.$tm["id"].$op["id"].'" >'.$op.'</label></p>';
			} else {
				echo '<p><input type="radio" id="xz'.$tm["id"].$op["id"].'" name="xz'.$tm["id"].'" value="'.$op["id"].'" /> <label for="xz'.$tm["id"].$op["id"].'" >'.$op.'</label></p>';
			}
			$j++;
		}
		echo '</div></div>';
		$i++;
	}
}

function printTk($tk) {
	global $id;
	global $out;
	$k = 0;
	foreach ($tk->tm as $tm) {
		echo '<div class="tktm">';
		echo '<p>'.$tm->ques[0];
		for ($i = 2; $i <= $tm["cnt"]; $i++) {
			if ($out && ($out->tk->ans[$k] != 'x')) {
				echo '<input style="width:90px" type="text"'.' value="'.$out->tk->ans[$k].'"'.' name="tk'.$tm["id"].'_'.($i - 1).'"/>'.$tm->ques[$i - 1];
			} else {
				echo '<input style="width:90px" type="text" name="tk'.$tm["id"].'_'.($i - 1).'"/>'.$tm->ques[$i - 1];
			}
			$k++;
		}
		echo '</p>';
		echo '</div>';
	}
}
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>在线评测</title>
	<link rel="stylesheet" type="text/css" href="mycss.css" />
    <style>
		#timer, #timer2 {
			color: #FF0;
		}
		.pdtm, .xztm, .tktm, .lstm {
			margin-left: 36px;
		}
		
		.xzxx {
			margin-left: 40px;
		}
		.gang {
			border-bottom: solid rgba(147, 184, 189,0.8) 1px;
		}
		textarea {
			height: 200px;
			width: 700px;
			font-size: 20px;
		}
		div#rightbox {
			position: fixed;
			right: 40px;
			top: 100px;

		}
		#save {
			width: 100px;
			height: 100px;
			text-align: center;
		}
        #onlinecnt {
            position: fixed;
            bottom: 0px;
            right: 0px;
            width:200px; 
            height: 300px;
            background:rgba(247, 247, 247, 0.8);
            border: 1px solid rgba(147, 184, 189,0.8);	   
            box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
	        border-radius: 5px;
            overflow-y:scroll;
	        font-family: Microsoft YaHei;
            font-size:14px;
        }
    </style>
    <script type="text/javascript">
		function bodyOnLoad() {
            setTimer();
            onlineCnt();
            setTimeout("takeCount()", 1000);
		 }
         var TotalMilliSeconds
            
         function takeCount()
         {
            //计数减一
            TotalMilliSeconds -= 1000;
            //计算时分秒
            var minutes = Math.floor(TotalMilliSeconds / (1000 * 60)) % 60;
            var seconds = Math.floor(TotalMilliSeconds / 1000) % 60;
            //将时分秒插入到html中
            document.getElementById("RemainM").innerHTML = minutes;
            document.getElementById("RemainS").innerHTML = seconds;  
            setTimeout("takeCount()", 1000);
         }
        function setTimer() {
            var date = new Date();
            var end = new Date(2013, 9, 28, 22, 30, 01);
            TotalMilliSeconds = end.getTime() - date.getTime();
            if (date.getTime() >= end.getTime()) {
                formSubmit();
            }
			var h = checkTime(date.getHours());
			var m = checkTime(date.getMinutes());
			var s = checkTime(date.getSeconds());
			document.getElementById("timer").innerHTML = "现在的时间是<br/>" + h + ":" + m + ":" + s;
			setTimeout("setTimer()", 500);     
        }
        function onlineCnt() {
            request = new XMLHttpRequest();
            request.onreadystatechange = updateOnlineCnt;
            var id = <?php echo $id?>;
            request.open("GET",'onlinecnt.php?id=' + id, true);
            request.send(null);
            setTimeout("onlineCnt()", 30 * 1000);
        }
        function updateOnlineCnt() {
            if (request.status == 200) {
                var text = request.responseText;
                document.getElementById('cnt').innerHTML = '当前在线人数共' + text.split('|')[0] + '人：';
                var alluser = text.split('|')[1];
                var userarr = alluser.split(';');
                userarr.pop();
                var ul = document.getElementById('ul');
                ul.innerHTML = '';
                for (var i = 0; i < userarr.length; i++) {
                    var li = document.createElement("li");
                    li.innerHTML = userarr[i];
                    ul.appendChild(li);
                }
            }
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
<body onload="bodyOnLoad();onlineCnt();" onselectstart="return false">
<div id="onlinecnt">
    <p id="cnt" style="font-size:16px;"></p>
    <ul id="ul"></ul>
</div>
<div id="container">
    <header style="text-align:center">
        <h1 id="title">信息基础部<br/>“沙航论剑”学生党的理论和历史知识知识竞赛网络初赛</h1>
		<!--<img style="float:right" src="logo.png" />-->
        <div style="clear:both;"></div>
    </header>
	<p id="bh">北京航空航天大学沙河校区</p>
    <div id="main">
		<p><a href="index.php" onClick="logout()">注销&nbsp <?php echo $name.'&nbsp'.$id;?></a></p>
		<div id="rightbox">
			<p id="timer"></p>
            <p id="timer2">剩余时间还有<br/><span id="RemainM"></span>分<span id="RemainS"></span>秒</p>
			<input form="form" id="save" type="submit" value="保存答案" formaction="saveanswer.php" formmethod="post" formtarget="fake"  />
		</div>
		<p class="gang" />
        <form id="form" action="saveanswer.php" method="post" target="fake">
			<div id="tk">
				<section>
					<h2>一、判断题：</h2>
					<div class="xz">
						<p class="pdtm">&nbspT&nbsp F</p>
						<?php printPd($pd);?>
					</div>
				</section>
				<section>
					<h2>二、选择题：</h2>
					<div class="xz">
						<?php printXz($xz);?>
					</div>
				</section>
				<section>
					<h2>三、填空题：</h2>
					<div class="tk">
						<?php printTk($tk);?>
					</div>
				</section>
				<section>
					<h2>四、论述题：</h2>
					<div class="ls lstm">
						<label for="ls" style="display:block">习总书记在十八大报告中提出全面建成小康社会和全面深化改革开放的目标。对此目标你怎么认识，有什么可行的建议？</label>
						<textarea id="ls" name="ls" ></textarea>
					</div>
				</section>
			</div>
			<p class="gang" />
            <p>
				做完题必须提交，可以重复保存，只能提交一次。
				
				<input type="button" value="提交" onclick="formSubmit()" />
			</p>
			<iframe style="display:none" name="fake"></iframe>
        </form>
    </div>	
</div>
</body>
</html>
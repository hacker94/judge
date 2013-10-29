<?php
    echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='checkanswer.php'";
	echo "</script>";
	exit();
    
	$id = $_COOKIE["id"];
	$out = new DOMDocument("1.0", "utf-8");
	$root=$out->createElement('root');// root node 
	$out->appendChild($root);
	$out->save("ans/".$id.".xml"); 
	$out = simplexml_load_file("ans/".$id.".xml");
	$out->addChild("over", "n");
	$tiku = simplexml_load_file("tiku.xml");
	$pd = $tiku->pd;
	$xz = $tiku->xz;
	$tk = $tiku->tk;
	
	$pdans = $out->addChild("pd", "");
	for ($i = 1; $i <= $pd['cnt']; $i++) {
		$s = "pd".$i;
		if (isset($_POST[$s])) {
			$pdans->addChild("ans", $_POST[$s]);
		} else {
			$pdans->addChild("ans", "x");
		}
	}
	
	$xzans = $out->addChild("xz", "");
	for ($i = 1; $i <= $xz['cnt']; $i++) {
		$s = "xz".$i;
		if (isset($_POST[$s])) {
			$xzans->addChild("ans", $_POST[$s]);
		} else {
			$xzans->addChild("ans", "x");
		}
	}
	
	$tkans = $out->addChild("tk", "");
	for ($i = 1; $i <= $tk['cnt']; $i++) {
		for ($j = 1; $j < $tk->tm[$i - 1]['cnt']; $j++) {
			$s = "tk".$i.'_'.$j;
			if ($_POST[$s] != '') {
				$tkans->addChild("ans", $_POST[$s]);
			} else {
				$tkans->addChild("ans", "x");
			}
		}
	}
    
    $zgans = $out->addChild("zg", "");
	$zgans->addChild("ans", $_POST['ls']);
	
	$out->asXML("ans/".$id.".xml");
?>
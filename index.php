<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>七尾鱼的密码生成器</title>
</head>

<body>
<h1>欢迎使用七尾鱼的密码生成器</h1>
<?php
$input = array_merge($_GET, $_POST);
$password = isset($input['password'])?$input['password']:'';
$appname = isset($input['appname'])?$input['appname']:'';
$passwordnum = intval(isset($input['num'])?$input['num']:0);
if(empty($password)||empty($appname)||empty($passwordnum)) {
	?>
<script type="text/javascript">
function check() {
	var pd = document.getElementById('password1').value;
	if(pd=="") {
		alert("密码不能为空！");
		return false;
	}
	if(!checkpassword()) {
		alert("两次输入的密码不一样！");
		return false;
	}
	var appname = document.getElementById('appname').value;
	if(appname=="") {
		alert("应用名不能为空！");
		return false;
	}
	var num = parseInt(document.getElementById('num').value, 10);
	if(isNaN(num) || (num == 0)) {
		alert("密码长度不能为空或0！");
		return false;
	}
	if(num > 32) {
		alert("密码长度不能大于32！");
		return false;
	}
	return true;
}
function checkpassword() {
	var pd1 = document.getElementById('password1').value;
	var pd2 = document.getElementById('password2').value;
	var checkspan = document.getElementById('checkpassword');
	if(pd1!=pd2) {
		checkspan.innerHTML = "两次密码不一样！";
		return false;
	}
	else {
		checkspan.innerHTML = "";
		return true;
	}
}
</script>
<form action="index.php" method="post" onsubmit="return check();">
请输入密码:<input type="password" id="password1" name="password" /><br />
请确认密码:<input type="password" id="password2" onblur="javascript:checkpassword();" /><span id="checkpassword"></span><br />
请输入应用名:<input type="text" id="appname" name="appname"/><br />
密码位数：<input type="text" id="num" name="num" /><br />
<input type="submit" value="提交"/>
</form>
    <?php
}
else {
	$appname = func0($appname);
	$appname = func16to4($appname);
	$appname = str_split($appname);
	foreach($appname as $char) {
		$code = "return func{$char}(\$password);";
		$password = eval($code);
	}
	$res = $password;
	$res = func0($res);
	$res = func1($res);
	$res = func2($res);
	$res = func3($res);
	$res = substr($res, 0, $passwordnum);
	?>
    生成的密码:<br /><textarea cols="100" rows="5"><?php echo $res; ?></textarea><br />
    <input type="button" onclick="javascript:window.history.back(-1);" value="重新输入" />
    <?php
}
?>
</body>
</html>
<?php
function func16to4($str) {
	$str = strtolower($str);
	$arr = array(
		'0' => '0000',
		'1' => '0001',
		'2' => '0010',
		'3' => '0011',
		'4' => '0100',
		'5' => '0101',
		'6' => '0110',
		'7' => '0111',
		'8' => '1000',
		'9' => '1001',
		'a' => '1010',
		'b' => '1011',
		'c' => '1100',
		'd' => '1101',
		'e' => '1110',
		'f' => '1111'
	);
	$str = str_split($str);
	$binstr = '';
	foreach($str as $char) {
		$binstr.= $arr[$char];
	}
	$binstr = str_split($binstr, 2);
	$arr4 = array(
		'00' => '0',
		'01' => '1',
		'10' => '2',
		'11' => '3'
	);
	$str4 = '';
	foreach($binstr as $char) {
		$str4.=$arr4[$char];
	}
	return $str4;
}
function func0($str) {
	return sha1($str);
}
function func1($str) {
	return md5($str);
}
function func2($str) {
	return strrev($str);
}
function func3($str) {
	$string = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM!@#$%^&*()';
	$count = strlen($string);
	$res = '';
	$strarr = str_split($str);
	foreach($strarr as $char) {
		$num = ord($char) % $count;
		$pre = substr($string, 0, $num);
		$string = substr($string, $num).$pre;
		$res .= substr($string,$num, 1);
	}
	return $res;
}
?>

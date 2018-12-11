<?php

include_once dirname(__FILE__)."/functions.php";

$arr_user = array(
				  array("admin1", "password1"),
				  array("admin2", "password2")
				  );

if($_POST['username'] && $_POST['password'])
{
	$uid = addslashes($_POST['username']);
	$pas = addslashes($_POST['password']);
	$userid = "";
	if(is_array($arr_user))
	{
		foreach($arr_user as $user)
		{
			if($user[0] == $uid && $user[1] == $pas)
			{
				$userid = $user[0];
			}
		}
			if($userid)
			{
				$_SESSION['userid'] = $userid;
				if($_POST['ref'])
				header("Location:$res");
				else
				header("Location:./");
			}
	}
}
if(!isset($_SESSION['userid']))
{
	include_once dirname(__FILE__)."/tool-login-form.php";
}
else
{
	header("Location:./");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kams File Manager</title>
<link rel="shortcut icon" href="style/images/icon.png" type="image/jpeg" />
<link rel="stylesheet" type="text/css" href="style/login.css" />
</head>
<body>
<div class="all">
<div class="box">
	<div class="box-inner">
        <div class="box-title">
        Kams File Manager
        </div>
        <div class="box-form">
        <form id="form1" name="form1" method="post" action="login.php">
        <div class="label">Username</div>
        <div class="field">
        <input type="text" name="username" id="username" class="input-text-login" autocomplete="off" />
        </div>
        <div class="clear"></div>
        <div class="label">Password</div>
        <div class="field">
        <input type="password" name="password" id="password" class="input-text-login" autocomplete="off" />
        </div>
        <div class="clear"></div>
        <div class="field">
        <div class="button-area"><input type="hidden" name="ref" id="ref" value="<?php echo strip_tags($_SERVER['REQUEST_URI']);?>" />
        <input type="submit" name="login" id="login" value="Login" class="login-button" />
        <a href="../member/reset-password.php" target="_blank">reset password</a></div>
        <div class="clear"></div>
        </div>
        </form>
         </div>
    </div>
</div>
</div>
</body>
</html>
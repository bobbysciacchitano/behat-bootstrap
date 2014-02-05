
<?php

	$hasError = false;

	if($_POST)
	{
		if(@$_POST['password'] == 'loveslamp')
		{
			header('Location:/behat-demo/my-account');
		} else {
			$hasError = true;
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>My Web site</title>
            
</head>
<body>

	<h1>My awesome website!</h1>

	<hr />

	<?php if($hasError): ?>
	<div style="border:1px solid red; color:red; padding: 0 10px 0 10px;" class="error-message">
		<p>Invalid username or password</p>
	</div>
	<?php endif; ?>

	<form action="" method="post">

	<dl>
		<dt>Username:</dt>
		<dd><input type="text" name="username" /></dd>
		<dt>Password:</dt>
		<dd><input type="text" name="password" /></dd>
	</dl>

	<p><input type="submit" name="login" value="Login" /></p>

</form>
</body>
</html>
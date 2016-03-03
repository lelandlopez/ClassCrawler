<?php
/*	Login Stuff Appears in the Top Right
	If Logs in then it goes back to page and it welcomes member
*/
$_SESSION['current_url'] = $_SERVER['PHP_SELF'];
if($_SERVER['QUERY_STRING'] != ""){
	$_SESSION['current_url'] = $_SESSION['current_url'] . "?" . $_SERVER['QUERY_STRING'];
}
?>
<div id="Control_Container">
	<?php
	if(isset($_SESSION['logged_in']) && isset($_SESSION['user_id']))
	{
	?>

	<div id="Control_Menu_Container" style="float: right;">
		<div id="Control_Menu_Header">
			Welcome <?php
			$sql="SELECT * FROM Users WHERE user_id = '{$_SESSION['user_id']}'";
			$result=mysql_query($sql); 
			$row = mysql_fetch_array($result); 
			echo $row['username']?>
		</div>
		<div id="Control_Menu">
			<a href=http://foodbuddie.com/logscripts/logout.php>Log Out</a>
			<br>
			<a href=http://foodbuddie.com/recipes/create.php>Create a Recipe</a>
			<br>
			<?php echo "<a href=http://foodbuddie.com/user.php?user_id=" . $_SESSION['user_id'] . ">View My Recipes</a>" ?>
		</div>
	</div>
	<?php
	}
	else
	{
	?>
	<table width="300" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#fff">
	<tr>
	<form name="form1" method="post" action="http://foodbuddie.com/logscripts/check_login.php">
	<td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
	<td colspan="2">User Login</td>
	</tr>
	<tr>
	<td width="78">Username</td>
	<td width="294"><input name="myusername" type="text" id="myusername"></td>
	</tr>
	<tr>
	<td>Password</td>
	<td><input name="mypassword" type="text" id="mypassword"></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="Submit" value="Login"> or <a href="signup.php">Here</a></td>
	</tr>
	</table>
	</td>
	</form>
	</tr>
	<tr>
		<td>
				If You're A Business Click <a href=http://businesses.foodbuddie.com>Here</a>
			</td>
		</tr>
	</table>

	<?php
	}
	?>
</div>

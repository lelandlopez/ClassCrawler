<?php
function prep_Input($input){
	stripslashes($input);
	mysql_real_escape_string($input);
	return $input;
}
?>
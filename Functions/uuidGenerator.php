<?php
function uuidGenerator($email){
	$prefix = substr(md5($email),0,12);
	return uniqid($prefix,true);

}
?>

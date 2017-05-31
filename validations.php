<?php
function password($passwd)
{
	if (strlen($passwd) < 8)
		return FALSE;
	if (!preg_match('/[a-z]/', $passwd))
		return FALSE;
	if (!preg_match('/[A-Z]/', $passwd))
		return FALSE;
	if (!preg_match('/[0-9]/', $passwd))
		return FALSE;
	else
		return TRUE;
}

function email($email)
{
	return (preg_match('/\w+\@\w+\.\w+/', $email));
}
?>

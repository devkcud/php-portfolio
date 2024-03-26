<?php
// NOTE: This is totally unsecure and I won't fix it :)
// TODO: Make it secure (i wont but it is good to have a todo)

$cookieName = "auth_session_id";

function getAuthCookie(): string {
	global $cookieName;
	return $_COOKIE[$cookieName];
}

function setAuthCookie(string $value) {
	setcookie("auth_session_id", $value, [
		'expires' => time() + (60 * 60 * 24),
		'path' => '/',
		'httponly' => true,
		'samesite' => 'Strict'
	]);
}

<?php
// NOTE: This is totally unsecure and I won't fix it :)
// TODO: Make it secure (i wont but it is good to have a todo)

$cookieName = "auth_session_id";

function getAuthCookie(): string {
	global $cookieName;
	return $_COOKIE[$cookieName] ?? "";
}

function setAuthCookie(string $value) {
	setcookie("auth_session_id", $value, [
		'expires' => time() + (60 * 60 * 24),
		'path' => '/',
		'httponly' => true,
		'samesite' => 'Strict'
	]);
}

function isLogged(): bool {
	// this is the best auth ive ever seen
	return getAuthCookie() !== "";
}

function logout() {
	global $cookieName;
	setcookie($cookieName, "", time() - 1); // lol
}

function redirectLogged(string $path) {
	if (isLogged()) header("Location: $path");
}

function redirectNotLogged(string $path) {
	if (!isLogged()) header("Location: $path");
}

<?php

include "../includes/demoEnv.php";
include "../includes/site.php";

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

setDemoEnv();

if (array_key_exists("siteToLoad", $_GET)) {
	$_SESSION["site"] = new Site($_GET["siteToLoad"]);
}
else if (empty($_SESSION["site"])) {
	$dirName = $_SESSION["defaultSite"];

	$_SESSION["site"] = new Site($dirName);
}
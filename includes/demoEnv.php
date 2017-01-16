<?php

function setDemoEnv() {

	setIncludePaths();

	$_SESSION["webHome"] = getHomeDir();

	$_SESSION["defaultSite"] = "atkodemoShared";

	unset($_SESSION["demo"]["sites"]);

	getSites("../sites");

	getSites("../mysites");

	$_SESSION["defaultPath"] = "../sites/default/";

	$_SESSION["configFiles"] = ["main", "regFlows", "theme", "regFields"];

}

// fixes the script's place in the filesystem
function getHomeDir() {
	$dirPathArr = explode("/", dirname(getcwd()));
	return end($dirPathArr);
}

function getSites($sitesHome) {

	$dirs = scandir($sitesHome);

	foreach ($dirs as $dir) {

		if ($dir === "." || $dir === "..") {}
		else {
			$path = $sitesHome . "/" . $dir;

			if (is_dir($path)) {
				$_SESSION["demo"]["sites"][] = $dir;
			}
		}
	}
}

function setIncludePaths() {
	$includePath = dirName(getcwd()) . "/includes";

	set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);
	set_include_path(get_include_path() . PATH_SEPARATOR . $includePath . "/config");
}
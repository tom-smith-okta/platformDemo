<?php

include "includes/includes.php";

$thisPage = new htmlPage($config);

$thisPage->setTitle($config["name"] . " - Register");

if (empty($_GET["regType"])) { $regType = "default"; }
else { $regType = $_GET["regType"]; }

$elements = [
	"mainCSS",
	"oktaWidgetCSScore",
	"oktaWidgetCSStheme",
	"oktaWidgetCSSlocal",
	"jquery"
];

$thisPage->addElements($elements);

$thisPage->setConfigValue("regDesc", getRegDesc($regType));

$thisPage->setConfigValue("regForm", getRegForm($regType)); 

$thisPage->loadBody("register", ["name", "webHome", "logo", "regForm", "regDesc"]);

$thisPage->display();

// might move these to $config
function getRegDesc($regType) {

	$regTypes["default"]["title"] = "Default registration flow";
	$regTypes["default"]["desc"] = "A user record will be created in the Okta universal directory, and the user will be provisioned to Salesforce Chatter.";

	$regTypes["vanilla"]["title"] = "Vanilla registration flow";
	$regTypes["vanilla"]["desc"] = "A basic user record will be created in the Okta universal directory.";

	$regTypes["withMFA"]["title"] = "MFA registration flow";
	$regTypes["withMFA"]["desc"] = "A user record will be created in the Okta universal directory. The user must use a 2nd factor every time they authenticate.";

	$regTypes["withEmail"]["title"] = "Email verification user flow";
	$regTypes["withEmail"]["desc"] = "A user record will be created in the Okta universal directory. The user must verify their email address before they can authenticate.";

	$regTypes["okta"]["title"] = "Okta admin registration";
	$regTypes["okta"]["desc"] = "An Okta employee can register and get admin access (read-only) to the demo tenant.";

	$returnVal = "<p><b>" . $regTypes[$regType]["title"] . ":</b></p>\n";
	$returnVal .= "<p>" . $regTypes[$regType]["desc"] . "</p>\n";

	return $returnVal;

}

function getRegForm($regType) {

	$regForm = file_get_contents("html/regFormTemplate.html");

	$formFieldTemplate = file_get_contents("html/regFormFieldTemplate.html");

	$fieldsHTML = "";

	// First name
	$fields["firstName"]["type"] = "text";
	$fields["firstName"]["placeholder"] = "First name";

	// Last name
	$fields["lastName"]["type"] = "text";
	$fields["lastName"]["placeholder"] = "Last name";

	// email
	$fields["email"]["type"] = "text";
	$fields["email"]["placeholder"] = "email";

	if ($regType == "vanilla" || $regType == "default") {
		// password
		$fields["password"]["type"] = "password";
		$fields["password"]["placeholder"] = "password";		
	}

	foreach ($fields as $fieldName => $properties) {

		$formField = $formFieldTemplate;

		$input = "<input name = '" . $fieldName . "'";

		foreach ($properties as $propertyName => $value) {
			$input .= " " . $propertyName . " = '" . $value . "'";

			if ($value == "hidden") {
				$input .= " style='display:none'"; 
			}
		}

		$input .= ">";

		$formField = str_replace("%input%", $input, $formField);

		$fieldsHTML .= $formField;
	}

	$regForm = str_replace("%regType%", $regType, $regForm);

	$regForm = str_replace("%fields%", $fieldsHTML, $regForm);

	return $regForm;

}
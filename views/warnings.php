<?php

include "../includes/includes.php";

echo "<p>warnings:</p>";

foreach ($config["warnings"] as $warning) {
	echo "<p>" . $warning . "</p>";
}
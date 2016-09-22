<?php
include_once "classes/UserHandler.php";
UserHandler::logout();
header("Location: index.php");

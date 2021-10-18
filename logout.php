<?php
require_once('includes/config.php');
require_once('includes/websockets.php');

session_start();
Mus('disconnect', $_SESSION['login']);
session_destroy();
unset($_SESSION['login']);
unset($_SESSION['pin']);
header("Location: $configBaseUrL/index");
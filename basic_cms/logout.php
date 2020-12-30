<?php
session_start();

session_destroy();

header ('location: login.php?logout=You are successfully logged out!! Come back soon...');

?>
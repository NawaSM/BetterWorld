<?php
session_start();
session_destroy();
header("Location: org-login.php");
exit();
?>
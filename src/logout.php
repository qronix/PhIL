<?php
session_start();
session_unset($_SESSION['username']);
session_unset($_SESSION['role']);
session_destroy();
header("Location: index.php");
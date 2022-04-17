<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['ONLINE']);
header('Location:index.php');
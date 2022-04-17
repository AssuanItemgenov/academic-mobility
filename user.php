<?php
if (isset($_SESSION['ONLINE']) && $_SESSION['ONLINE']) {
	define('ONLINE', true);
}else{
	define('ONLINE', false);
}
<?php

session_start();
session_destroy();
header('Location: ..\Bienvenue.php');
exit();
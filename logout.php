<?php

require_once 'bootstrap.php';

$auth_user->logout();
header("Location: /");

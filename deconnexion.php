<?php

session_start();

include_once('utils/utils.php');

session_destroy();

header('location:index.php');

exit;
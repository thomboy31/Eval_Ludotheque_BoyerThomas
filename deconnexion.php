<?php

session_start();

include('utils/utils.php');

session_destroy();

header('location:index.php');

exit;
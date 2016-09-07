<?php

require_once 'session.php';
 
start_session();
try_to_logout();
destroy_session();

header('Location: ../view_list.php');
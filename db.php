<?php

ini_set('display_errors',1);
define('DATABASE_USERNAME', 'dbuser');
define('DATABASE_PASSWORD','keymaeda2');
define('DATABASE_NAME','todo_git_app');
define('DSN', 'mysql:dbhost=localhost;unix_socket=/tmp/mysql.sock;dbname='.DATABASE_NAME);
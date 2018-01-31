<?php

require_once 'vendor/autoload.php';

$cmd = new Commando\Command();

// Define first option
$cmd->option()
    ->require()
    ->describedAs('GitHub Username');



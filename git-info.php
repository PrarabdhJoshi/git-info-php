<?php



require_once 'vendor/autoload.php';
$cmd = new Commando\Command();

// Define first option
$cmd->option()
    ->require()
    ->describedAs('GitHub Username');

echo "Public Repositories for {$cmd[0]}:", PHP_EOL;


$opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"User-agent: PrarabdhJoshi\r\n"
    )
  );
  
$context = stream_context_create($opts);
  
  // Open the file using the HTTP headers set above
$json = file_get_contents("https://api.github.com/users/{$cmd[0]}/repos", false, $context);
$obj = json_decode($json);
echo $obj[0]->id,PHP_EOL;
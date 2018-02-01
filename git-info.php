<?php

require_once 'vendor/autoload.php';
$cmd = new Commando\Command(); //instantiate a new command

// Define first option
$cmd->option()
    ->require()
    ->describedAs('GitHub Username');


//get the argument for ascending or descending values
$cmd->option('o')
->aka('order')
->describedAs('type asc to display a sorted result or dsc to display a reversed sorted result based on Stargazers_count');


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

//sort the array function
function cmp($a, $b)
{
    return strcmp($a->stargazers_count,$b->stargazers_count);
}
//reverse sort the array
function rcmp($a, $b)
{
    return strcmp($b->stargazers_count,$a->stargazers_count);
}
//call the sorting on the object
($cmd[1]=="dsc")?usort($obj, "rcmp"):usort($obj,"cmp");


for ($x = 0; $x < count((array)$obj); $x++) {
    echo "{$obj[$x]->name} \t {$obj[$x]->stargazers_count}",PHP_EOL;
} 

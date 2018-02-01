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
    if($a->stargazers_count == $b->stargazers_count){ return 0 ; }
	return ($a->stargazers_count < $b->stargazers_count) ? -1 : 1;
}
//reverse sort the array
function rcmp($a, $b)
{
    if($a->stargazers_count == $b->stargazers_count){ return 0 ; }
	return ($a->stargazers_count > $b->stargazers_count) ? -1 : 1;
}
//call the sorting on the object
($cmd[1]=="dsc")?usort($obj, "rcmp"):usort($obj,"cmp");

//print the data as a tabel
//set table mask
$mask = "\t %-45.30s|\t %15s \n";
//append a newline
printf("\n");
printf($mask, 'Repository', 'StarGazers Count');
printf("\n");

for ($x = 0; $x < count((array)$obj); $x++) {
    printf($mask, $obj[$x]->name, $obj[$x]->stargazers_count);

    //echo "{$obj[$x]->name} \t {$obj[$x]->stargazers_count}",PHP_EOL;
} 


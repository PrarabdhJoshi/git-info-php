<?php

require_once 'vendor/autoload.php';
$cmd = new Commando\Command(); //instantiate a new command
$page = 2; //paginate across the result data
// Define first option
$cmd->option()
    ->require()
    ->describedAs('GitHub Username');


//get the argument for ascending or descending values
$cmd->option('d')
->aka('dsc')
->describedAs("[Default] Ascending Order Display \nType --dsc or -d to display a reverse sorted result based on Stargazers_count")
->boolean();

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
($cmd['dsc'])?usort($obj, "rcmp"):usort($obj,"cmp");

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
$json = file_get_contents("https://api.github.com/users/{$cmd[0]}/repos?page={$page}", false, $context);
$obj = json_decode($json);
while(count((array)$obj)>0){
    printf("\n");
    printf("Do you want to see more? y/n \t");
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != 'y' ){
        echo "ABORTING!\n";
        exit;
    }
    fclose($handle);
    echo "\n"; 
    echo "Here are a list of more {$cmd[0]} repositories\n\n";
    printf("\n");
    printf($mask, 'Repository', 'StarGazers Count');
    printf("\n");
    ($cmd['dsc'])?usort($obj, "rcmp"):usort($obj,"cmp");
    for ($x = 0; $x < count((array)$obj); $x++) {
        printf($mask, $obj[$x]->name, $obj[$x]->stargazers_count);
    
        //echo "{$obj[$x]->name} \t {$obj[$x]->stargazers_count}",PHP_EOL;
    } 
    $page+=1;
    $json = file_get_contents("https://api.github.com/users/{$cmd[0]}/repos?page={$page}", false, $context);
    $obj = json_decode($json);
}



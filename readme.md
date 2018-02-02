# Git-Info-PhP

### Get a list of User's Public Repository from Commnad line 

git-info-php is a PHP command line interface application that displays the list of a user's public GitHub Repositories based on the ordering structure as demanded by the application user. 

## Installation
The app requires that you are running PHP 5.3 or higher with Composer.

### 
    Download and build Composer
    Make it globally accessible
    cd to your the directory where you have extracted your script files and run composer install
    
## Usage
    php git-info.php <optional argument> [user]

### For Help Run:
    php git-info.php --help
 
### optional Argument
    -d or --dsc for displaying repositories, reverse sorted based on the Stargaze_count
    [Default] Ascending order

### Example
    php git-info.php -d prarabdhjoshi
    

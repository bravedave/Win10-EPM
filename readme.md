# Windows 10 End Point Monitor for DVC

This module can be added to any project using DVC Framework

## Install
  composer require bravedave/wepm

  * review the app/controller/home to get this working, the easiest would be to copy that file:

```php
<?php
class wepm extends dvc\wepm\controller {}

```

## Standalone component
To use DVC on a Windows 10 computer (Devel Environment)
1. Install PreRequisits
   * Install PHP : http://windows.php.net/download/
      * Install the non threadsafe binary
      * by default there is no php.ini (required)
        * copy php.ini-production to php.ini
        * edit and modify/add (uncomment)
          * extension=fileinfo
          * extension=sqlite3
          * extension=mbstring
          * extension=openssl
      * *note these instructions for PHP Version 7.2.7, the older syntax included .dll on windows*

   * Install Git : https://git-scm.com/
     * Install the *Git Bash Here* option
   * Install Composer : https://getcomposer.org/

1. Clone or download this repo
   * Start the *Git Bash* Shell
     * Composer seems to work best here, depending on how you installed Git
   * mkdir c:\data
   * cd c:\data
   * setup a new project
     * `composer create-project bravedave/win10_epm wepm @dev`
   * the project is now set up in c:\data\wepm
     * cd wepm

To run the demo
   * Review the run.cmd
     * The program is now accessible: http://localhost
     * Run this from the command prompt to see any errors - there may be a firewall
       conflict options to fix would be - use another port e.g. 8080

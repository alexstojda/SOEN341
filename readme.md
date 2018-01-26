# UC4 SOEN 341

### Team Members
 - Alex Stojda
 - Evangelos Dimopoulos
 - Andrew Hanichkovsky
 - Nicolas Brodeur-Champagne
 - Peter Granitski

## Laragon wamp stack for local development:
1. Install [Laragon WAMP](https://sourceforge.net/projects/laragon/files/releases/3.2/laragon-wamp.exe/download)
3. Run PHPStorm / IDEA and create a new project from Github in your laragon's documents root folder. (Typically located in `{LARAGON_INSTALL}/www/`)
3. Laragon should now list your new project. Open the control panel and hit start all.
4. Open Terminal (the laragon one) in SOEN341 folder and type `composer install`

You can continue setting up while it fetches all our dependencies for you.

## Configuring your local environment :
### Apache config
Since you're pulling this rep, laragon's automagic vhost will be be slightly wrong. To fix it :
1. Open Laragon's Menu
2. Navigate to Apache > sites-enabled > auto.soen341.oo.conf
3. Append `public/` to every instance of the directory path, i.e when you seen `.../SOEN341/<add here>`
4. May need to restart the apache service for things to update.

### .env file
Pretty straight forward but nothing will work unless you do this.
- you can do this from within PHPStorm
- Copy the .env.example file and call it .env

### MySQL DB setup
Again, you're pulling a repo so laragon won't automatically create a database for you. Lets do it manually :
1. Open HeidiSQL from laragon's menu
2. Login with root and your password (empty by default)
3. Create a new database and name it SOEN341
4. Switch to a terminal and run `php artisan migrate` in your project root

## General PHPStorm Setup
### Plugins
So PHPStorm helps you as much as it can but it needs to know what it's reading.

So if you're using PHPStorm apparently everything is installed except : 
- Laravel Plugin
- LaravelStorm

To install them : open Settings (CTRL + ALT + S) > Plugins > Click browse repositories and search for each.

### Shiny Terminal (cmder.exe)
*Not really required but will make life VERY easy*
1. Open Settings (CTRL + ALT + S) -> Tools > Terminal
2. Change Shell path to `{LARAGON_INSTALL}\bin\cmder\cmder.bat`
PS: you wont have to add all the fun thing into PATH if you use it.

### Add PHP cli
1. Open File > Settings (CTRL + ALT + S) -> Languages & Frameworks > PHP
2. Change language level to appropriate version. (We're using 7.2)
3. Click the ... next to CLI interpreter and hit the + to add a new one.
4. The path to the php executable is as follows `{LARAGON_INSTALL}\bin\php\{some_php_version_here}\php.exe`
5. (Optional debugger step)
6. Back in the 1st window you should go into the PHP Runtime tab and hit Sync Extensions w/ Interpreter.

### Composer
*Not really required but will make life easy*
1. Open Settings (CTRL + ALT + S) -> Languages & Frameworks > PHP > Composer (Install from plugins if you don't have it for some reason)
2. Path to json should be `{PROJECT_PATH}\composer.json`
3. For the execution choose executable, add the following path `{LARAGON_INSTALL}\bin\composer\composer.bat` and use default interpreter. (Alternatively choose phar and use the .phar)

### Node / NPM
*Really not required but will make my life slightly easier*
1. Open Settings (CTRL + ALT + S) -> Languages & Frameworks > Node.js & NPM
2. Add a new node interpreter
3. Path to the executable is as follows `{LARAGON_INSTALL}\bin\nodejs\{some_node_version_here}\node.exe`

### Database View
*Not really required unless you want to handle DB things.. laravel will handle a big chunk of it automatically*
1. Open the database tab in the top of the right sidebar.
2. Click the + icon > Data Source > MySQL
3. Create a new source with the following info. Host = `localhost`, Database = `SOEN341`, `user = root`, `password = {blank or wtvr you use}`
4. You can how use the databse viewer inside PHPStorm / IDEA instead of HeidiSQL.
P.S : We don't care much since laravel will handle all the database stuff for you.

## Debug and Testing
### PHPunit
First time you run PHPunit (click run on any of the files in tests) it will try to scare you with a big dialog box
If you already setup a PHP cli interpreter then just click the Fix button and you should be done.
Otherwise follow the **Add PHP cli** section then select the new interpreter.

#### Writing unit tests
I'll probably hook you up with examples later, just remind me.

### Setting up XDebug with PHPStorm
1. Download the appropriate version of [xDebug](https://xdebug.org/download.php) (Yours should be 7.2 64bit VC15 TS) [click here for direct link](https://xdebug.org/files/php_xdebug-2.6.0RC1-7.2-vc15-x86_64.dll)
2. Move it into your php path inside the ext folder : `{LARAGON_INSTALL}\bin\php\{some_php_version}\ext\`
3. Rename it to simply `php_xdebug.dll`

#### php.ini Changes
1. Open Laragon's menu > PHP and choose php.ini
2. Copy & Paste these lines to the bottom of the file
    ```
       [XDebug]
       xdebug.remote_enable = 1
       xdebug.remote_handler = "dbgp"
       xdebug.remote_host = "127.0.0.1"
    ```
3. Finally Restart Laragon and enable xdebug in Menu > PHP > Extentions.
4. Quick test : open the window you saw in the **PHP cli** section and add a new interpreter with same info, it should now say you have xdebug 2.6.0rc installed as your debugger.

#### PHPStorm config
1. Open Run > Edit Configurations
2. Click +, choose PHP Web Application and write the start url as ```http://soen341.oo```
3. Click on the 3 dots near server
  - Add a new entry as [name wtvr] with host ```localhost``` on port ```80``` with ```XDebug```
  - Ignore path mapping, we're local
4. Back in PHP Web App config choose your new server
5. You can now run debug which will open a new XDebug session and send you to our index page.
  - Add breakpoints as you wish, dig through objects and step through as much as your heart desires.

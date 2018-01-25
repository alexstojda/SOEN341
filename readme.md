# UC4 SOEN 341

### Team Members
 - Alex Stojda
 - Nicolas Brodeur-Champagne

---

## Laragon wamp stack for local development:
1. Install [Laragon WAMP](https://sourceforge.net/projects/laragon/files/releases/3.2/laragon-wamp.exe/download)
3. Run PHPStorm / IDEA, Create a new project from Github in your laragon's documents root folder. (Typically `{LARAGON_INSTALL}/www/`)
3. Laragon should now list your new project. Open the control panel and hit start all.

## Configuring your local environment :
### Apache config
Since you're pulling this repo then laragon's automagic vhost will be be slightly wrong. To fix it :
1. Open Laragon's Menu
2. Navigate to Apache > sites-enabled > auto.soen341.oo.conf
3. Append `public/` to every instance of the directory path, i.e when you seen `.../SOEN341/<add here>`
4. May need to restart the apache service for things to update.

### MySQL DB setup
Again, you're pulling a repo so laragon won't automatically create a database for you.
1. Open HeidiSQL from laragon's menu
2. Login with root and your password (should be empty by default)
3. Create a new database and name it SOEN341
4. Switch to a terminal and run `php artisan migrate` in your project root
``
### .env file
- Copy the .env.example file and call it .env
- you can do this from within IDEA / PHPStorm
- you may wanna review it and make sure it it reflects your actual setup

## General IntelliJ Setups
Not really required but preferred

### Database View
1. Open the database tab in the top of the right sidebar.
2. Click the + icon > Data Source > MySQL
3. Create a new source with the following info. Host = `localhost`, Database = `SOEN341`, `user = root`, `password = {blank or wtvr you use}`
4. You can how use the databse viewer inside PHPStorm / IDEA instead of HeidiSQL.
P.S : We don't care much since laravel will handle all the database stuff for you.

### Add PHP cli
1. Open File > Settings (CTRL + ALT + S) -> Languages & Frameworks > PHP
2. Change language level to appropriate version. `We're using 7.2 `
3. Click the ... next to CLI interpreter and hit the + to add a new one.
4. The path to the php executable is as follows `{LARAGON_INSTALL}\bin\php\{some_php_version_here}\php.exe`
5. (Optional debugger step)
6. Back in the 1st window you should go into the PHP Runtime tab and hit Sync Extensions w/ Interpreter.

### Composer
1. Open Settings (CTRL + ALT + S) -> Languages & Frameworks > PHP > Composer (Install from plugins if you don't have it for some reason)
2. Path to json should be `{PROJECT_PATH}\composer.json`
3. For the execution choose executable, add the following path `{LARAGON_INSTALL}\bin\composer\composer.bat` and use default interpreter. (Alternatively choose phar and use the .phar)

### Node / NPM
1. Open Settings (CTRL + ALT + S) -> Languages & Frameworks > Node.js & NPM
2. Add a new node interpreter
3. Path to the executable is as follows `{LARAGON_INSTALL}\bin\nodejs\{some_node_version_here}\node.exe`

### Shiny Terminal
1. Open Settings (CTRL + ALT + S) -> Tools > Terminal
2. Change Shell path to `{LARAGON_INSTALL}\bin\cmder\cmder.bat`

### Debug and Testing
## PHPunit
First time you run PHPunit (click run on any of the files in tests) it will try to scare you with a big dialog box
If you already setup a PHP cli interpreter then just click the Fix button and you should be done.
Otherwise follow **Add PHP cli** then select the new interpreter.


 @andrew redo... we need composer xdebug.. so I'll rewrite later
## Setting up XDebug with PHPStorm
1. Follow [This Tutorial](https://forum.laragon.org/topic/264/tutorial-how-to-add-xdebug-to-laragon)

####USELESS
5. Copy & Paste these lines after the line you added in the tutorial above.
```
       xdebug.remote_enable = 1
       xdebug.remote_handler = "dbgp"
       xdebug.remote_host = "127.0.0.1"
```
- Finally Restart apache and rejoice.

#### PHPStorm config
1. Open Run->Edit Configurations
2. Click +, choose PHP Web Application and write the start url as ```http://local.exagens.com```
3. Click on the 3 dots near server now
 - Add a new entry as [name wtvr] with host ```localhost``` on port ```80``` with ```XDebug```
  - Ignore path mapping, we're local
4. Back in PHP Web App config choose your new server
5. You can now run debug which will open a new XDebug session and send you to our index page.
 - Add breakpoints as you wish, dig through objects and step through as much as your heart desires.

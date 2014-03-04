SimPas [![Build Status](https://travis-ci.org/Macsch15/SimPas.png?branch=master)](https://travis-ci.org/Macsch15/SimPas)
======

Simple Pastebin Application based on PHP.

Demo is here: http://www.pastebin.macsch15.pl

Requirements
======
* PHP 5.4 and above
* MySQL 5.1 and above
* Shell access on server


How to Install?
======
Copy all files to your server and edit configuration files:

```
library/Application/Configuration/Resources/Database.json
```

```
library/Application/Configuration/Resources/Default.json
```

After you set configuration, type in command line


```
$ php cmd/console SyncDb
```

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

Command line interface
======

**Create Database schema**

```
$ php cmd/console SyncDb
```

**Clear Database**

```
$ php cmd/console ClearDb
```

**Check updates**

```
$ php cmd/console CheckUpdates
```

**Rebuild cache**

```
$ php cmd/console CacheRebuild
```

Settings
======

| Setting key  | Decription | Default value |
| ------------- | ------------- | ------ |
| full_url  | URL of the site with a trailing slash  | - |
| site_title  | Main title  | SimPas Application |
| site_description_crawlers  | Description for search engines (e.g Google) | SimPas Application |
| shortcut_icon_url  | Favicon. URL or path  | - |
| admin_email  | Administrator email (used on error pages)  | admin@example.com |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |
| full_url  | URL of the site with a trailing slash  | - |


Author
======

**Macsch15**
* E-Mail: poczta@macsch15.pl
* Twitter: https://twitter.com/Macsch15

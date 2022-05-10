SimPas [![PHPUnit](https://github.com/Macsch15/SimPas/actions/workflows/main.yml/badge.svg)](https://github.com/Macsch15/SimPas/actions/workflows/main.yml)
======

Fat-free Pastebin App

[![Image: QC3JcsybrX7v68KkVGLseO8ZqZLkxo](https://storage.macsch15.pl/images/QC3JcsybrX7v68KkVGLseO8ZqZLkxo.png)](https://storage.macsch15.pl/images/QC3JcsybrX7v68KkVGLseO8ZqZLkxo.png)

[![Image: nD6oDrNAi4YiuS8Yblfm0VUTOQaIhh](https://storage.macsch15.pl/images/nD6oDrNAi4YiuS8Yblfm0VUTOQaIhh.png)](https://storage.macsch15.pl/images/nD6oDrNAi4YiuS8Yblfm0VUTOQaIhh.png)

Requirements
======
* PHP 7.3 and above
* MySQL or PostgreSQL access
* Shell access on server (CLI)


How to Install?
======
Run composer:
```
$ composer install
```

Edit configuration files:

```
config/database.php
```

```
config/app.php
```

After you set configuration, type in command line


```
$ php cli SyncDb
```

After installing SimPas, you should configure your web server document / web root to be the **public** directory.

Testing
======
```
$ ./vendor/phpunit
```

I have old release! How I can update SimPas?
======

Bad news.
SimPas doesn't have an upgrader. Only way to install fresh release is to re-upload all files, configure low-level settings and enter the command:

```
$ php cli CacheRebuild
```

Some (e.g from 0.2 to 0.3) releases may need re-sync database schema, in this case command above is not enough, you must fire this as well in command-line:

```
$ php cli UpdateDb
```

*Upgrader be maybe coming soon. Who knows?*


Settings
======
:exclamation: **IMPORTANT: Always use backslash for single and double quote, e.g ```you\'re``` ```you\"re```**

#### config/app.php


|    Key      |  Description | Value type | Default value |
|-------------|-------------|-------------| ------------- |
full_url     | Full address of SimPas installation **with ending slash**  |  String  |  http://localhost/SimPas/develop/
site_title    | Site title displayed on page index  | String  | SimPas Application
site_description_crawlers  | Site description for crawlers (e.g Google)  | String  | SimPas Application
show_index_in_urls  | Change for "true" only if your server NOT have a mod_rewrite | true/false  | false
shortcut_icon_url  | Favicon path or URL  | String  | *void*
admin_email  | This is required for "Report Abuse"  | String  | *void*
default_geshi_language  | Default syntax hightlighter  | String  | Text
site_offline  | Turn off visibility of site for guests  | true/false  | false
offline_allowed_ip  | IP address who can view site when site is "offline"  | String  | 127.0.0.1
offline_message  | Optional message for offline page  | String  | *void*
offline_message_allow_html  | Allow to use HTML entities in offline message?  | true/false  | false
theme  | Default theme. If you want add new one, you can copy "default" folder (in /assets/), rename, edit CSS/JS and enter in this setting new folder name  | String  | default
max_chars  | Maximum characters in paste   | Integer  | 50000
max_size_in_kb  | Maximum size of paste (in KB)  | Integer  | 512
translations  | SimPas translations are powered by [GetText](http://en.wikipedia.org/wiki/Gettext). You can translate this by using software (e.g [Poedit](http://poedit.net/)). When translation is configured, move it to ```library/Application/Translations/Resource``` | true/false  | false
translation_domain  | Filename of .po and .mo file in ```library/Application/Translation/Resource/{locale}/LC_MESSAGES/```  | String  | messages
locale  | Required. Using for HTML documents, translation and relative date. [List of all locales](http://framework.zend.com/manual/1.12/en/zend.locale.appendix.html)  | Array  | ```["en", "en_EN"]```
accented_characters  | Special characters for specific language  | String  | ĘÓĄŚŁŻŹĆŃęóąśłżźćń
default_timezone  | Timezone. [List of all timezones](http://en.wikipedia.org/wiki/List_of_tz_database_time_zones)  | String  | Europe/Warsaw
charset  | Charset.  | String  | UTF-8
gzip_compression  | [GZip](http://en.wikipedia.org/wiki/Gzip) compression. Required ```zlib``` library  | true/false  | false
antyflood_enabled  | Antyflood  | true/false  | true
antyflood_delay_in_seconds  | Antyflood delay (in seconds)  | Integer  | 30
banned_ip  | IP addresses who can't send pastes. Wildcard is available by ```*```  | Array  | ```["8.8.8.8", "8.8.8.*"]```
google_analytics_ua_code  | Google Analytics UA code is located on generated by GA javascript, e.g ```ga('create', 'UA-0000000-00', 'example.com');```  | String  | *void*
latest_pastes  | Number of pastes displayed on ```/latest``` page  | Integer  | 20
antispam_enabled  | Questions&Answers enabled?  | true/false  | true
author_website_enabled | Author website enabled?  | true/false  | true
delete_expired_pastes | Delete expired pastes? | true/false | true
cookie_path | Cookies path | String | *void*
cookie_domain | Cookies domain | String | *void*
cookie_secure | Use secure cookies? | true/false | false
hot_paste | Number of hits needed to make "hot paste" | Integer | 1500
show_cookies_info | Display information about using cookies in footer? | true/false | false

#### config/database.php


|    Key       |  Description  |   Value type  | Default value |
|------------- | ------------- | ------------- | ------------- |
driver  | Datasource driver. Available: **mysql** or **postgresql** | String | mysql
server  | Database server  | String  | localhost
port  | Database custom port  | Integer  | 3306
database  | Database name  | String  | newsimpas
username  | Database username  | String  | root
password  | Database password  | String | *void*
charset  | Database charset  | String  | utf8
collate  | Database collate  | String  | utf8_general_ci

#### config/mailer.php


|    Key       |  Description  |   Value type  | Default value |
| ------------- | ------------- | ------------- | ------------- |
transport  | Available: **mail** (sending email by php mail()), **smtp** and **sendmail**  | String  | mail
host  | Server (for SMTP transport)  | String  | localhost
port  | Port (for SMTP transport)  | Integer  | 25
username  | Username (for SMTP transport)  | String  | *void*
password  | Password (for SMTP transport)  | String  | *void*
protocol  | Protocol (for SMTP transport). Available: **tls**, **ssl**  | String  | tls
sendmail_command  | Sendmail command (for sendmail transport)  | String  | ```/usr/sbin/sendmail -bs```

#### config/qa.php


|    Key       |     Value    |
|------------- | -------------|
Question       |    Answer. Can be multiple choices, e.g ```["5", "Five"]```


Command line interface
======

**Create Database schema**

```
$ php cli SyncDb
```

**Update Database schema**

```
$ php cli UpdateDb
```

**Clear Database**

```
$ php cli ClearDb
```

**Rebuild cache**

```
$ php cli CacheRebuild
```

**Erasing all expired pastes**

```
$ php cli EraseExpiredPastes
```

How I can translate "Rules" and "Cookies policy"?
======

In files:
```
library/Application/View/Templates/Text/Rules.html.twig
```
and
```
library/Application/View/Templates/Text/Cookies.html.twig
```

You can translate it or simply copy HTML template from other site.

## Bug reports and feedback
If you have found bug, please report it on [issue tracker](https://github.com/Macsch15/SimPas/issues "issue tracker").

If you discover a security vulnerability, please send an e-mail to *web[at]macsch15.pl*.

### MIT Licence

Copyright (c) 2021 Maciej Schmidt

Permission is hereby granted, free of charge, to any person obtaining a copy 
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,

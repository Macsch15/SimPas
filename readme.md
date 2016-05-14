#SimPas

#####Fat-free Pastebin Application
(Version 0.7) *Work in progress...*

Archive 0.6: [0.6 branch](https://github.com/Macsch15/SimPas/tree/archive)

###Requirements
- PHP 5.6
- Support for PostgreSQL, MySQL, SQLite or SQL Server
- Composer and CLI access

###Downloading and installing
```
$ git clone https://github.com/Macsch15/SimPas.git
$ cd SimPas
$ composer install
$ php artisan migrate
```

**Remember!** Before fire ```php artisan migrate``` command configure database connection in file **.env**.

###MIT Licence

Copyright (c) 2016 Maciej Schmidt

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
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

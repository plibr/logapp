# logapp

1. clone project

2. install app
> $ composer install

3. execute migration process
> $ ./app/protected/yiic migrate up

4. parse access log file to database 
> $ ./app/protected/yiic logparser

5. to see log data list by GET
visit http://logapp.plibr.click/index.php/api/log

6. to see log data list group by ip

visit http://logapp.plibr.click/index.php/api/log?group_by=ip
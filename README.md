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

7. to see log data list filtered by ip

visit http://logapp.plibr.click/index.php/api/log?filter=[{"property":"ip","value":"60.0.0.0","operator":">="},{"property":"ip","value":"160.0.0.0","operator":"<="}]

visit http://logapp.plibr.click/index.php/api/log?filter=[{"property":"ip","value":"60.0.0.0","operator":">="}]

8. to see log data list filtered by date

visit http://logapp.plibr.click/index.php/api/log?filter=[{"property":"date","value":"2022-05-8","operator":">="},{"property":"date","value":"2022-05-20","operator":"<="}]

visit http://logapp.plibr.click/index.php/api/log?filter=[{"property":"date","value":"2022-05-15","operator":"<="}]
Readme
=============

- copy `station/send.sh` to rasperry-pi
- add crontab job
- copy other stuff to your webserver
- make sure `data` is writeable
- copy `config.user.php_backup` to `config.user.php` and adjust the settings

The last step can be done  by

	chown www-data:www-data -R data
	chmod u+w -R data
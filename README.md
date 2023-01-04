# ssl
https://api.hifyc.link/create-virtual-host.php?serverName=dev.cloud443.in

https://api.hifyc.link/list.php

https://api.hifyc.link/ssl.php?domain=dev.cloud443.in

curl -X POST https://api.hifyc.link/delete-config.php -d '{"config_file":"dev.cloud443.in.conf"}'

Defaults        secure_path="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin"
www-data ALL=(ALL) NOPASSWD: /usr/sbin/a2ensite
www-data ALL=(ALL) NOPASSWD: /usr/sbin/service apache2 restart
www-data ALL=(ALL) NOPASSWD: /usr/bin/certbot
www-data ALL=(ALL) NOPASSWD: /usr/sbin/a2dissite


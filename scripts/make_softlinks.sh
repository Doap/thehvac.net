#!/bin/bash
site=thehvac.net

rm /var/www/html/$site/wp-content/plugins/plugins
rm /var/www/html/$site/wp-content/plugins
rmdir /var/www/html/$site/wp-content/plugins
ln -s /srv/www/uploads/sinkjuice/$site/plugins/ /var/www/html/$site/wp-content/plugins
rm /var/www/html/$site/wp-content/themes/themes
rm /var/www/html/$site/wp-content/themes
rmdir /var/www/html/$site/wp-content/themes
ln -s /srv/www/uploads/sinkjuice/$site/themes/ /var/www/html/$site/wp-content/themes


rm /var/www/html/$site/wp-content/uploads/uploads
rm /var/www/html/$site/wp-content/uploads
ln -s /srv/www/uploads/sinkjuice/$site/uploads/ /var/www/html/$site/wp-content/uploads

#cp -f /startup/footer.php.$site /var/www/html/$site/wp-content/themes/AandP-Child/footer.php 
/startup/genvhost.sh $site
/startup/make-wp-configs $site
cat /startup/htaccess.default > /var/www/html/$site/.htaccess

echo "scripts/make_softlinks.sh just ran on `curl -s http://169.254.169.254/latest/meta-data/public-ipv4` ($site)." >> /tmp/startup.log

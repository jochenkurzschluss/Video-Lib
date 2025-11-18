#!/bin/bash
#
# Vorbereitungs Script der video_lib
# 
# Copyright DO2ITH Michael Herholt
#
#
#
#
# Nötige pakete Installieren
sudo apt-get update
sudo apt-get upgrade -y
sudo apt-get install apache2 apache2-utils php-xml* fail2ban multitail proftpd certbot* git -y
sudo apt-get autoclean -y
#
#
# Die Nötigen Dienste aktivieren
sudo a2enmod auth_basic
sudo a2enmod authz_user
sudo a2enmod rewrite
sudo a2enmod expires
sudo a2enmod deflate
sudo a2enmod rewrite
sudo a2enmod auth_digest
#
#
# In das home Verzeichniss wechseln und den git download ausführen
cd ~
git clone https://github.com/jochenkurzschluss/Video-Lib.git
#
#
# Ausgabe Das alles erledigt ist.
#
#
echo "#"
echo "#"
echo "#"
echo "#    Danke für download und Versuch ! Weitere Infos und hilfe"
echo "#    http://discord.jochenkurzschluss.de und https://github.com/jochenkurzschluss/Video-Lib/wiki"
echo ""

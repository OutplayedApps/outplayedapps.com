#!/bin/bash 
git add -A
git commit --message "Crontab auto-commit; `date`"
#git remote add origin https://github.com/epicfaace/outplayedapps.com.git
git push origin master
#crontab -e
#MAILTO="youremail@domain.com"
#0 22 * * * /var/www/backupscript.sh
# run-parts /etc/cron.weekly -v
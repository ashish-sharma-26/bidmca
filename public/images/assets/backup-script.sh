#!/bin/bash

set -e

BACKUP_NAME=$(date +%y-%m-%d_%H:%M:%S)
DB=askwheels
DB2=upace

date
echo "Backing up MongoDB database to DigitalOcean Space: $SPACE_NAME"

echo "Dumping MongoDB $DB database to compressed archive"
mongodump --db $DB -o=$HOME/backup-aw/db/$BACKUP_NAME

mongodump --db $DB2 -o=$HOME/backup-aw/db/$BACKUP_NAME

echo 'Backup complete!'

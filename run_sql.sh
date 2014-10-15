#!/bin/bash
HOSTNAME="172.21.12.59"
PORT="3306"
USERNAME="root"
PASSWORD="root"
DBNAME="test_repo"
TABLENAME1="table_minlog"

#create db
create_db_sql="create database IF NOT EXISTS ${DBNAME}"
mysql -h${HOSTNAME}   -P${PORT}   -u${USERNAME} -p${PASSWORD} -e "${create_db_sql}"

#create table
create_table_sql="create table IF NOT EXISTS ${TABLENAME1} ( \
id int not null primary key auto_increment, \
ch char(8) not null unique key default '', \
phl char(8) not null default '', \
phr char(8) not null default '', \
refs varchar(200) not null default '', \
tags varchar(200) not null default '', \
subject varchar(200) not null default '', \
author varchar(20) not null default '', \
authorDate int(10) not null default 0, \
committer varchar(20) not null default '', \
commitDate int(10) not null default 0 \
)"
mysql -h${HOSTNAME}   -P${PORT}   -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${create_table_sql}"

#insert into data
# select ch, phs, refs, tags, subject from table_commit;
COLUMNS="(ch, phl, phr, refs, tags, subject, author, authorDate, committer, commitDate)"
REPO_BRACHS=$(git branch | cut -c 3-)
CI_HASH="c38cfa1"
for BR in ${REPO_BRACHS}
do
	for CI_HASH in $(git log --pretty=format:'%h' $BR)
	do
	CH="\"${CI_HASH}\""
	PHL="\"$(git log --pretty=format:'%p' ${CI_HASH} -1 | cut -d ' ' -f 1)\""  # split by space
	PHR="\"$(git log --pretty=format:'%p' ${CI_HASH} -1 | cut -d ' ' -f 2)\""  # split by space
	REFS="\"$(git log --pretty=format:'%d' ${CI_HASH} -1 | cut -c 2-)\""
	TAGS="\"\""
	SUBJECT="\"$(git log --pretty=format:'%f' ${CI_HASH} -1)\""
	AUTHOR="\"$(git log --pretty=format:'%an' ${CI_HASH} -1)\""
	AUTHORDATE="$(git log --pretty=format:'%at' ${CI_HASH} -1)"
	COMMITTER="\"$(git log --pretty=format:'%cn' ${CI_HASH} -1)\""
	COMMITDATE="$(git log --pretty=format:'%ct' ${CI_HASH} -1)"
	
	cu_sql="insert into ${TABLENAME1} ${COLUMNS} values ( \
		$CH, $PHL, $PHR, $REFS, $TAGS, $SUBJECT, \
		$AUTHOR, $AUTHORDATE, $COMMITTER, $COMMITDATE \
	) on duplicate key update refs=${REFS}"
	mysql -h${HOSTNAME}   -P${PORT}   -u${USERNAME} -p${PASSWORD} ${DBNAME} -e  "${cu_sql}"
	done
done
#git log --pretty=format:'%h %p' b3d3cf0 -1
#git log --pretty=format:'%at-%an' b3d3cf0 -1   # %ai %ci  author 
#git log --pretty=format:'%ct-%cn' b3d3cf0 -1   # committer 
#git log --pretty=format:'%s' b3d3cf0 -1
#git log --pretty=format:'%d' b3d3cf0 -1
# --abbrev-commit
#
exit 0
cd /home/mojun/gitst/test/log
git co -b test
git reset cb65e89 --hard
../ciAuto.sh t=={x,1,2,3}
git co test~
../ciAuto.sh tii{q,a,b,c}
tempA="$(git log --pretty=format:'%h' -1)"
git co test
git merge $tempA -m "test111"
../ciAuto.sh t=={y,4,5}
git co $tempA~ ; ../ciAuto.sh tii{w,4,5}
tempB="$(git log --pretty=format:'%h' -1)"
git co test
git merge $tempB -m "test222"
../ciAuto.sh t=={z,xx}












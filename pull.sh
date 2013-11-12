#!/bin/bash

source ~/.bash_profile

NEW_COMMIT="$1"
OLD_COMMIT="$2"

git stash && git pull --rebase

files=""
for i in $(git diff $NEW_COMMIT $OLD_COMMIT --name-only)
do
  git checkout $NEW_COMMIT $i
  files="$files $i"
done

codercs --report=json $files
echo "DONE"


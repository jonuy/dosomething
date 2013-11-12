#!/bin/bash

NEW_COMMIT="$1"
OLD_COMMIT="$2"

for i in $(git diff $NEW_COMMIT $OLD_COMMIT --name-only)
do
  git checkout $NEW_COMMIT $i
done


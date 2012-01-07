#!/bin/bash

cp -R -v ../* /var/www/yousuckapp

release=`git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`

echo "==============================="
echo "You pushed $release to live !! "
echo "==============================="

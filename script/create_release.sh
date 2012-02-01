#!/bin/bash

if [ $# -ne 1 ]
then
    echo "Error in $0 - Invalid Argument Count"
    echo "Syntax: $0 release_version_number "
    exit
fi

# create remote branch from local branch
git checkout dev
git pull
branch_name=$1
git push origin dev:${branch_name}

echo 'Done'


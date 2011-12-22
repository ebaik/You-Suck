#!/bin/bash

if [ $# -ne 1 ]
then
    echo "Error in $0 - Invalid Argument Count"
    echo "Syntax: $0 release_version_number "
    exit
fi

#checkout to correct release branch 
branch_name=$1
git checkout ${branch_name}
git pull

echo "You are under ${branch_name}"
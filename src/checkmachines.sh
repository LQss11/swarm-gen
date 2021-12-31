#!/bin/bash

HOSTNAMES=$(docker node ls | awk '{ print $2 }')
for hn in $HOSTNAMES; do
echo $hn
done

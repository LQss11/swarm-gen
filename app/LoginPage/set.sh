#!/bin/bash

if [[ -n $1 && -n $2 ]]; then
    export USER="$1"
    export PASS="$2"
fi

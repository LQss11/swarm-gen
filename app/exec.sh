#!/bin/bash
echo $USER
if [ -z $USER ] && [ -z $PASS ]; then
    sshpass -p $PASS ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $USER@localhost whoami
fi

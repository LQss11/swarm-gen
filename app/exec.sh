#!/bin/bash
sshpass -p $2 ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $1@localhost $3

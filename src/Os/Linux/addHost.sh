#!/bin/sh


ETC_HOSTS=/etc/hosts



# DEFAULT IP FOR HOSTNAME

IP=$2



# Hostname to add/remove.

HOSTNAME=$1

HOSTS_LINE="$IP\t$HOSTNAME"

fun(){

# PATH TO YOUR HOSTS FILE


 echo "Adding $HOSTNAME to your $ETC_HOSTS";

 sudo -- sh -c -e "echo '$HOSTS_LINE' >> /etc/hosts";



}

fun
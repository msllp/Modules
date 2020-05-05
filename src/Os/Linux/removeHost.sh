#!/bin/sh


ETC_HOSTS=/etc/hosts



# DEFAULT IP FOR HOSTNAME

IP="127.0.0.1"



# Hostname to add/remove.

HOSTNAME=$1

HOSTS_LINE="$IP\t$HOSTNAME"

fun(){

# PATH TO YOUR HOSTS FILE


 echo "Removing $HOSTNAME to your $ETC_HOSTS";

 sudo sed -i".bak" "/$HOSTNAME/d" $ETC_HOSTS ;



}

fun
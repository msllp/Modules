#!/bin/sh

fun(){

# PATH TO YOUR HOSTS FILE

 

 echo "Update Apache Config";

 

 sudo -- sh -c -e "/etc/init.d/apache2 reload" ;



}

fun
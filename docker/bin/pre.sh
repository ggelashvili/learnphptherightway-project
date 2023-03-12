#!/bin/bash

### User Input
container_name=oops-project-app
local_project_root="/home/gautam/My_Stuff/Programming/PHP/Basics/php-oops-project"
container_project_root="/var/www/php-oops-project"
default_executable="php"

### Building target path inside container
relative_path_from_project_root=`realpath --relative-to="${local_project_root}" "${PWD}"`
if [[ $relative_path_from_project_root = ..* ]] || [[ ! $relative_path_from_project_root =~ ^\.|src* ]];
then
    echo "Run all your commands either from project root or src and its subdirectories"
    exit;
fi

### Prepare command: using default executable as PHP
command_to_run_inside_container="${executable_path:-${default_executable}} "$@""
complete_command=(docker exec -w ${container_project_root}/${relative_path_from_project_root} ${container_name} ${command_to_run_inside_container})
#echo ${complete_command[@]}

### Execute the command
#output=`${complete_command[@]}`
${complete_command[@]}

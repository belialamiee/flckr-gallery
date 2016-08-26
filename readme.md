# Flckr-Gallery

This flicker search engine is built on top of Laravel using NginX to serve the data. To use, type a search query into the search box and the site will return a paginated list of search results.

A list of previous searches is shown below, clicking on these will search for these.

clicking on any of the thumbnails will bring up a larger image.


## Installation

It is assumed that you have a laravel installation and MYSQL/NginX installed and that you are able to set up a simple .

A simple nginx config for this application is as follows:

server {
        listen 80;
        server_name flckr;
        index index.php index.html index.htm;
        client_max_body_size 800M;

        location / {
                root /var/www/flckr/public;
                try_files $uri $uri/ /index.php?$args;
        }

        location ~ \.php$ {
                root /var/www/flckr/public;
                try_files $uri $uri/ /index.php?$args;
                index index.php
                fastcgi_index index.php;
                fastcgi_param PATH_INFO $fastcgi_path_info;
                fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                include fastcgi_params;
        }
}

In order to run this you will need to go to \config\database.php and update line 60 and 61 with your database username and password


You will then need to create a mysql database with the name of flckr or alternatively update the database name on line 59 with your database name.

Then you will need to go to the root directory of the application and run php artisan migrate in order to have the database tables installed.


## Decisions

I went with Laravel as it is a great framework for when you need to set up a site really quickly.

The modelling has been kept on a fairly simple basis with Models for Search criteria and the user themselves.


## Desirables

I unfortunately ran out of time and was unable to implement the following:

Unit testing.

Angular.js Front end

Upserting search terms rather then creating new terms each time, this will also enable us to remove the grouping of search results.

At present the next and previous functionality for the pagination is not working properly, this is getting fixed as a priority, hopefully I have time.



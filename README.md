README FILE
===========

1) Introduction
---------------
This file will help you to install and configure the project.

2) Installation
---------------

### a) Parameters Symfony sandbox for use Gorg authentication

First to install the bundle add the following line to your app/config/config.yml file:

    gorg_authentificator:
        cas_server: "auth.gadz.org"
        cas_port: 443
        cas_path: "/cas/"
        ca_cert: "/home/kapable/ssl/gadz.org.crt"


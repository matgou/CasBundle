README FILE
===========

1) Introduction
---------------
This file will help you to install and configure the project.

2) Installation
---------------

### a) Parameters Symfony sandbox for use Gorg authentication

Please edit app/config/security.yml file to update symfony security policy

	security:
	    factories:
	        - "%kernel.root_dir%/../src/Gorg/Bundle/AuthentificatorBundle/Resources/config/security_factories.xml"
	
	# ...
	    firewalls:
	        dev:
	            pattern:  ^/(_(profiler|wdt)|css|images|js)/
	            security: false
	
	        secured_area:
	            pattern:    ^/demo/secured/
	            gorg:       true

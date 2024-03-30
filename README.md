# OOB-Setup

This tool creates a basic web server with PHP. When accessed, it sends you a message through Telegram or Discord, depending on your configuration. It proves useful for testing Blind XSS or SSRF vulnerabilities.

## Features

- Send notifications through Discord using the `discord` module.
- Send notifications through Telegram using the `telegram` module.
- Extendable base module for additional notification services.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- Docker is installed on your machine.
- Composer is installed on your machine (handled by Docker).

## Installation

To run the project, first make the settings you need in `/config/conf.php` file. then execute the following command. If needed, you can modify the project's port in the `docker-compose.yml` file.
```bash
docker comopse up
```
Afterward, navigate to the Cloudflare dashboard, select your domain, enter the `origin rules` section, and click on `create rule`. Input the rule name, set the `field` to `hostname`, and enter your domain or subdomain. Click on `rewrite to`, and specify the project's port. Now, go to the `ssl/tls` section and click on `Flexible`.


## Usage
After running the Docker container, the project will be up and running on the specified port. You can interact with the project via HTTP requests to the server.
## Modules
### Base Module
The base module is an abstract class that provides core functionalities such as retrieving server information and sending notifications.

### Discord Module
The discord module extends the base module to send notifications to a Discord webhook.

### Telegram Module
The telegram module extends the base module to send notifications to a Telegram chat.


## TODO
 - [x] write how to use
 - [x] add discord module
 - [ ] add markdown escape :D
 - [ ] change apache setting to handle all urls and send the request to the discord
 - [x] write a better readme.md :)

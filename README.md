# Public Website WordPress Tech Meetup Berlin
Public website for the WordPress Tech Meetup Berlin.

https://tech.wpmeetup-berlin.de/

## Local Installation
Run the setup script `./setup`. This will ask you some questions to create the necessary config files and install the dependencies.

If you want to start the local dev server you have three options:

* `grunt` will start all servers and create and cleanup assets
* `grunt fast` will start the local php server and in addition proxy the requests through [browserSync](https://browsersync.io/)
* `grunt php` will only start the local php server

## Note
Do not commit the database file if you're starting a pull request. The database is only part of the repo, to get you the content of the production website in your dev environment.


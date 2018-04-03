Public website for the WordPress Tech Meetup Berlin.

# Local Installation
Create file `config/env.json` and add 
```json
{
  "env": "local"
}
```

Copy `config/env/default.json` to `config/env/local.json` and edit variables.

Run `composer install`

## Suggestion
Use php's built in development server: 
* `php -S localhost:8000` __(Note: Adress in local.json and php server must match)__.

Use sqlite:
*  copy db drop-in `cp web/plugins/sqlite-integration/db.php web/assets/db.php`

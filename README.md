## Steps to run this application

#### Please note this requires docker
##### (I used Orbstack for my development)

---

1. Unzip archive
2. In Root directory
   1. ./vendor/bin/sail up -d (if you do not run, you will need to open a new terminal to run the rest of the commands)
   2. ./vendor/bin/sail composer install
   3. ./vendor/bin/sail npm i
   4. ./vendor/bin/sail npm run build
   5. ./vendor/bin/sail artisan migrate 
   6. ./vendor/bin/sail artisan db:seed
3.  Go to http://localhost (make sure port 80 is not already in use)
4.  The application is now ready

---

in the .env file I have shipped there is a forwarded port for the DB
`FORWARD_DB_PORT=3309`

This was to avoid conflict on my local dev environment

---
Sail will install PHP:
```bash 
$ ./vendor/bin/sail php -v
PHP 8.5.11 (cli) (built: Sep 24 2026 14:36:15) (NTS)
Copyright (c) The PHP Group
Built by Ubuntu
Zend Engine v4.5.11, Copyright (c) Zend Technologies
    with Xdebug v3.5.3, Copyright (c) 2002-2026, by Derick Rethans
    with Zend OPcache v8.5.11, Copyright (c), by Zend Technologies```
```
---
Sail will install node:
```bash
$ ./vendor/bin/sail node -v  -> v24.22.1
```

---

## Deploying to Dockploy

The steps above (Sail) are for local development only. For production, the app ships with a
standalone `Dockerfile` (nginx + php-fpm under supervisord, no Sail dependency) and a
`docker-compose.yml` meant to be deployed as a **Docker Compose** app in Dockploy.

1. Push this repository to a Git remote Dockploy can reach.
2. In Dockploy, create a new **Compose** application pointing at this repo/branch, with
   `docker-compose.yml` as the compose file.
3. Set these environment variables in the Dockploy dashboard (do **not** commit a `.env` with
   real secrets — the image deliberately excludes it):

   | Variable | Notes |
   |---|---|
   | `APP_KEY` | Generate locally with `php artisan key:generate --show` and paste the value |
   | `APP_URL` | Public URL Dockploy will serve the app on, e.g. `https://tasks.example.com` |
   | `APP_DEBUG` | `false` in production |
   | `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | Credentials for the app's MySQL user |
   | `DB_ROOT_PASSWORD` | Root password for the bundled MySQL container |
   | `RUN_MIGRATIONS` | `true` to run `php artisan migrate --force` on container start (default `true`) |

4. In Dockploy's **Domains** tab, point your domain at the `app` service on container port `80`.
   Dockploy manages the reverse proxy and SSL certificate for you — no Traefik labels needed in
   the compose file.
5. Deploy. The `app` container builds the frontend assets and PHP dependencies in multi-stage
   Docker builds, waits for MySQL to be reachable, caches config/routes/views, optionally runs
   migrations, and starts nginx + php-fpm.
6. If you'd rather use a database Dockploy manages separately instead of the bundled `mysql`
   service, remove the `mysql` service from `docker-compose.yml` and point `DB_HOST`/`DB_PORT` at
   that database instead.

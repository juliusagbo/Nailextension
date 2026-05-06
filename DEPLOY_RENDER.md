# Deploy on Render (Laravel)

This project includes `render.yaml` so Render can deploy it as a live site.

## 1) Create service from GitHub repo

1. Open [https://render.com](https://render.com) and sign in.
2. Click **New** -> **Blueprint**.
3. Connect GitHub and select this repository.
4. Render will detect `render.yaml` and create `nailextension-web`.

## 2) Set required environment variables

In Render service settings, set:

- `APP_URL` = your Render URL (example: `https://nailextension-web.onrender.com`)
- `APP_KEY` = Laravel key from:

```bash
php artisan key:generate --show
```

## 3) Deploy

Click **Deploy latest commit**.

Render will:
- install Composer and Node dependencies
- build Vite assets
- create SQLite database at `/var/data/database.sqlite`
- run migrations

## 4) Verify live site

Open the Render URL and test:
- Home page loads
- Register/Login works
- Appointment flow saves records

If you change code, push to `main` and Render auto-deploys.

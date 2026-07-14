# 🚀 Local Testing Guide - No Production Changes

## What Was Created

- `docker-compose.local.yml` - Separate local testing setup
- **Your production files remain UNTOUCHED**
- Uses HTTP only (no SSL complications)
- Isolated containers with `_local` suffix

---

## How to Test Locally

### 1️⃣ Start the containers

```bash
docker-compose -f docker-compose.local.yml up -d --build
```

### 2️⃣ Access the app

- **Browser**: http://localhost
- **Database**: postgres on localhost:5432

### 3️⃣ View logs

```bash
docker-compose -f docker-compose.local.yml logs -f
```

### 4️⃣ Run migrations (if needed)

```bash
docker-compose -f docker-compose.local.yml exec app php artisan migrate
```

### 5️⃣ Run seeders (if needed)

```bash
docker-compose -f docker-compose.local.yml exec app php artisan db:seed
```

### 6️⃣ Stop containers

```bash
docker-compose -f docker-compose.local.yml down
```

---

## Key Differences: Local vs Production

| Feature          | Local                    | Production              |
| ---------------- | ------------------------ | ----------------------- |
| **File**         | docker-compose.local.yml | docker-compose.prod.yml |
| **Protocol**     | HTTP only                | HTTPS (SSL)             |
| **nginx config** | default.conf             | default.prod.conf       |
| **Port**         | 80                       | 80 + 443                |
| **SSL certs**    | ❌ None needed           | ✅ Let's Encrypt        |
| **Database**     | `_local` volume          | Original volume         |

---

## Troubleshooting

### Nginx not starting?

```bash
docker-compose -f docker-compose.local.yml logs nginx
```

### PHP errors?

```bash
docker-compose -f docker-compose.local.yml logs app
```

### Database connection failed?

- Make sure PostgreSQL container is running
- Check DB credentials match in `.env`

### Permission denied errors?

```bash
docker-compose -f docker-compose.local.yml down -v
docker-compose -f docker-compose.local.yml up -d --build
```

---

## Testing Filament

1. Ensure migrations are run
2. Create admin user (check seeders or artisan commands)
3. Access: http://localhost (Filament admin should be at `/admin` or similar)
4. Check logs: `docker-compose -f docker-compose.local.yml logs app`

---

## ✅ SAFE FOR GIT

- `docker-compose.local.yml` is only used locally
- Production files are unchanged
- No risk of pushing unwanted changes to server!

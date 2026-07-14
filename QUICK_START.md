# ✅ Quick Start Checklist

## Prerequisites

- [ ] Docker Desktop running
- [ ] Your project files (you already have them)

## Step 1: Clean Start (First Time Only)

```bash
# Stop any running containers
docker-compose -f docker-compose.local.yml down

# Remove old data (optional, but recommended for fresh start)
docker volume rm jfeid_project_dbdata_local jfeid_project_storage jfeid_project_bootstrap_cache 2>/dev/null || true

# Build and start
docker-compose -f docker-compose.local.yml up -d --build
```

## Step 2: Setup Laravel

```bash
# Install PHP dependencies
docker-compose -f docker-compose.local.yml exec app composer install

# Generate application key (if needed)
docker-compose -f docker-compose.local.yml exec app php artisan key:generate

# Run migrations
docker-compose -f docker-compose.local.yml exec app php artisan migrate

# Seed database (if you have seeders)
docker-compose -f docker-compose.local.yml exec app php artisan db:seed
```

## Step 3: Test Access

- Open browser: **http://localhost**
- You should see your Laravel app
- If using Filament admin: **http://localhost/admin**

## Step 4: Monitor for Issues

```bash
# Watch logs in real-time
docker-compose -f docker-compose.local.yml logs -f

# Check specific service
docker-compose -f docker-compose.local.yml logs app
docker-compose -f docker-compose.local.yml logs nginx
docker-compose -f docker-compose.local.yml logs db
```

---

## Common Issues & Fixes

### ❌ "Port 80 already in use"

```bash
# Change nginx port in docker-compose.local.yml
# Change:
#   ports:
#     - "80:80"
# To:
#   ports:
#     - "8080:80"
# Then access: http://localhost:8080
```

### ❌ "Nginx keeps restarting"

```bash
docker-compose -f docker-compose.local.yml logs nginx
# Should show: [emerg] (socket: Address already in use) → Port conflict
# OR: [error] /etc/nginx/conf.d/default.conf → Config issue
```

### ❌ "Database connection refused"

```bash
# Check if DB container is running
docker-compose -f docker-compose.local.yml ps

# Check logs
docker-compose -f docker-compose.local.yml logs db

# Ensure DB is ready (wait 2-3 seconds after starting)
```

### ❌ "Filament admin not accessible"

1. Check migrations ran: `docker-compose -f docker-compose.local.yml exec app php artisan migrate:status`
2. Check user exists: `docker-compose -f docker-compose.local.yml exec app php artisan tinker` → `User::all()`
3. Check routes: `docker-compose -f docker-compose.local.yml exec app php artisan route:list | grep filament`

### ❌ "Files have wrong permissions"

```bash
docker-compose -f docker-compose.local.yml down
docker volume rm jfeid_project_storage
docker-compose -f docker-compose.local.yml up -d --build
```

---

## 🎯 Next Steps

1. Run Step 1 & 2 from above
2. Test at http://localhost
3. Check logs if anything fails
4. Make your changes and test
5. When done: `docker-compose -f docker-compose.local.yml down`

---

## Important: Pushing to Production

**ONLY push changes to these files, NOT:**

- ❌ docker-compose.yml
- ❌ docker-compose.prod.yml
- ❌ Dockerfile
- ❌ nginx/conf.d/default.prod.conf

**SAFE TO PUSH:**

- ✅ app/ code changes
- ✅ database/ migrations
- ✅ config/ changes
- ✅ routes/ changes
- ✅ resources/ views

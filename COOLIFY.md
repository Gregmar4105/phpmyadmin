# Coolify Deployment Guide (PHP 8.3 phpMyAdmin)

This project is fully configured for deployment on **Coolify** using **PHP 8.3** and Docker.

---

## 🚀 Quick Deployment Steps on Coolify

### Step 1: Create a New Application in Coolify
1. Open your Coolify Dashboard.
2. Navigate to **Projects** &rarr; Select your project and environment.
3. Click **+ New** &rarr; **Application** &rarr; **Public Repository** or **Private Repository (GitHub / GitLab)**.
4. Enter your repository URL (e.g., `https://github.com/Gregmar4105/phpmyadmin`) and branch (`main`).

### Step 2: Build Configuration
- **Build Pack**: Coolify will automatically detect the **`Dockerfile`**.
- **Port**: Set the exposed port to `80` (Coolify maps traffic from Traefik to port `80`).
- **Healthcheck Path**: `/` (or leave default).

### Step 3: Configure Environment Variables in Coolify
In the application's **Environment Variables** tab in Coolify, add your production variables:

| Variable | Description | Recommended / Example |
| :--- | :--- | :--- |
| `PMA_BLOWFISH_SECRET` | 32+ character cookie encryption key | *(Generate via `openssl rand -base64 32`)* |
| `PMA_IS_HTTPS` | Behind Coolify's SSL/Traefik reverse proxy | `true` |
| `PMA_COOKIE_SECURE` | Set secure flag on cookies | `true` |
| `PMA_COOKIE_SAMESITE` | Cookie SameSite policy | `Lax` |
| `PMA_THEME` | Default theme | `boodark-orange` |
| `PMA_TITLE` | Brand title displayed in tabs and header | `Larable` |
| `PMA_ARBITRARY` | Allow typing server IP at login screen | `false` |

#### Database Connection Options:

##### Option A: Single Database / Coolify Managed Database
If your MySQL database is hosted on the same Coolify server (or remote):
```env
SERVER1_ENABLE=true
SERVER1_VERBOSE="Production Database"
SERVER1_HOST=mysql.coolify.internal  # or your Aiven/RDS host
SERVER1_PORT=3306
SERVER1_AUTH_TYPE=cookie
SERVER1_USER=avnadmin
SERVER1_PASSWORD=your_password
SERVER1_SSL=true
SERVER1_SSL_VERIFY=false
SERVER2_ENABLE=false
```

##### Option B: Multiple Databases (e.g. Local + Remote Cloud DB)
```env
# Server 1: Local / Internal
SERVER1_ENABLE=true
SERVER1_VERBOSE="Coolify Internal MySQL"
SERVER1_HOST=mysql-service
SERVER1_PORT=3306
SERVER1_AUTH_TYPE=cookie

# Server 2: Remote Cloud (Aiven / AWS RDS)
SERVER2_ENABLE=true
SERVER2_VERBOSE="Larable Remote MySQL (Aiven)"
SERVER2_HOST=larable-mysql-service-larablenetwork-2db5.f.aivencloud.com
SERVER2_PORT=20707
SERVER2_AUTH_TYPE=cookie
SERVER2_USER=avnadmin
SERVER2_PASSWORD=your_aiven_password
SERVER2_SSL=true
SERVER2_SSL_VERIFY=false
```

### Step 4: Domains & SSL
1. In Coolify's **General** settings, set your FQDN (e.g., `https://pma.yourdomain.com`).
2. Coolify automatically generates Let's Encrypt SSL certificates.
3. Click **Deploy**.

---

## 🛠 Local Development
To run locally with Laravel Herd, Laragon, or PHP CLI:
1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Adjust your database credentials in `.env`.
3. Changes in `.env` take effect immediately without needing server restarts.

To test locally with Docker:
```bash
docker compose up -d --build
```
Access at `http://localhost:8080`.

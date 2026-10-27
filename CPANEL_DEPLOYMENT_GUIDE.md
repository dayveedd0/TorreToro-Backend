# Torre Tórò Backend - cPanel Deployment & Subdomain Hosting Guide

This guide walks you step-by-step through deploying the **Torre Tórò** Laravel backend onto **cPanel shared or VPS hosting** under a dedicated subdomain (such as `api.torretoro.com`, `backend.torretoro.com`, or `admin.torretoro.com`).

---

## 1. Pre-Deployment Summary & Included Artifacts

The backend has been configured and optimized for transfer:
1. **Intelligent Subdomain Routing**: The backend automatically recognizes subdomain prefixes (`api.*`, `backend.*`, `admin.*`, `staging.*`) and routes them to the correct regional domain (`global` or `uk`).
2. **Ready Database Dump**: [`toretorro_database_dump.sql`](toretorro_database_dump.sql) contains all database tables, seeded live copy, projects, project galleries, and admin credentials.
3. **Production Environment File**: [`.env.production.example`](.env.production.example) contains production settings configured for cPanel.
4. **1-Click Storage Link & Cache Tool**: [`public/cpanel-storage-link.php`](Backend/public/cpanel-storage-link.php) enables creating storage links and clearing caches directly from your browser if your hosting provider does not provide SSH/Terminal access.

---

## 2. Server Requirements Check

Verify in your cPanel dashboard:
* **PHP Version**: **8.2** or **8.3** (Go to cPanel $\rightarrow$ **Select PHP Version** or **MultiPHP Manager**).
* **Required PHP Extensions**:
  * `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `bcmath`, `curl`, `zip`.
* **Database**: MySQL 5.7+ or MariaDB 10.3+.

---

## 3. Step-by-Step Deployment Instructions

### Step 1: Create the Subdomain in cPanel
1. Log into your cPanel account.
2. In the **Domains** section, click **Domains** (or **Subdomains**).
3. Click **Create A New Domain**.
4. Enter your desired subdomain:
   * Example: `api.torretoro.com` (or `backend.torretoro.com`).
5. **CRITICAL (Document Root Setup)**:
   * Uncheck *"Share document root"*.
   * Set the Document Root to end with `/public`:
     * Recommended: `toretorro-backend/public` (or `api.torretoro.com/public`).
     > **Why this matters**: Pointing the Document Root directly to `/public` ensures your `.env` file, database credentials, and core application code remain outside the web-accessible directory, preventing security leaks.

---

### Step 2: Create MySQL Database & Import Data
1. In cPanel, navigate to **MySQL® Databases**.
2. **Create New Database**:
   * Name: `cpaneluser_toretorro` (cPanel prefixes this with your account username).
3. **Create New User**:
   * Username: `cpaneluser_dbuser`
   * Password: Use the **Password Generator** to create a strong password. Save it for Step 4.
4. **Add User To Database**:
   * Select your user and database $\rightarrow$ Click **Add**.
   * Check **ALL PRIVILEGES** $\rightarrow$ Click **Make Changes**.
5. **Import Database Dump**:
   * Go back to cPanel home $\rightarrow$ Open **phpMyAdmin**.
   * Select your newly created database (`cpaneluser_toretorro`) in the left sidebar.
   * Click the **Import** tab at the top.
   * Click **Choose File** $\rightarrow$ select `toretorro_database_dump.sql`.
   * Click **Import** (or **Go**) at the bottom.
   * All 13 tables (users, domains, pages, projects, galleries, settings, etc.) will be imported.

---

### Step 3: Package & Upload Application Files
1. On your local machine, zip the contents of the `Backend` directory:
   * **Exclude** the `node_modules` and `.git` folders if present.
   * **Include** `vendor`, `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, and `artisan`.
2. In cPanel, open **File Manager**.
3. Navigate to your application root directory:
   * If your Document Root in Step 1 was set to `toretorro-backend/public`, navigate to `toretorro-backend/` (one level above `public`).
4. Click **Upload** $\rightarrow$ upload your zip file $\rightarrow$ select the uploaded file and click **Extract**.
5. Ensure your folder structure looks like this:
   ```text
   /home/cpaneluser/toretorro-backend/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/              <-- This is where the subdomain Document Root points!
   │   ├── index.php
   │   ├── .htaccess
   │   └── cpanel-storage-link.php
   ├── resources/
   ├── routes/
   ├── storage/
   │   ├── app/public/      <-- All 243+ uploaded images and media assets live here
   ├── vendor/
   ├── .env
   └── artisan
   ```

---

### Step 4: Configure Production `.env`
1. In cPanel File Manager inside your app directory (`toretorro-backend/`), ensure **Show Hidden Files (dotfiles)** is enabled in File Manager Settings (top right gear icon).
2. Look for `.env`. If not visible, rename `.env.production.example` to `.env` (or create a new `.env` file).
3. Edit `.env` with your production values:
   ```env
   APP_NAME="Torre Tórò"
   APP_ENV=production
   APP_KEY=base64:CkQVc+SBdahPtFoe4ShwTmNck+RQ3bB6dW5LxEm263Y=
   APP_DEBUG=false
   APP_URL=https://api.torretoro.com

   LOG_CHANNEL=stack
   LOG_LEVEL=error

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cpaneluser_toretorro
   DB_USERNAME=cpaneluser_dbuser
   DB_PASSWORD=your_database_password_from_step_2

   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   SESSION_SECURE_COOKIE=true

   FILESYSTEM_DISK=public
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   ```
4. Click **Save Changes**.

---

### Step 5: Link Public Storage (Images & Media)
Your media assets reside in `storage/app/public/` and must be accessible through the web via `public/storage`.

Choose **Option A** or **Option B**:

#### Option A: Using cPanel Terminal / SSH (Fastest)
1. Open **Terminal** in cPanel.
2. Run:
   ```bash
   cd ~/toretorro-backend
   php artisan storage:link
   php artisan optimize
   ```

#### Option B: Using the Included 1-Click Browser Helper (No SSH Needed)
If your cPanel host does not provide Terminal access:
1. Open your browser and navigate to:
   ```text
   https://api.torretoro.com/cpanel-storage-link.php?key=toretorro_setup_2026
   ```
   *(Replace `api.torretoro.com` with your actual subdomain)*
2. The page will automatically:
   * Create the `public/storage` symlink.
   * Clear all cached files and compile routes/config.
3. **SECURITY NOTICE**: Once you see the success message, open cPanel File Manager and **delete** `public/cpanel-storage-link.php`.

---

### Step 6: Verify Deployment

1. **Verify API Endpoint**:
   Visit `https://api.torretoro.com/api/v1/config` in your browser.
   You should receive a valid JSON response containing site settings, menus, and phone numbers (`+234 813 600 1221` and `+234 011 336 54`).
2. **Verify Projects & Gallery**:
   Visit `https://api.torretoro.com/api/v1/projects/sanlam-insurance`.
   Verify the image URLs resolve correctly.
3. **Verify Admin Dashboard**:
   Visit `https://api.torretoro.com/admin/login`.
   * **Default Super Admin**: `admin@torretoro.com`
   * **Password**: `password` (change immediately in `/admin/users` after first login).

---

## 4. Subdomain & Domain Resolution in Production

The backend is configured to support all domain contexts:

| Frontend Client | Backend Subdomain Request | Resolved Region |
|---|---|---|
| Main Website (`torretoro.com`) | `https://api.torretoro.com/api/v1/...` | `global` |
| UK Website (`torretoro.co.uk`) | `https://api.torretoro.com/api/v1/...` with header `X-Domain: uk` | `uk` |
| Direct Subdomain Link | `https://api.torretoro.com/api/v1/config?domain=uk` | `uk` |
| Admin Panel | `https://api.torretoro.com/admin` | Uses Admin Switcher |

---

## 5. Troubleshooting & FAQ

* **Issue: 500 Internal Server Error**
  * Check storage permissions: In cPanel File Manager, ensure `storage/` and `bootstrap/cache/` directories have permissions set to `755` (or `775`).
  * Ensure `APP_KEY` is present in your `.env`.
* **Issue: Media images return 404**
  * Run the storage link tool from Step 5.
  * Verify `public/storage` links to `storage/app/public`.
* **Issue: Changes to `.env` not reflecting**
  * Run `php artisan config:clear` or use the Admin panel button at `/admin/settings` or trigger `/admin/system/clear-cache`.
* **Issue: CORS error from frontend application**
  * `config/cors.php` is pre-configured with `'allowed_origins' => ['*']` and `'exposed_headers' => ['X-Active-Domain']`. If your frontend runs on a separate domain (e.g. Vercel, Netlify, or AWS), all cross-origin requests are automatically accepted.

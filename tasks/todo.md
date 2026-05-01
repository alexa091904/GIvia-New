# Deployment Plan: Render Setup for Laravel

## 1. Prepare Build Script
- [ ] Create `render-build.sh` in the root directory.
- [ ] Add commands for installing Composer dependencies, compiling frontend assets (npm install & build), clearing caches, and running database migrations.
- [ ] Make the script executable.

## 2. Prepare Database and Storage Configuration
- [ ] Identify necessary `config/database.php` and `config/filesystems.php` modifications if required (usually Render Postgres uses standard connection strings).
- [ ] Add the command to create the symbolic link for storage (`php artisan storage:link`) in the build script.

## 3. Deployment Instructions & Environment Variables
- [ ] Document the step-by-step process for creating the PostgreSQL database on Render.
- [ ] Document the step-by-step process for creating the Web Service on Render.
- [ ] Provide the exact list of Environment Variables (`.env`) that need to be configured on the Render dashboard.
- [ ] Document how to set up persistent storage on Render for image uploads.

## Review
- [ ] User review of the plan before proceeding with file creation.

# ✅ Production Deployment Checklist
**Project**: Pawikan Patrol  
**Quick Reference Guide**

---

## 🔴 CRITICAL (Do These First!)

### 1. Update .env File
```env
# Change these immediately:
APP_ENV=production          ← Change from 'local'
APP_DEBUG=false             ← Change from 'true'
APP_URL=https://yourdomain.com

# Database (use strong password!):
DB_PASSWORD=your_strong_password_here
DB_USERNAME=pawikan_user    ← Don't use 'root'

# Session Security:
SESSION_ENCRYPT=true
SESSION_DOMAIN=yourdomain.com
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

### 3. Create Database User
```sql
CREATE USER 'pawikan_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON pawikan_patrol.* TO 'pawikan_user'@'localhost';
FLUSH PRIVILEGES;
```

---

## 🟡 IMPORTANT (Do Before Going Live)

### 4. Configure HTTPS
- Get SSL certificate (Let's Encrypt is free)
- Update APP_URL to https://
- Configure web server for SSL

### 5. Set File Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Run Migrations
```bash
php artisan migrate --force
```

### 7. Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

---

## 🟢 RECOMMENDED (Best Practices)

### 8. Set Up Backups
- Configure daily database backups
- Set up file backups
- Test restore process

### 9. Configure Monitoring
- Set up error tracking (Sentry, Bugsnag)
- Configure uptime monitoring
- Enable performance monitoring

### 10. Test Everything
- [ ] Login/Logout works
- [ ] Admin dashboard accessible
- [ ] Patrol reports can be created
- [ ] Games function properly
- [ ] Email notifications work (if configured)

---

## ⚠️ SECURITY WARNINGS

**NEVER DO THESE IN PRODUCTION:**
- ❌ Leave APP_DEBUG=true
- ❌ Use empty database password
- ❌ Use 'root' as database user
- ❌ Run without HTTPS
- ❌ Commit .env file to git

---

## 📊 Quick Status Check

After deployment, verify:
```bash
# Check environment
php artisan env

# Check config is cached
php artisan config:show app.env
# Should show: production

php artisan config:show app.debug
# Should show: false

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
# Should connect successfully
```

---

## 🚀 Ready to Deploy?

**Checklist**:
- [ ] APP_ENV=production
- [ ] APP_DEBUG=false
- [ ] APP_KEY generated
- [ ] Strong database password set
- [ ] HTTPS configured
- [ ] File permissions set
- [ ] Migrations run
- [ ] Application optimized
- [ ] Backups configured
- [ ] Everything tested

**If all checked**: ✅ **DEPLOY!**

---

**Estimated Time**: 2-3 hours  
**Difficulty**: Medium  
**Risk**: Low (if checklist followed)

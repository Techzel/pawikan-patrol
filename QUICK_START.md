# 🐢 Pawikan Patrol - Quick Start Guide

**Get up and running in 5 minutes!**

---

## 📋 What You Need

```
✅ PHP 8.2+
✅ MySQL 8.0+
✅ Composer
✅ Node.js 18+
✅ Git
```

---

## 🚀 Installation (5 Steps)

### 1️⃣ Clone & Navigate
```bash
git clone https://github.com/yourusername/pawikan-patrol.git
cd pawikan-patrol/my_app
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

**Edit `.env` file**:
```env
DB_DATABASE=pawikan_patrol
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4️⃣ Setup Database
```bash
# Create database
mysql -u root -p
CREATE DATABASE pawikan_patrol;
EXIT;

# Run migrations
php artisan migrate
```

### 5️⃣ Start Server
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

**Access**: http://localhost:8000

---

## 🎯 Default Credentials

Create your first admin user:
```bash
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->name = 'Admin';
>>> $user->username = 'admin';
>>> $user->email = 'admin@pawikan.com';
>>> $user->password = Hash::make('password');
>>> $user->role = 'admin';
>>> $user->is_active = true;
>>> $user->verification_status = 'verified';
>>> $user->save();
```

**Login**:
- Username: `admin`
- Password: `password`

---

## 📚 Full Documentation

See **[README.md](README.md)** for complete documentation.

---

## 🔧 Common Issues

### Database Connection Error
```bash
# Check MySQL is running
sudo systemctl status mysql

# Check credentials in .env
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Permission Errors
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows (Run as Admin)
icacls storage /grant Users:F /T
```

### Port Already in Use
```bash
# Use different port
php artisan serve --port=8001
```

---

## 🚀 Next Steps

1. ✅ Login with admin credentials
2. ✅ Explore the dashboard
3. ✅ Create a patrol report
4. ✅ Try the educational games
5. ✅ Read full documentation

---

## 📖 Documentation Index

- **[README.md](README.md)** - Complete documentation
- **[DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md)** - Deployment guide
- **[SECURITY_DEPLOYMENT_AUDIT.md](SECURITY_DEPLOYMENT_AUDIT.md)** - Security audit
- **[CODE_QUALITY_ASSESSMENT.md](CODE_QUALITY_ASSESSMENT.md)** - Code quality report

---

**Need help?** Check the full README.md or create an issue on GitHub.

**Happy coding!** 🐢✨

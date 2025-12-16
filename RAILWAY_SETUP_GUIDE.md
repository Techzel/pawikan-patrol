# How to Deploy MySQL on Railway & Connect to Vercel

Since you want to use Railway (excellent choice!), here is the exact guide to set it up.

## Step 1: Create Database on Railway
1.  Go to [Railway.app](https://railway.app) and sign up/login.
2.  Click **"New Project"** -> **"Provision MySQL"**.
3.  Wait a few seconds for it to deploy.
4.  Click on the **MySQL** card that appears.
5.  Go to the **"Variables"** tab (or "Connect" tab).

## Step 2: Get Your Credentials
You will see a list of variables. You need these values:
- `MYSQL_HOST` (e.g., `containers-us-west-163.railway.app`)
- `MYSQL_PORT` (e.g., `6555`)
- `MYSQL_DATABASE` (e.g., `railway`)
- `MYSQL_USER` (e.g., `root`)
- `MYSQL_PASSWORD` (e.g., `some-long-secret-string`)

## Step 3: Connect to Vercel
1.  Go to your Vercel Project Dashboard.
2.  Click **"Settings"** -> **"Environment Variables"**.
3.  Add the new variables using the values from Railway:

| Key | Value (from Railway) |
|-----|----------------------|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | Copy `MYSQL_HOST` |
| `DB_PORT` | Copy `MYSQL_PORT` |
| `DB_DATABASE` | Copy `MYSQL_DATABASE` |
| `DB_USERNAME` | Copy `MYSQL_USER` |
| `DB_PASSWORD` | Copy `MYSQL_PASSWORD` |

4.  **Important:** Also verify you have `APP_KEY` set (copy from your local .env if missing).

## Step 4: Redeploy & Migrate
1.  Go to **"Deployments"** tab in Vercel.
2.  Click the three dots `...` on the latest deployment -> **Redeploy**.
3.  **Wait for the deployment to finish.**
4.  **Initialize the Database:**
    *   Visit: `https://your-vercel-app-url.vercel.app/migrate-db`
    *   You should see: "Database migration completed successfully!"

**That's it!** Your persistent Railway database is now connected and ready validation.

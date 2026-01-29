# Vercel Deployment Configuration Guide

## Critical: Vercel Dashboard Settings

The "dist" error persists because Vercel's Project Settings in the dashboard are overriding your vercel.json configuration.

### Steps to Fix in Vercel Dashboard:

1. **Go to your Vercel project dashboard**
   - Navigate to: https://vercel.com/[your-username]/[project-name]

2. **Click on "Settings" tab**

3. **Go to "General" → "Build & Development Settings"**

4. **Configure as follows:**
   - **Framework Preset**: Select "Other" (NOT Laravel, Next.js, etc.)
   - **Build Command**: Leave EMPTY
   - **Output Directory**: Leave EMPTY (Keep default, do NOT set to public here)
   - **Install Command**: Leave EMPTY
   - **Development Command**: Leave EMPTY

5. **Click "Save"**

6. **Go to "Deployments" tab**

7. **Click "Redeploy" on the latest deployment**
   - Select "Use existing Build Cache" (optional)
   - Click "Redeploy"

## Alternative: Delete and Reconnect Project

If the above doesn't work:

1. Delete the project from Vercel dashboard
2. Reconnect your GitHub repository
3. During setup, select "Other" as framework
4. Leave all build commands empty
5. Set Output Directory to `public`

## What We've Configured

### vercel.json
- `outputDirectory`: "public" - Tells Vercel where static files are
- `functions`: PHP runtime for api/*.php files
- `routes`: Directs all traffic through Laravel's lambda.php

### package.json
- `build`: Changed to `echo` command (harmless no-op)
- This prevents vite errors when Vercel tries to run npm build

### .gitignore
- Commented out `/public/build` so compiled assets are committed
- Pre-built assets are deployed with your code

## Local Development

When you need to rebuild assets locally:
```bash
npm run build:local
# or
npx vite build
```

## Troubleshooting

If deployment still fails:
1. Check Vercel build logs for the exact error
2. Verify `api/lambda.php` exists in your repository
3. Ensure `public/build/` folder is committed with assets
4. Confirm Framework Preset is set to "Other" in dashboard
5. **If PDFs still 404:** Check the "Requested URL" shown in the PDF viewer's fallback link. It should look like `https://your-site.vercel.app/resources/filename.pdf`. If the path is different, verify your `vercel.json` routing rules.
6. **Commit Assets**: Ensure you have committed the files in `public/resources/` to your repository.

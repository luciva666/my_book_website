# My Stories - Complete Setup Guide

## Overview

This project has been converted from a traditional PHP application to a **Static Frontend** (HTML/CSS/JS) that runs on **Netlify**, while keeping your **PHP Backend** running separately.

This means:
- ✅ Your data is safe
- ✅ Your PHP backend continues to serve API requests
- ✅ Your frontend is fast and scalable on Netlify
- ✅ Friends can easily access it via Netlify URL

## Architecture Diagram

```
┌─────────────────────────────────────────────┐
│          Browser (Friend's Computer)        │
└────────────┬────────────────────────────────┘
             │
             │ HTTP/HTTPS
             │
┌────────────▼────────────────────────────────┐
│  Netlify (Frontend)                         │
│  - HTML/CSS/JavaScript                      │
│  - Runs your static site                    │
│  - Free globally distributed CDN            │
└────────────┬────────────────────────────────┘
             │
             │ API Calls (JSON)
             │
┌────────────▼────────────────────────────────┐
│  Your PHP Backend (Any Server)              │
│  - PHP API Endpoints                        │
│  - MySQL Database                           │
│  - All your data & logic                    │
└─────────────────────────────────────────────┘
```

## What's in Each Folder

### `/application/controllers/`
**Old Files (Still work for browser access):**
- `Auth.php` - Original login/register (PHP rendering)
- `Stories.php` - Story management (PHP rendering)
- `Episodes.php` - Episode management (PHP rendering)

**New Files (For Netlify frontend):**
- `Api.php` - Base API controller (handles CORS, JWT, responses)
- `AuthApi.php` - Authentication endpoints (returns JSON)
- `StoriesApi.php` - Story endpoints (returns JSON)
- `EpisodesApi.php` - Episode endpoints (returns JSON)

### `/netlify/`
**This is your Netlify frontend folder:**
- `index.html` - Home page
- `story-view.html` - View story
- `create-story.html` - Create story
- `edit-story.html` - Edit story
- `profile.html` - User profile
- `auth/login.html` - Login page
- `auth/register.html` - Register page
- `js/app.js` - All JavaScript logic & API calls
- `css/style.css` - All styling
- `netlify.toml` - Netlify configuration
- `_redirects` - Client-side routing

## Step 1: Set Up PHP Backend

Your PHP backend can run on:

### Option A: Keep on XAMPP (Your Current Setup)
```
✅ Keep running http://localhost:80
   But only accessible from your computer
❌ Friends can't access it
```

### Option B: Deploy to PHP Hosting (Recommended)
Popular options:
- **Bluehost** - $2-4/month
- **Hostinger** - $2-3/month  
- **000webhost** - Free
- **Heroku** - Free tier available
- **Your own VPS** - DigitalOcean, Linode, etc.

**Steps to deploy:**
1. Upload your `application/` folder to PHP hosting
2. Upload database to the server
3. Update database credentials in `application/config/database.php`
4. Note your backend URL: `https://your-php-server.com`

## Step 2: Update Frontend API URL

**CRITICAL: This must be done!**

Edit `/netlify/js/app.js` line 2:

```javascript
// OLD (local testing only)
const API_BASE_URL = 'http://localhost/index.php';

// NEW (replace with your actual backend)
const API_BASE_URL = 'https://your-php-server.com/index.php';
```

Examples:
```javascript
// If using Bluehost
const API_BASE_URL = 'https://yourdomainname.com/index.php';

// If using 000webhost (subdomain)
const API_BASE_URL = 'https://yoursite.000webhostapp.com/index.php';

// If using separate API domain
const API_BASE_URL = 'https://api.yourdomainname.com/index.php';
```

## Step 3: Deploy to Netlify

### Method 1: GitHub (Easiest)

```bash
# 1. Initialize git (if not already)
git init

# 2. Create .gitignore
echo "node_modules/" > .gitignore

# 3. Add your changes
git add .
git commit -m "Add Netlify frontend"

# 4. Create GitHub repo
# Go to github.com, create new repo "my_book_website"

# 5. Push to GitHub
git remote add origin https://github.com/YOUR_USERNAME/my_book_website.git
git branch -M main
git push -u origin main
```

Then on Netlify:
1. Go to [app.netlify.com](https://app.netlify.com)
2. Click "New site from Git"
3. Connect GitHub
4. Select your repo
5. Configure:
   - **Base directory:** `netlify`
   - **Build command:** (leave empty)
   - **Publish directory:** `.`
6. Click "Deploy site"

### Method 2: Drag & Drop (Simplest)

1. Go to [app.netlify.com](https://app.netlify.com)
2. Drag and drop the `netlify` folder
3. Done! Your site is live

### Method 3: Netlify CLI

```bash
# Install Netlify CLI
npm install -g netlify-cli

# Login
netlify login

# Deploy
netlify deploy --pub netlify --prod
```

## Step 4: Test Your Site

1. **Get your Netlify URL:** 
   - Check your Netlify dashboard
   - It'll be `https://your-site-name.netlify.app`

2. **Share with friends:**
   - Send them: `https://your-site-name.netlify.app`
   - They can now use your website!

3. **Test features:**
   - Register a new account
   - Create a story
   - Add episodes
   - Edit profile
   - Everything else should work!

## API Routes Created

You can now access your API from anywhere:

```
POST   https://your-php-server.com/api/auth/register
POST   https://your-php-server.com/api/auth/login
POST   https://your-php-server.com/api/auth/logout
GET    https://your-php-server.com/api/auth/profile
POST   https://your-php-server.com/api/auth/profile

GET    https://your-php-server.com/api/stories
POST   https://your-php-server.com/api/stories/create
GET    https://your-php-server.com/api/stories/{id}
POST   https://your-php-server.com/api/stories/{id}/update
POST   https://your-php-server.com/api/stories/{id}/delete

GET    https://your-php-server.com/api/episodes/{id}
POST   https://your-php-server.com/api/episodes/story/{id}/create
POST   https://your-php-server.com/api/episodes/{id}/update
POST   https://your-php-server.com/api/episodes/{id}/delete
```

## Troubleshooting

### "Can't connect to API"
```
✅ Check: API_BASE_URL is correct in js/app.js
✅ Check: PHP backend is running
✅ Check: You're using HTTPS (not HTTP)
✅ Check: CORS is enabled in PHP
```

### "CORS Error"
```
This is already handled!
The API.php file sends CORS headers
If you still get errors, check browser console
```

### "Login doesn't work"
```
✅ Check: Token is being stored in browser
  Open DevTools → Application → LocalStorage
✅ Check: Backend is returning valid JWT token
✅ Check: Token format is: Header.Payload.Signature
```

### "Database errors"
```
✅ Check: Database credentials in application/config/database.php
✅ Check: Database was migrated to new server
✅ Check: Tables exist: users, stories, episodes
```

## Keeping Both Versions

You **don't need to delete the old PHP app!** You can keep both:

```
/application/          (Original PHP version)
  - Still works at http://localhost (just for you)
  - Can use for development/testing

/netlify/              (New Netlify version)
  - Lives on Netlify
  - Your friends use this one
  - Calls same API backend
```

## Database Backup

**IMPORTANT:** Before deploying, backup your database!

```bash
# Export your database
mysqldump -u root -p my_book_website > backup.sql

# Upload backup somewhere safe
```

## Next Steps

1. ✅ Choose PHP hosting (or keep XAMPP)
2. ✅ Deploy PHP backend
3. ✅ Update API_BASE_URL in js/app.js
4. ✅ Deploy to Netlify
5. ✅ Share URL with friends
6. ✅ Celebrate! 🎉

## Useful Links

- **Netlify:** https://app.netlify.com
- **GitHub:** https://github.com
- **PHP Hosting Options:**
  - Bluehost: https://www.bluehost.com
  - Hostinger: https://www.hostinger.com
  - 000webhost: https://www.000webhost.com
- **Custom Domain:** https://docs.netlify.com/domains-https/domains/

## Questions?

Check the `/netlify/README.md` file for more frontend-specific documentation.

---

**You're converting from:**
- Traditional PHP app on XAMPP
- Only accessible from your computer

**To:**
- Static frontend on Netlify (globally accessible)
- PHP backend on any server (secure, scalable)
- Friends can share and use it!

Good luck! 🚀

# 🚀 Quick Reference Card

## Three Things You MUST Do

### 1️⃣ Update API URL
**File:** `/netlify/js/app.js` (Line 2)

```javascript
const API_BASE_URL = 'https://YOUR-PHP-SERVER.com/index.php';
```

### 2️⃣ Deploy PHP Backend
- Get PHP hosting (Bluehost, Hostinger, 000webhost)
- Upload your `application/`, `system/`, `assets/` folders
- Upload your database
- Get backend URL

### 3️⃣ Deploy to Netlify
- Drag `netlify/` folder to [app.netlify.com](https://app.netlify.com)
- Or connect GitHub
- Wait 30 seconds
- Share the URL! 🎉

---

## File Locations

| What | Where |
|------|-------|
| API Controllers (Backend) | `/application/controllers/Api*.php` |
| Frontend (Deploy to Netlify) | `/netlify/` folder |
| Frontend Main Code | `/netlify/js/app.js` |
| Frontend Styles | `/netlify/css/style.css` |
| Setup Guide | `NETLIFY_SETUP.md` |
| API Docs | `API_DOCUMENTATION.md` |
| Testing Guide | `LOCAL_TESTING.md` |

---

## Testing Locally

```bash
cd netlify
# Option A: Python
python -m http.server 8000

# Option B: PHP
php -S localhost:3000

# Option C: Node
npx http-server

# Then visit: http://localhost:8000
```

---

## What API Returns

```javascript
// Success
{ "success": true, "data": {...} }

// Error
{ "error": "Error message" }
```

---

## Test With curl

```bash
# Get all stories
curl http://localhost/api/stories

# Register
curl -X POST http://localhost/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"pass123"}'

# Login
curl -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"pass123"}'
```

---

## URL Examples

| When | URL |
|------|-----|
| Local | `http://localhost:8000` |
| Netlify | `https://your-site.netlify.app` |
| With custom domain | `https://yourdomain.com` |

---

## Frontend Routes

| Page | Path |
|------|------|
| Home | `/` |
| Login | `/auth/login.html` |
| Register | `/auth/register.html` |
| View Story | `/story-view.html?id=1` |
| Create Story | `/create-story.html` |
| Edit Story | `/edit-story.html?id=1` |
| Profile | `/profile.html` |

---

## API Endpoints

### Auth
- `POST /api/auth/register` - Create account
- `POST /api/auth/login` - Sign in
- `GET /api/auth/profile` - Get profile
- `POST /api/auth/profile` - Update profile

### Stories
- `GET /api/stories` - All stories
- `GET /api/stories/1` - View story
- `POST /api/stories/create` - Create
- `POST /api/stories/1/update` - Edit
- `POST /api/stories/1/delete` - Delete

### Episodes
- `GET /api/episodes/1` - View
- `POST /api/episodes/story/1/create` - Create
- `POST /api/episodes/1/update` - Edit
- `POST /api/episodes/1/delete` - Delete

---

## Debug Steps

1. Open DevTools: `F12`
2. Go to Console tab
3. Any red errors?
4. Go to Network tab
5. Make API call
6. Click request
7. Check Response section

---

## Checklist

- [ ] API URL updated in `js/app.js`
- [ ] PHP backend deployed/running
- [ ] All features tested locally
- [ ] Database backed up
- [ ] Deployed to Netlify
- [ ] Testing on Netlify works
- [ ] Shared with friends ✅

---

## Quick Decision Tree

```
Does it work locally?
  ├─ NO
  │   ├─ Check API_BASE_URL
  │   ├─ Check backend running
  │   ├─ Check browser console
  │   └─ Check Network tab
  │
  └─ YES
      ├─ Did you update API_BASE_URL?
      │   └─ NO → Update it!
      │
      └─ YES → Deploy to Netlify!
```

---

## Error Messages & Fixes

| Error | Fix |
|-------|-----|
| "Cannot read token" | Clear localStorage |
| "CORS Error" | Check API_BASE_URL |
| "404 Not Found" | Wrong API URL |
| "Invalid credentials" | Wrong email/password |
| "Email already registered" | Use different email |
| "Forbidden" | Not owner of story |

---

## Helpful Links

- Netlify: https://app.netlify.com
- GitHub: https://github.com
- PHP Hosting: https://www.hostinger.com
- Install NVM: https://github.com/nvm-sh/nvm

---

## Files Changed

✅ **New:**
- `Api.php` - API Base controller
- `AuthApi.php` - Auth endpoints
- `StoriesApi.php` - Story endpoints
- `EpisodesApi.php` - Episode endpoints
- `netlify/` folder - Entire frontend
- `NETLIFY_SETUP.md` - Setup guide
- `API_DOCUMENTATION.md` - API ref
- `LOCAL_TESTING.md` - Testing guide

✅ **Updated:**
- `config/routes.php` - Added API routes

✅ **Unchanged:**
- All models still work
- Database schema same
- Original controllers still work
- All your data safe

---

## Key Differences

| Before | After |
|--------|-------|
| PHP rendered HTML | Browsers render HTML |
| Works only on localhost | Works globally |
| Friends can't access | Friends can share |
| Slow | Fast (CDN) |
| Hard to scale | Easy to scale |
| No API | Full REST API |

---

## Remember

- **API_BASE_URL** = Most important thing!
- **Netlify URL** = Share with friends
- **PHP backend URL** = Where data lives
- **Token** = Stored in localStorage automatically
- **HTTPS** = Always use in production

---

**You got this!** 🚀

If stuck, check the detailed docs:
- `NETLIFY_SETUP.md`
- `API_DOCUMENTATION.md`  
- `LOCAL_TESTING.md`

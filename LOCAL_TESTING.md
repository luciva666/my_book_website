# Local Testing Guide

Before deploying to Netlify, test everything locally!

## 📋 Prerequisites

- PHP running (XAMPP, local server, etc.)
- MySQL database with your data
- Both API controllers and frontend ready

## 🧪 Testing Steps

### Step 1: Start Services

Make sure XAMPP or your local PHP server is running:

```bash
# If using XAMPP
# Start Apache and MySQL from XAMPP control panel

# Or use PHP built-in server
php -S localhost:80 -t .
```

### Step 2: Test Backend API

Test the API endpoints directly using a browser or curl:

```bash
# Test if API is accessible
# Open in browser:
http://localhost/api/stories

# Should return JSON:
{"success": true, "stories": [...]}

# Test registration via curl:
curl -X POST http://localhost/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"password123"}'

# Expected response:
{"success": true, "user": {...}, "token": "..."}
```

### Step 3: Serve Frontend

The frontend needs to be served over HTTP. Use any of these:

**Option A: Python**
```bash
cd netlify
python -m http.server 8000
# Visit: http://localhost:8000
```

**Option B: Node.js**
```bash
cd netlify
npx http-server
# Visit: http://localhost:8080
```

**Option C: PHP**
```bash
cd netlify
php -S localhost:3000
# Visit: http://localhost:3000
```

**Option D: VS Code Live Server**
- Right-click `index.html` in netlify folder
- Select "Open with Live Server"

### Step 4: Update API URL for Testing

Make sure `netlify/js/app.js` has correct API URL:

```javascript
// Line 2
const API_BASE_URL = 'http://localhost/index.php';
```

### Step 5: Test All Features

#### 1. Registration
- [ ] Go to http://localhost:8000/auth/register.html
- [ ] Fill form and click Register
- [ ] Should redirect to home
- [ ] Token should be in LocalStorage

#### 2. Login
- [ ] Go to http://localhost:8000/auth/login.html
- [ ] Enter credentials from registration
- [ ] Should redirect to home
- [ ] Check "Profile" works

#### 3. Create Story
- [ ] Go to http://localhost:8000/create-story.html
- [ ] Fill in title and description
- [ ] Click "Create Story"
- [ ] Should redirect to story page

#### 4. View Story
- [ ] Story should display correctly
- [ ] Episodes should show (if any)
- [ ] Author info should display
- [ ] Edit/Delete buttons should appear (if owner)

#### 5. Edit Story
- [ ] Click "Edit" on your story
- [ ] Change title/body
- [ ] Click "Save Changes"
- [ ] Changes should apply

#### 6. Add Episode
- [ ] On story page, scroll to "Add New Episode"
- [ ] Enter episode content
- [ ] Click "Add Episode"
- [ ] Episode should appear below

#### 7. Profile
- [ ] Go to http://localhost:8000/profile.html
- [ ] Update name/email
- [ ] Click "Save Changes"
- [ ] Changes should apply

#### 8. Logout
- [ ] Click "Logout"
- [ ] Should redirect to home
- [ ] Login link should reappear
- [ ] Token should be removed from LocalStorage

## 🔍 Debug Tips

### Open Browser Console
Press `F12` or `Ctrl+Shift+I`

Check:
- **Console tab**: Any JavaScript errors?
- **Network tab**: Are API calls being made?
- **Storage tab**: Is token saved in LocalStorage?

### Check Network Requests

1. Open DevTools (F12)
2. Go to Network tab
3. Perform action (e.g., login)
4. Click on request to see:
   - **Request headers**: Authorization header present?
   - **Request body**: Sending correct data?
   - **Response**: Getting JSON back?
   - **Status**: 200 (success) or error?

### Check LocalStorage

1. Open DevTools (F12)
2. Go to Application tab
3. Click LocalStorage
4. Check for:
   - `authToken` - should be present after login
   - `user` - should contain user data

### Test API Directly

Use curl to test API without frontend:

```bash
# Test stories endpoint
curl http://localhost/api/stories

# Test login
curl -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# With token (replace TOKEN with actual token)
curl -H "Authorization: Bearer TOKEN" \
  http://localhost/api/auth/profile
```

## ⚠️ Common Issues

### Issue: "CORS Error"
```
Error: Access to XMLHttpRequest blocked by CORS policy

Solution:
1. Check API_BASE_URL is correct
2. Verify backend is returning CORS headers
3. Check browser console for actual URL being called
4. Try without localhost (e.g., 127.0.0.1)
```

### Issue: "Cannot GET /path"
```
This is normal! It means you're navigating directly.
The app is single-page and all routes go through index.html

Solution:
Make sure you're accessing: http://localhost:8000/
Not: http://localhost:8000/story-view.html
The URL will change, but HTML stays the same.
```

### Issue: "API returns 404"
```
Error: API endpoint not found

Solution:
1. Check routes.php has the API routes
2. Verify PHP server is running
3. Check API_BASE_URL includes /index.php
4. Test endpoint with curl directly
```

### Issue: "Login works but profile shows error"
```
Solution:
1. Token might be invalid
2. Check token in LocalStorage
3. Verify JWT secret matches between login and profile check
4. Token might have expired (expires in 30 days)
```

### Issue: "Database connection error"
```
Solution:
1. Check MySQL is running
2. Verify database.php credentials
3. Ensure database exists
4. Check tables exist: users, stories, episodes
```

## 📊 What to Check if Something Fails

1. **Network Issue?**
   - Check DevTools → Network tab
   - Is request reaching server?
   - Check response status (200, 400, 401, 404, 500?)

2. **API Issue?**
   - Test endpoint with curl
   - Check browser console
   - Look at response body for error message

3. **Frontend Issue?**
   - Check JavaScript console
   - Is event listener attached?
   - Are values being sent to API?

4. **Database Issue?**
   - Check database exists
   - Check tables exist
   - Check columns match expected format
   - Verify foreign keys (story_id → episodes)

## ✅ Ready to Deploy?

When all tests pass:
- [ ] Registration works
- [ ] Login works
- [ ] Create story works
- [ ] View story works
- [ ] Add episodes works
- [ ] Edit works
- [ ] Delete works
- [ ] Profile works
- [ ] Logout works
- [ ] No console errors
- [ ] Responsive on mobile

Then you're ready to deploy to Netlify!

## 🚀 Next Steps

1. Update API_BASE_URL to production URL
2. Deploy to Netlify
3. Test on production
4. Share with friends!

---

**Happy testing!** 🎉

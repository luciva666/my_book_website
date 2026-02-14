# ✅ Pre-Deployment Checklist

Use this checklist to ensure everything is ready before deploying to Netlify.

## 1. Backend Setup

### PHP API
- [ ] `Api.php` created in `controllers/`
- [ ] `AuthApi.php` created in `controllers/`
- [ ] `StoriesApi.php` created in `controllers/`
- [ ] `EpisodesApi.php` created in `controllers/`
- [ ] All API files have correct namespaces
- [ ] Routes added to `config/routes.php`

### Database
- [ ] Database exists and is accessible
- [ ] Tables created: users, stories, episodes
- [ ] All columns present and correct types
- [ ] Foreign keys properly configured
- [ ] Sample data exists for testing (optional)

### Testing
- [ ] PHP server can start without errors
- [ ] API endpoints are accessible
- [ ] cors headers are present in responses
- [ ] JWT tokens are generated correctly
- [ ] All API calls return JSON

## 2. Frontend Setup

### Files Created
- [ ] `netlify/index.html` - home page
- [ ] `netlify/story-view.html` - story viewer
- [ ] `netlify/create-story.html` - story creator
- [ ] `netlify/edit-story.html` - story editor
- [ ] `netlify/profile.html` - user profile
- [ ] `netlify/auth/login.html` - login page
- [ ] `netlify/auth/register.html` - registration page
- [ ] `netlify/js/app.js` - app logic
- [ ] `netlify/css/style.css` - styles
- [ ] `netlify/netlify.toml` - netlify config
- [ ] `netlify/_redirects` - routing config

### CSS
- [ ] All styles load without errors
- [ ] Colors are consistent
- [ ] Responsive design works (test on mobile)
- [ ] Buttons are clickable
- [ ] Forms are readable

### JavaScript
- [ ] No JavaScript errors in console
- [ ] API class works correctly
- [ ] AuthManager class works
- [ ] Event listeners are attached
- [ ] Fetch calls work

## 3. API URL Configuration

- [ ] API_BASE_URL is set in `app.js` (line 2)
- [ ] URL is correct for your backend
- [ ] URL uses HTTPS (if applicable)
- [ ] URL ends with `/index.php`

**Before local testing:**
```javascript
const API_BASE_URL = 'http://localhost/index.php';
```

**Before Netlify deployment:**
```javascript
const API_BASE_URL = 'https://your-php-server.com/index.php';
```

## 4. Local Testing

### Server Setup
- [ ] PHP server is running
- [ ] MySQL is running (if using XAMPP)
- [ ] Frontend is being served over HTTP (not file://)

### Registration
- [ ] Can access register page
- [ ] Form validation works
- [ ] Can submit form without errors
- [ ] User is created in database
- [ ] Token is received and stored
- [ ] Redirects to home page

### Login
- [ ] Can access login page
- [ ] Can login with valid credentials
- [ ] Token is stored in localStorage
- [ ] Redirects to home page
- [ ] "Profile" link shows in header

### Stories
- [ ] Home page loads all stories
- [ ] Story cards display correctly
- [ ] Can click "Read More" 
- [ ] Story page loads
- [ ] Episode count is correct
- [ ] Author name displays

### Create Story
- [ ] Can access create story page (requires login)
- [ ] All form fields present
- [ ] Can submit with title and body
- [ ] Story appears in list
- [ ] Can modify and view new story

### Edit Story
- [ ] Can edit own stories
- [ ] Changes are saved
- [ ] Cannot edit other users' stories
- [ ] Cannot delete other users' stories

### Add Episodes
- [ ] Can add episode to own story
- [ ] Episode appears immediately
- [ ] Episode count updates
- [ ] Can edit/delete episodes

### User Profile
- [ ] Can view own profile
- [ ] Name and email display correctly
- [ ] Can update name
- [ ] Can update email
- [ ] Can change password
- [ ] Changes are persisted

### Logout
- [ ] Logout button works
- [ ] Token is removed from localStorage
- [ ] Redirects to home
- [ ] Auth links reappear in header

### Responsive Design
- [ ] Test on desktop (1920x1080)
- [ ] Test on tablet (768x1024)
- [ ] Test on mobile (375x667)
- [ ] All elements visible
- [ ] No horizontal scrolling
- [ ] Buttons are tappable

## 5. Error Handling

### Network Errors
- [ ] Wrong API URL shows clear error
- [ ] Server down shows error message
- [ ] Invalid credentials show message
- [ ] Email already used shows message

### Form Validation
- [ ] Empty fields show error
- [ ] Invalid email shows error
- [ ] Short password shows error
- [ ] Passwords don't match shows error

### Authorization
- [ ] Non-logged-in users can't create story
- [ ] Non-owners can't edit story
- [ ] Non-owners can't delete story
- [ ] Non-owners can't add episodes

## 6. Browser Compatibility

Test on:
- [ ] Chrome/Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

## 7. Documentation

- [ ] QUICK_REFERENCE.md updated ✅
- [ ] NETLIFY_SETUP.md updated ✅
- [ ] API_DOCUMENTATION.md updated ✅
- [ ] LOCAL_TESTING.md updated ✅
- [ ] netlify/README.md updated ✅
- [ ] DOCUMENTATION_INDEX.md created ✅

## 8. Security Checklist

Database
- [ ] Database credentials are secure
- [ ] No hardcoded passwords in code
- [ ] Database backups are made
- [ ] Backups are stored safely

Code
- [ ] No sensitive data in frontend
- [ ] No API keys exposed
- [ ] Passwords hashed before storage
- [ ] CORS configured correctly

Deployment
- [ ] Using HTTPS everywhere
- [ ] No debug mode enabled
- [ ] Error messages don't expose internals
- [ ] JWT secret is strong

## 9. Performance Checks

- [ ] No console errors
- [ ] No console warnings
- [ ] Network requests complete quickly
- [ ] Pages load in <2 seconds
- [ ] Database queries are optimized

## 10. Final Checks

Before going to production:
- [ ] All tests pass locally
- [ ] Database is backed up
- [ ] API_BASE_URL updated
- [ ] No hardcoded localhost URLs
- [ ] All files are in right directory
- [ ] `.env` files don't contain secrets
- [ ] Ready to deploy!

## 11. Netlify Deployment

### Pre-Deploy
- [ ] GitHub account created
- [ ] Repository created
- [ ] All files committed
- [ ] No uncommitted changes
- [ ] Netlify account created

### Deploy
- [ ] Connected GitHub to Netlify
- [ ] Selected correct repository
- [ ] Base directory set to `netlify`
- [ ] Publish directory set to `.`
- [ ] Build command is empty (or custom)
- [ ] Site deployed successfully

### Post-Deploy
- [ ] Netlify URL is accessible
- [ ] Can register new account
- [ ] Can create story
- [ ] Can add episodes
- [ ] No console errors on Netlify
- [ ] Responsive design works

## 12. Testing on Netlify

With the production API URL:
- [ ] All features work
- [ ] No CORS errors
- [ ] Tokens save properly
- [ ] Can create story
- [ ] Can add episodes
- [ ] Can logout and login again

## 13. Share & Monitor

- [ ] Share Netlify URL with friends
- [ ] Test with friend account
- [ ] Ensure friend can:
  - [ ] Register
  - [ ] Login
  - [ ] Create story
  - [ ] View other stories
  - [ ] Manage own stories

## 14. Important Notes

⚠️ **Critical:**
- [ ] API_BASE_URL is updated
- [ ] Backend is accessible from internet
- [ ] HTTPS is being used
- [ ] Database is backed up

🔐 **Security:**
- [ ] No sensitive data in frontend
- [ ] Passwords are hashed
- [ ] JWT tokens are validated
- [ ] CORS is configured

📱 **Responsive:**
- [ ] Works on mobile
- [ ] Works on tablet
- [ ] Works on desktop
- [ ] Touch-friendly buttons

## Scoring

Count your checkmarks:
- **95-100%**: Ready to deploy! 🚀
- **80-95%**: Almost there, fix remaining issues
- **<80%**: Fix issues before deploying

## Sign-Off

When everything is checked:

```
I confirm that:
- [ ] All tests pass locally
- [ ] API_BASE_URL is correct
- [ ] Documentation is complete
- [ ] Database is backed up
- [ ] Ready to deploy to Netlify

Signed: ________________  Date: __________
```

---

**You're ready when everything is green!** ✅

Deploy with confidence! 🚀

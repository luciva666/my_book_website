# My Stories - Netlify Frontend

This is the static frontend for My Stories website that runs on Netlify.

## 📋 Files Structure

```
netlify/
├── index.html                 # Home page - lists all stories
├── story-view.html           # View a single story with episodes
├── create-story.html         # Create new story (requires login)
├── edit-story.html           # Edit story (requires login)
├── profile.html              # User profile management
├── auth/
│   ├── login.html           # Login page
│   └── register.html        # Registration page
├── css/
│   └── style.css            # Main stylesheet
├── js/
│   └── app.js               # API communication & app logic
├── netlify.toml             # Netlify configuration
├── _redirects               # Client-side routing
└── README.md                # This file
```

## 🚀 Quick Start

### Prerequisites
- The PHP backend must be running and accessible
- Update the `API_BASE_URL` in `js/app.js` with your PHP backend URL

### Local Testing

1. **Change the API URL** in `js/app.js`:
```javascript
const API_BASE_URL = 'http://localhost/index.php'; // Your PHP backend
```

2. **Open in browser** - Serve this folder using any local server:
```bash
# Option 1: Using Python
python -m http.server 8000

# Option 2: Using Node.js http-server
npx http-server

# Option 3: Using PHP
php -S localhost:8000
```

3. Visit `http://localhost:8000`

## 📱 Features

- ✅ User registration and login
- ✅ Create, read, update, delete stories
- ✅ Add episodes to stories
- ✅ User profile management
- ✅ Responsive design
- ✅ JWT authentication
- ✅ Client-side routing

## 🔧 Configuration

### Update Backend URL
Edit `js/app.js` line 2:
```javascript
const API_BASE_URL = 'http://your-php-server.com/index.php';
```

## 🌐 Deploy to Netlify

### Option 1: GitHub Integration (Recommended)

1. Push this folder to GitHub
2. Go to [Netlify](https://app.netlify.com)
3. Click "New site from Git"
4. Connect your GitHub account
5. Select your repository
6. Configure:
   - **Base directory:** `netlify`
   - **Build command:** Leave empty (or enter `echo 'No build needed'`)
   - **Publish directory:** `.` (current directory)
7. Deploy!

### Option 2: Manual Deploy (Drag & Drop)

1. Go to [Netlify](https://app.netlify.com)
2. Drag and drop the `netlify` folder to Netlify
3. Your site will be live immediately!

### Option 3: Netlify CLI

```bash
# Install Netlify CLI
npm install -g netlify-cli

# Login to Netlify
netlify login

# Deploy
netlify deploy --pub netlify

# Deploy to production
netlify deploy --pub netlify --prod
```

## 🔐 Important: Update API URL After Deployment

After deploying to Netlify, update the `API_BASE_URL` in `js/app.js`:

```javascript
// Production
const API_BASE_URL = 'https://your-php-server.com/index.php';

// Or if PHP backend is on same domain
const API_BASE_URL = 'https://api.youromain.com/index.php';
```

## 📚 API Documentation

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user
- `POST /api/auth/logout` - Logout user
- `GET /api/auth/profile` - Get user profile
- `POST /api/auth/profile` - Update user profile

### Stories
- `GET /api/stories` - Get all stories
- `GET /api/stories/{id}` - Get single story with episodes
- `POST /api/stories/create` - Create new story
- `POST /api/stories/{id}/update` - Update story
- `POST /api/stories/{id}/delete` - Delete story

### Episodes
- `GET /api/episodes/{id}` - Get single episode
- `POST /api/episodes/story/{story_id}/create` - Create episode
- `POST /api/episodes/{id}/update` - Update episode
- `POST /api/episodes/{id}/delete` - Delete episode

### Authentication Header
All authenticated requests require:
```
Authorization: Bearer {token}
```

## 🌍 CORS Configuration

The API supports CORS. Make sure your PHP backend allows requests from:
- `localhost` (for local testing)
- Your Netlify domain (e.g., `your-site.netlify.app`)

## 📦 PHP Backend Requirements

Your PHP backend needs:
1. All API endpoints from `application/controllers/` folder
2. Database with tables: `users`, `stories`, `episodes`
3. Public URL or domain accessible from internet
4. CORS headers enabled (already handled in API controllers)

## 🐛 Troubleshooting

### "CORS Error" or "Network Error"
- Check that the `API_BASE_URL` is correct in `js/app.js`
- Verify your PHP backend is running and accessible
- Check browser console for detailed error messages

### "Cannot GET /page"
- This is normal! The `_redirects` file handles all routes
- The app is single-page and works entirely from `index.html`

### Login/Auth Not Working
- Make sure JWT tokens are being created correctly in PHP
- Check browser's LocalStorage (DevTools > Application > LocalStorage)
- Verify token format: `Header.Payload.Signature`

## 📝 Notes

- Tokens are stored in browser's LocalStorage
- Tokens expire after 30 days
- Always use HTTPS in production
- Never commit files with sensitive data (API keys, etc.)

## 🤝 Support

For issues with the backend, see the main project README.

---

**Made with ❤️ for My Stories**

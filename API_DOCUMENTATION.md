# My Stories - API Documentation

## Base URL
```
https://your-php-server.com/api
```

## Authentication

All authenticated endpoints require the following header:
```
Authorization: Bearer {jwt_token}
```

Tokens are returned after login/registration and stored in the client's localStorage.

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Optional message",
  "data": {}
}
```

### Error Response
```json
{
  "error": "Error message description"
}
```

---

## Endpoints

### AUTH

#### Register
Create a new user account.

```
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "securepassword123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Registration successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "avatar": null
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Errors:**
- 400: Missing required fields
- 400: Invalid email format
- 400: Password must be at least 6 characters
- 400: Email already registered

---

#### Login
Authenticate user and retrieve JWT token.

```
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "securepassword123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "avatar": null
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Errors:**
- 400: Missing required fields
- 401: Invalid email or password

---

#### Logout
Invalidate user session (client-side).

```
POST /api/auth/logout
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

#### Get Profile
Retrieve authenticated user's profile.

```
GET /api/auth/profile
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "avatar": null
  }
}
```

**Errors:**
- 401: Unauthorized (missing/invalid token)

---

#### Update Profile
Update user profile information.

```
POST /api/auth/profile
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "newpassword123"
}
```

All fields are optional. Password is only updated if provided.

**Response (200):**
```json
{
  "success": true,
  "message": "Profile updated",
  "user": {
    "id": 1,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "avatar": null
  }
}
```

**Errors:**
- 401: Unauthorized
- 400: Invalid email format
- 400: Email already in use
- 400: Password must be at least 6 characters

---

### STORIES

#### List All Stories
Get all stories with basic information.

```
GET /api/stories
```

**Response (200):**
```json
{
  "success": true,
  "stories": [
    {
      "id": 1,
      "title": "Adventure in the Forest",
      "body": "Once upon a time...",
      "cover_image": null,
      "created_at": "2024-02-14 10:00:00",
      "updated_at": null,
      "author": {
        "id": 1,
        "name": "John Doe",
        "avatar": null
      },
      "episode_count": 3
    }
  ]
}
```

---

#### Get Single Story
Get full story details with all episodes.

```
GET /api/stories/{id}
```

**Response (200):**
```json
{
  "success": true,
  "story": {
    "id": 1,
    "title": "Adventure in the Forest",
    "body": "Once upon a time...",
    "cover_image": null,
    "created_at": "2024-02-14 10:00:00",
    "updated_at": null,
    "author": {
      "id": 1,
      "name": "John Doe",
      "avatar": null
    }
  },
  "episodes": [
    {
      "id": 1,
      "content": "First episode content...",
      "created_at": "2024-02-14 10:30:00"
    }
  ]
}
```

**Errors:**
- 404: Story not found

---

#### Create Story
Create a new story (requires authentication).

```
POST /api/stories/create
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "My New Story",
  "body": "This is the story description...",
  "cover_image": null
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Story created successfully",
  "story": {
    "id": 2,
    "title": "My New Story",
    "body": "This is the story description...",
    "cover_image": null,
    "created_at": "2024-02-14 11:00:00",
    "author": {
      "id": 1,
      "name": "John Doe",
      "avatar": null
    }
  }
}
```

**Errors:**
- 401: Unauthorized
- 400: Missing required fields (title, body)

---

#### Update Story
Update an existing story (must be story owner).

```
POST /api/stories/{id}/update
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Updated Title",
  "body": "Updated body...",
  "cover_image": null
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Story updated successfully",
  "story": {
    "id": 2,
    "title": "Updated Title",
    "body": "Updated body...",
    "cover_image": null,
    "updated_at": "2024-02-14 11:15:00",
    "author": {
      "id": 1,
      "name": "John Doe",
      "avatar": null
    }
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (not story owner)
- 404: Story not found

---

#### Delete Story
Delete a story (must be story owner).

```
POST /api/stories/{id}/delete
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Story deleted successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (not story owner)
- 404: Story not found

---

### EPISODES

#### Get Episode
Get a single episode details.

```
GET /api/episodes/{id}
```

**Response (200):**
```json
{
  "success": true,
  "episode": {
    "id": 1,
    "story_id": 1,
    "content": "Episode content...",
    "created_at": "2024-02-14 10:30:00",
    "index": 1
  },
  "story": {
    "id": 1,
    "title": "Adventure in the Forest"
  },
  "prev": null,
  "next": {
    "id": 2,
    "created_at": "2024-02-14 11:00:00"
  }
}
```

**Errors:**
- 404: Episode not found

---

#### Create Episode
Add new episode to a story (must be story owner).

```
POST /api/episodes/story/{story_id}/create
Authorization: Bearer {token}
Content-Type: application/json

{
  "content": "New episode content..."
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Episode created successfully",
  "episode": {
    "id": 4,
    "story_id": 1,
    "content": "New episode content...",
    "created_at": "2024-02-14 12:00:00"
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (not story owner)
- 404: Story not found
- 400: Missing required field (content)

---

#### Update Episode
Update episode content (must be story owner).

```
POST /api/episodes/{id}/update
Authorization: Bearer {token}
Content-Type: application/json

{
  "content": "Updated episode content..."
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Episode updated successfully",
  "episode": {
    "id": 4,
    "story_id": 1,
    "content": "Updated episode content...",
    "created_at": "2024-02-14 12:00:00"
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (not story owner)
- 404: Episode not found
- 400: Missing required field (content)

---

#### Delete Episode
Delete an episode (must be story owner).

```
POST /api/episodes/{id}/delete
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Episode deleted successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (not story owner)
- 404: Episode not found

---

## Status Codes

| Code | Meaning |
|------|---------|
| 200 | Success |
| 400 | Bad Request (invalid input) |
| 401 | Unauthorized (missing/invalid token) |
| 403 | Forbidden (no permission) |
| 404 | Not Found |
| 405 | Method Not Allowed |

---

## Rate Limiting

Currently no rate limiting. In production, consider implementing:
- Max 100 requests per minute per IP
- Max 1000 requests per hour per user

---

## Example Usage

### JavaScript (Frontend)

```javascript
// Register
const response = await fetch('/api/auth/register', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    name: 'John Doe',
    email: 'john@example.com',
    password: 'securepassword123'
  })
});
const data = await response.json();
const token = data.token;

// Create Story
const storyResponse = await fetch('/api/stories/create', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${token}`
  },
  body: JSON.stringify({
    title: 'My Story',
    body: 'Story content...'
  })
});
const story = await storyResponse.json();
```

### cURL (Testing)

```bash
# Register
curl -X POST http://localhost/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"pass123"}'

# Login
curl -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"pass123"}'

# Get Stories
curl http://localhost/api/stories

# Create Story (requires token)
curl -X POST http://localhost/api/stories/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer TOKEN_HERE" \
  -d '{"title":"Story","body":"Content"}'
```

---

## Notes

- All timestamps are in UTC format: `YYYY-MM-DD HH:MM:SS`
- Tokens expire after 30 days
- Use HTTPS in production
- CORS is enabled for all origins
- The API is RESTful but uses POST for all mutations (not PUT/DELETE)

---

**Last Updated:** February 14, 2024
**API Version:** 1.0

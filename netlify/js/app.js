// CONFIGURATION
// Change this to your PHP backend URL
const API_BASE_URL = 'http://localhost/my_book_website/index.php'; // Change to your PHP server URL when deployed

// Store auth token in localStorage
class AuthManager {
    static get token() {
        return localStorage.getItem('authToken');
    }

    static set token(value) {
        if (value) {
            localStorage.setItem('authToken', value);
        } else {
            localStorage.removeItem('authToken');
        }
    }

    static get user() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }

    static set user(value) {
        if (value) {
            localStorage.setItem('user', JSON.stringify(value));
        } else {
            localStorage.removeItem('user');
        }
    }

    static isAuthenticated() {
        return !!this.token;
    }

    static logout() {
        this.token = null;
        this.user = null;
    }
}

// API communication
class API {
    static async request(endpoint, options = {}) {
        const url = `${API_BASE_URL}/${endpoint}`;
        const headers = {
            'Content-Type': 'application/json',
            ...options.headers
        };

        if (AuthManager.token) {
            headers['Authorization'] = `Bearer ${AuthManager.token}`;
        }

        const response = await fetch(url, {
            method: options.method || 'GET',
            headers,
            body: options.body ? JSON.stringify(options.body) : undefined
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'API Error');
        }

        return data;
    }

    // Auth endpoints
    static async register(name, email, password) {
        const data = await this.request('api/auth/register', {
            method: 'POST',
            body: { name, email, password }
        });
        AuthManager.token = data.token;
        AuthManager.user = data.user;
        return data;
    }

    static async login(email, password) {
        const data = await this.request('api/auth/login', {
            method: 'POST',
            body: { email, password }
        });
        AuthManager.token = data.token;
        AuthManager.user = data.user;
        return data;
    }

    static async logout() {
        await this.request('api/auth/logout', { method: 'POST' });
        AuthManager.logout();
    }

    static async getProfile() {
        return this.request('api/auth/profile');
    }

    static async updateProfile(data) {
        return this.request('api/auth/profile', {
            method: 'POST',
            body: data
        });
    }

    // Stories endpoints
    static async getStories() {
        return this.request('api/stories');
    }

    static async getStory(id) {
        return this.request(`api/stories/${id}`);
    }

    static async createStory(title, body, coverImage = null) {
        return this.request('api/stories/create', {
            method: 'POST',
            body: { title, body, cover_image: coverImage }
        });
    }

    static async updateStory(id, title, body, coverImage = null) {
        return this.request(`api/stories/${id}/update`, {
            method: 'POST',
            body: { title, body, cover_image: coverImage }
        });
    }

    static async deleteStory(id) {
        return this.request(`api/stories/${id}/delete`, {
            method: 'POST'
        });
    }

    // Episodes endpoints
    static async getEpisode(id) {
        return this.request(`api/episodes/${id}`);
    }

    static async createEpisode(storyId, content) {
        return this.request(`api/episodes/story/${storyId}/create`, {
            method: 'POST',
            body: { content }
        });
    }

    static async updateEpisode(id, content) {
        return this.request(`api/episodes/${id}/update`, {
            method: 'POST',
            body: { content }
        });
    }

    static async deleteEpisode(id) {
        return this.request(`api/episodes/${id}/delete`, {
            method: 'POST'
        });
    }
}

// Utility functions
function showError(message) {
    const errorDiv = document.getElementById('error-message');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 5000);
    } else {
        alert(message);
    }
}

function showSuccess(message) {
    const successDiv = document.getElementById('success-message');
    if (successDiv) {
        successDiv.textContent = message;
        successDiv.style.display = 'block';
        setTimeout(() => {
            successDiv.style.display = 'none';
        }, 3000);
    } else {
        alert(message);
    }
}

function updateAuthUI() {
    const authSection = document.getElementById('auth-section');
    const userSection = document.getElementById('user-section');

    if (AuthManager.isAuthenticated()) {
        if (authSection) authSection.style.display = 'none';
        if (userSection) {
            userSection.style.display = 'block';
            const userName = document.getElementById('user-name');
            if (userName && AuthManager.user) {
                userName.textContent = AuthManager.user.name;
            }
        }
    } else {
        if (authSection) authSection.style.display = 'block';
        if (userSection) userSection.style.display = 'none';
    }
}

function redirectTo(page) {
    window.location.href = `/${page}.html`;
}

// Run on page load
document.addEventListener('DOMContentLoaded', () => {
    updateAuthUI();
});

// Main JavaScript file for BuildifyHub Frontend

document.addEventListener('DOMContentLoaded', () => {
    console.log('BuildifyHub Frontend Initialized');

    // Example: Smooth scrolling for anchor links (if any)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            try {
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            } catch (error) {
                console.warn('Smooth scroll target not found:', this.getAttribute('href'));
            }
        });
    });

    // Placeholder for future API base URL
    // const API_BASE_URL = 'http://localhost:5001/api/v1'; // Adjust if backend port changes

    // More functions will be added here for:
    // - User Authentication (Login, Register, Logout)
    // - Fetching and displaying materials
    // - Handling order submissions
    // - Updating user dashboards
    // - Form validations
});

// --- Authentication Functions (Placeholders) ---
async function handleLogin(event) {
    event.preventDefault();
    const form = event.target;
    const email = form.email.value;
    const password = form.password.value;
    console.log('Attempting login for:', email);
    // TODO: Implement API call to /login endpoint
    // Show loading state, handle response (success/error), store token, redirect
}

async function handleRegister(event) {
    event.preventDefault();
    const form = event.target;
    const username = form.username.value;
    const email = form.email.value;
    const password = form.password.value;
    const isSupplier = form.isSupplier ? form.isSupplier.checked : false; // Check if checkbox exists
    console.log('Attempting registration for:', username, email, 'Is Supplier:', isSupplier);
    // TODO: Implement API call to /register endpoint
    // Show loading state, handle response (success/error), redirect to login or dashboard
}

function handleLogout() {
    console.log('User logged out');
    // TODO: Clear stored token/user info, redirect to homepage or login page
}

// --- Material Functions (Placeholders) ---
async function fetchMaterials() {
    console.log('Fetching materials...');
    // TODO: Implement API call to GET /materials
    // Update DOM to display materials
}

async function fetchMaterialDetails(materialId) {
    console.log(`Fetching details for material ID: ${materialId}`);
    // TODO: Implement API call to GET /materials/{materialId}
    // Update DOM to display material details
}

// --- Order Functions (Placeholders) ---
async function handlePlaceOrder(event) {
    event.preventDefault();
    console.log('Placing order...');
    // TODO: Gather cart items, user info
    // TODO: Implement API call to POST /orders
    // Handle response, clear cart, show confirmation
}

// --- Utility Functions ---
function displayMessage(elementId, message, isError = false) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = message;
        element.className = isError ? 'error-message' : 'success-message';
        element.style.display = 'block';
    }
}

function clearMessage(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = '';
        element.style.display = 'none';
    }
}

// Example of how to attach event listeners to forms if they are present in the HTML
// const loginForm = document.getElementById('login-form');
// if (loginForm) {
//     loginForm.addEventListener('submit', handleLogin);
// }

// const registrationForm = document.getElementById('registration-form');
// if (registrationForm) {
//     registrationForm.addEventListener('submit', handleRegister);
// }

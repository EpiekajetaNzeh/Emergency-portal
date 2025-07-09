# BuildifyHub

BuildifyHub is a platform designed to connect builders with suppliers of building materials, facilitating the sourcing of quality materials. This repository contains the source code for both the frontend and backend of the BuildifyHub application.

## Project Structure

The project is organized into two main directories:

-   `/frontend`: Contains the HTML, CSS, and JavaScript for the client-side application.
-   `/backend`: Contains the Node.js, Express, and Sequelize code for the server-side API and business logic.

## Technology Stack

**Backend:**
-   Node.js
-   Express.js (web framework)
-   Sequelize (ORM for PostgreSQL)
-   PostgreSQL (database)
-   JSON Web Tokens (JWT) for authentication
-   bcryptjs (for password hashing)

**Frontend:**
-   HTML
-   CSS
-   Vanilla JavaScript

## Prerequisites

-   Node.js (version 14.x or higher recommended)
-   npm (Node Package Manager)
-   PostgreSQL server installed and running.

## Setup and Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd buildifyhub_project/buildifyhub
```

### 2. Backend Setup

1.  **Navigate to the backend directory:**
    ```bash
    cd backend
    ```

2.  **Install dependencies:**
    ```bash
    npm install
    ```

3.  **Set up environment variables:**
    -   Create a `config/config.env` file by copying the example or creating it from scratch.
        ```
        cp config/config.env.example config/config.env
        ```
        *(Assuming a `config.env.example` would be created; for now, refer to the existing `config.env` and update its placeholder values)*
    -   Update `config/config.env` with your actual database credentials (PostgreSQL user, password, database name), JWT secret, etc.

    Example `config/config.env` structure:
    ```env
    NODE_ENV=development
    PORT=5001

    DB_DIALECT=postgres
    DB_HOST=localhost
    DB_PORT=5432
    DB_USERNAME=your_postgres_user
    DB_PASSWORD=your_postgres_password
    DB_NAME=buildifyhub_dev # Ensure this database exists in PostgreSQL

    JWT_SECRET=yoursupersecretjwtkey
    JWT_EXPIRE=30d
    JWT_COOKIE_EXPIRE_DAYS=30
    ```

4.  **Database Setup:**
    -   Ensure your PostgreSQL server is running.
    -   Create the database specified in `DB_NAME` (e.g., `buildifyhub_dev`) if it doesn't already exist.
        ```sql
        -- Example using psql:
        -- CREATE DATABASE buildifyhub_dev;
        ```
    -   The application uses Sequelize's `sync()` method on server start, which will attempt to create the necessary tables based on the defined models. For production, using Sequelize migrations is recommended (`npx sequelize-cli db:migrate`).

5.  **Run the backend server:**
    -   For development with auto-reloading (uses `nodemon`):
        ```bash
        npm run dev
        ```
    -   To start normally:
        ```bash
        npm start
        ```
    The backend server should start on the port specified in `config.env` (default: 5001).

### 3. Frontend Setup

1.  **Navigate to the frontend directory (from the project root):**
    ```bash
    cd frontend
    ```
    *(If you are in the `backend` directory, you'd do `cd ../frontend`)*

2.  **Serve the frontend files:**
    -   There is no build step for the current frontend as it's composed of static HTML, CSS, and JS.
    -   You can open the `index.html` file directly in your browser.
    -   For a better experience, serve the `frontend` directory using a simple HTTP server. For example, using `npx serve`:
        ```bash
        # Make sure you are in the buildifyhub_project/buildifyhub/frontend directory
        npx serve
        ```
        This will typically serve the site on `http://localhost:3000` (or another port if 3000 is busy).

3.  **API Configuration:**
    -   The frontend JavaScript (`js/main.js`) currently has placeholders for API calls. You might need to adjust the `API_BASE_URL` constant in the script if your backend is running on a different port or domain than expected by the frontend. (Currently, it's commented out and API calls are not fully implemented in the frontend JS).

## Basic Usage

-   **Register/Login:** Access the registration and login pages from the frontend to create an account or sign in.
-   **Browse Materials:** View available materials (currently uses dummy data on the frontend).
-   **Dashboard:** Once logged in, the dashboard will provide user-specific options (e.g., manage orders for builders, manage materials for suppliers). Functionality is currently based on mock user data.

## API Endpoints (Backend)

The backend exposes the following primary API routes under `/api/v1/`:

-   **Authentication (`/auth`):**
    -   `POST /register`: Register a new user.
    -   `POST /login`: Login an existing user.
    -   `GET /me`: Get details of the currently logged-in user (requires authentication token).

*(Further endpoints for profiles, materials, and orders will be documented as they are fully implemented).*

## Contributing

Contributions are welcome. Please follow standard coding practices and ensure any new features or fixes are well-tested.

*(Standard contribution guidelines would go here: e.g., fork, branch, commit, PR).*

## License

This project is licensed under the ISC License. (As specified in `backend/package.json`).
```

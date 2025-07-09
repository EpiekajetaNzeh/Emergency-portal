# Agent Instructions for BuildifyHub

This document provides specific instructions and tips for AI agents working on the BuildifyHub codebase.

## Project Overview

BuildifyHub connects builders with material suppliers. It has a Node.js/Express/Sequelize backend and a vanilla HTML/CSS/JS frontend.

**Key Directories:**
-   `backend/`: Node.js application.
    -   `server.js`: Main entry point.
    -   `routes/`: API route definitions.
    -   `controllers/`: Logic for handling requests.
    -   `models/`: Sequelize model definitions.
    -   `middleware/`: Express middleware (auth, error handling).
    -   `config/`: Configuration files (`database.js`, `config.env`).
-   `frontend/`: Static client-side application.
    -   `*.html`: HTML pages.
    -   `css/style.css`: Main stylesheet.
    -   `js/main.js`: Main JavaScript file for client-side logic.

## Current Development Status & Known Issues

*   **Environment Instability:** There have been persistent issues with the `run_in_bash_session` tool's ability to correctly access files and directories immediately after they are created (e.g., `cd` failing, `npm install` not finding `package.json`). This has blocked:
    *   Installation of backend dependencies (`npm install`).
    *   Running the backend server (`npm start` or `npm run dev`).
    *   Any form of backend API testing.
*   **Consequence:** While backend code (models, routes, controllers) has been written, it has not been run or tested in this environment. Frontend code relies on mock data or placeholder API interactions.

## Development Guidelines

### Backend (Node.js)

1.  **Dependencies:** All backend dependencies are listed in `backend/package.json`. If adding new dependencies, ensure they are added to this file (`npm install --save <package>` or `npm install --save-dev <package>`).
2.  **Database:**
    *   The project uses PostgreSQL with Sequelize. Models are defined in `backend/models/`.
    *   Database schema changes should ideally be handled via Sequelize migrations (using `sequelize-cli`), though `sequelize.sync()` is currently used in `server.js` for development simplicity. If you implement migrations, update the `README.md` setup instructions.
    *   Ensure environment variables for database connection (`DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME` in `backend/config/config.env`) are correctly set up for your local environment if you manage to get one running.
3.  **Authentication:** JWT is used. Key files: `backend/controllers/authController.js`, `backend/middleware/authMiddleware.js`.
4.  **Error Handling:** A custom error handler (`backend/middleware/errorHandler.js`) and an `ErrorResponse` utility class (`backend/utils/errorResponse.js`) are used. Async route handlers are wrapped with `asyncHandler` (`backend/middleware/asyncHandler.js`).
5.  **API Versioning:** API routes are prefixed with `/api/v1/`.
6.  **Testing:** If the environment allows, API tests should be written (e.g., using Jest and Supertest). Place tests in a `backend/tests/` directory.

### Frontend (HTML, CSS, JS)

1.  **Static Files:** The frontend is currently vanilla HTML, CSS, and JavaScript. No build process is in place.
2.  **API Interaction:** Client-side JavaScript in `frontend/js/main.js` is intended to interact with the backend API. Currently, many of these interactions are placeholders.
    *   Update the `API_BASE_URL` (if uncommented or used) to point to the correct backend server address.
3.  **Dynamic Content:** Content on pages like `materials.html` and `dashboard.html` is intended to be dynamic, populated from API responses. The current JS uses mock data for some of these.
4.  **Styling:** Global styles are in `frontend/css/style.css`. Add page-specific styles within `<style>` tags in HTML files or create separate CSS files if complexity increases.

### General

1.  **Tooling Issues:** Be mindful of the previously mentioned issues with `run_in_bash_session`. If these persist:
    *   You may need to rely on the user/environment to run `npm install` or start servers.
    *   When creating files, be aware that subsequent commands in `run_in_bash_session` might not see them immediately or might resolve paths incorrectly.
2.  **Iterative Development:** The project plan involves iterative implementation of core features. Focus on one feature set at a time (e.g., User Profiles, then Material Management, then Orders).
3.  **Documentation:** Keep `README.md` updated with setup instructions and any significant changes to the project structure or core functionality.

## Future Agent Tasks (If Environment Stabilizes)

1.  **Verify Backend Setup:**
    *   Run `npm install` in the `backend` directory.
    *   Configure `backend/config/config.env` for a local PostgreSQL instance.
    *   Run `npm run dev` (or `npm start`) to start the backend server.
    *   Test API endpoints using a tool like Postman or curl, starting with registration and login.
2.  **Implement Remaining Backend Features:**
    *   Profile management (CRUD for user profiles).
    *   Material management (CRUD for suppliers).
    *   Material browsing/searching for builders.
    *   Order creation and management.
3.  **Connect Frontend to Backend:**
    *   Replace all mock data and placeholder API calls in `frontend/js/main.js` with actual `fetch` calls to the live backend.
    *   Implement proper error handling and user feedback for API interactions on the frontend.
4.  **Write Tests:**
    *   Backend: API integration tests.
    *   Frontend: Consider basic UI tests if a framework like Jest + Puppeteer/Playwright is introduced.
5.  **Refine UI/UX:** Improve the user interface and experience based on the working application.

Your primary goal should be to make incremental, testable progress. If blocked by environment issues, clearly document the blockage and the specific code that needs to be run or tested.
```

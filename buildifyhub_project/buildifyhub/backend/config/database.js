// dotenv should be loaded by the main application entry point (e.g., server.js)
// require('dotenv').config({ path: './config.env' });

module.exports = {
  development: {
    username: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    dialect: process.env.DB_DIALECT,
    dialectOptions: {
      // ssl: { // Example for SSL connection if required by your DB provider
      //   require: true,
      //   rejectUnauthorized: false
      // }
    }
  },
  test: {
    username: process.env.DB_USERNAME_TEST || 'test_user',
    password: process.env.DB_PASSWORD_TEST || 'test_password',
    database: process.env.DB_NAME_TEST || 'buildifyhub_test',
    host: process.env.DB_HOST_TEST || 'localhost',
    port: process.env.DB_PORT_TEST || 5432,
    dialect: process.env.DB_DIALECT_TEST || 'postgres',
  },
  production: {
    username: process.env.DB_USERNAME_PROD,
    password: process.env.DB_PASSWORD_PROD,
    database: process.env.DB_NAME_PROD,
    host: process.env.DB_HOST_PROD,
    port: process.env.DB_PORT_PROD,
    dialect: process.env.DB_DIALECT_PROD,
    dialectOptions: {
      // ssl: {
      //   require: true,
      //   rejectUnauthorized: false // Adjust as per your SSL certificate setup
      // }
    },
    // logging: false, // Disable logging in production if desired
  }
};

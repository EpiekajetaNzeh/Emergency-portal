const express = require('express');
const dotenv = require('dotenv');
const cors = require('cors');
const db = require('./models'); // Sequelize models

// Load env vars
dotenv.config({ path: './config/config.env' });

const app = express();

// Body parser
app.use(express.json());

// Enable CORS
app.use(cors());

// Test Route
app.get('/', (req, res) => {
  res.send('BuildifyHub Backend Running');
});

// API routes
const authRoutes = require('./routes/auth');
// const materialRoutes = require('./routes/materials'); // To be added
// const orderRoutes = require('./routes/orders'); // To be added
// const profileRoutes = require('./routes/profiles'); // To be added

app.use('/api/v1/auth', authRoutes);
// app.use('/api/v1/materials', materialRoutes);
// app.use('/api/v1/orders', orderRoutes);
// app.use('/api/v1/profiles', profileRoutes);

// Error Handler Middleware (should be last piece of middleware)
const errorHandler = require('./middleware/errorHandler');
app.use(errorHandler);

const PORT = process.env.PORT || 5001; // Changed port to avoid potential conflicts

// Sync database and start server
// Consider using { force: true } or { alter: true } for development only if needed
// db.sequelize.sync({ force: process.env.NODE_ENV === 'development' }) // Example: force sync in dev
db.sequelize.sync().then(() => {
  app.listen(
    PORT,
    console.log(
      `Server running in ${process.env.NODE_ENV || 'development'} mode on port ${PORT}`
    )
  );
}).catch(err => {
  console.error('Failed to sync DB:', err);
});

// Handle unhandled promise rejections
process.on('unhandledRejection', (err, promise) => {
  console.log(`Error: ${err.message}`);
  // Close server & exit process
  // server.close(() => process.exit(1)); // Enable this for more robust error handling
});

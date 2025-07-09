const ErrorResponse = require('../utils/errorResponse');

const errorHandler = (err, req, res, next) => {
  let error = { ...err };
  error.message = err.message;

  // Log to console for dev
  console.error('ERROR STACK:', err.stack);
  console.error('ERROR MESSAGE:', err.message);


  // Sequelize Bad ObjectId (or similar validation like invalid UUID)
  if (err.name === 'SequelizeValidationError') {
    const message = Object.values(err.errors).map(val => val.message).join(', ');
    error = new ErrorResponse(message, 400);
  }

  // Sequelize Unique Constraint Error
  if (err.name === 'SequelizeUniqueConstraintError') {
    // Attempt to make the message more user-friendly if possible
    // Example: if err.fields is { email: 'some@email.com' }, message could be "Email 'some@email.com' is already registered."
    // This requires knowing the structure of err.fields and err.errors.
    let message = 'Duplicate field value entered. ';
    if(err.errors && err.errors.length > 0) {
        message += err.errors.map(e => `${e.path} '${e.value}' already exists.`).join(', ');
    } else {
        message = "A unique field value you entered already exists."
    }
    error = new ErrorResponse(message, 400);
  }

  // Sequelize Database Error (e.g. column does not exist, etc)
  if (err.name === 'SequelizeDatabaseError') {
    const message = process.env.NODE_ENV === 'production' ? 'Database error' : err.message;
    error = new ErrorResponse(message, 500);
  }

  // JWT Errors
  if (err.name === 'JsonWebTokenError') {
    const message = 'Invalid token';
    error = new ErrorResponse(message, 401);
  }
  if (err.name === 'TokenExpiredError') {
    const message = 'Token has expired';
    error = new ErrorResponse(message, 401);
  }


  res.status(error.statusCode || 500).json({
    success: false,
    error: error.message || 'Server Error',
  });
};

module.exports = errorHandler;

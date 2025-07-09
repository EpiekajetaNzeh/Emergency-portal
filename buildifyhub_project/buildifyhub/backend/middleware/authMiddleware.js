const jwt = require('jsonwebtoken');
const { User } = require('../models'); // Assuming User model is exported from db object in models/index.js
const asyncHandler = require('./asyncHandler'); // We'll create this utility next

// Protect routes
exports.protect = asyncHandler(async (req, res, next) => {
  let token;

  // Check for token in Authorization header (Bearer token)
  if (
    req.headers.authorization &&
    req.headers.authorization.startsWith('Bearer')
  ) {
    token = req.headers.authorization.split(' ')[1];
  }
  // Alternatively, check for token in cookies (if you choose to use cookies)
  // else if (req.cookies.token) {
  //   token = req.cookies.token;
  // }

  if (!token) {
    res.status(401);
    throw new Error('Not authorized, no token');
  }

  try {
    // Verify token
    const decoded = jwt.verify(token, process.env.JWT_SECRET);

    // Get user from the token
    req.user = await User.findByPk(decoded.id, {
      attributes: { exclude: ['password'] } // Don't return password
    });

    if (!req.user) {
        res.status(401);
        throw new Error('Not authorized, user not found');
    }

    next();
  } catch (error) {
    console.error(error);
    res.status(401);
    throw new Error('Not authorized, token failed');
  }
});

// Grant access to specific roles (example, not used in current auth routes directly but useful for other resources)
exports.authorize = (...roles) => {
  return (req, res, next) => {
    // req.user should be available from the 'protect' middleware
    if (!req.user || !roles.includes(req.user.isSupplier ? 'supplier' : 'builder')) {
        // Example role check: isSupplier true maps to 'supplier' role.
        // You might have a more explicit role field in your User model.
      res.status(403); // Forbidden
      throw new Error(
        `User role '${req.user.isSupplier ? 'supplier' : 'builder'}' is not authorized to access this route`
      );
    }
    next();
  };
};

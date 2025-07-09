const { User, Profile } = require('../models'); // Assuming User and Profile models are from db object
const asyncHandler = require('../middleware/asyncHandler');
const jwt = require('jsonwebtoken');
const ErrorResponse = require('../utils/errorResponse'); // We'll create this utility

// Generate JWT
const generateToken = (id) => {
  return jwt.sign({ id }, process.env.JWT_SECRET, {
    expiresIn: process.env.JWT_EXPIRE || '30d',
  });
};

// @desc    Register a new user
// @route   POST /api/v1/auth/register
// @access  Public
exports.registerUser = asyncHandler(async (req, res, next) => {
  const { username, email, password, isSupplier, profileData } = req.body;

  if (!username || !email || !password) {
    return next(new ErrorResponse('Please provide username, email, and password', 400));
  }

  // Check if user already exists
  const existingUser = await User.findOne({ where: { email } });
  if (existingUser) {
    return next(new ErrorResponse('User with this email already exists', 400));
  }
  const existingUsername = await User.findOne({ where: { username } });
  if (existingUsername) {
    return next(new ErrorResponse('Username already taken', 400));
  }

  // Create user (password will be hashed by the model hook)
  const user = await User.create({
    username,
    email,
    password,
    isSupplier: isSupplier || false,
  });

  // Create associated profile
  if (user) {
    await Profile.create({
      userId: user.id,
      companyName: profileData?.companyName,
      phoneNumber: profileData?.phoneNumber,
      address: profileData?.address,
      projectInterests: !user.isSupplier ? profileData?.projectInterests : null,
      materialSpecializations: user.isSupplier ? profileData?.materialSpecializations : null,
      bio: profileData?.bio
    });
  } else {
    return next(new ErrorResponse('User could not be created', 500));
  }

  // Get user with profile to send back
  const userWithProfile = await User.findByPk(user.id, { include: ['profile']});

  // Generate token and send response
  const token = generateToken(user.id);
  sendTokenResponse(userWithProfile, 201, res, token);
});

// @desc    Login user
// @route   POST /api/v1/auth/login
// @access  Public
exports.loginUser = asyncHandler(async (req, res, next) => {
  const { email, password } = req.body;

  // Validate email & password
  if (!email || !password) {
    return next(new ErrorResponse('Please provide an email and password', 400));
  }

  // Check for user
  const user = await User.findOne({ where: { email } });

  if (!user) {
    return next(new ErrorResponse('Invalid credentials', 401));
  }

  // Check if password matches
  const isMatch = await user.validPassword(password); // validPassword method from User model

  if (!isMatch) {
    return next(new ErrorResponse('Invalid credentials', 401));
  }

  // Get user with profile to send back
  const userWithProfile = await User.findByPk(user.id, { include: ['profile']});

  // Generate token and send response
  const token = generateToken(user.id);
  sendTokenResponse(userWithProfile, 200, res, token);
});

// @desc    Get current logged-in user
// @route   GET /api/v1/auth/me
// @access  Private
exports.getCurrentUser = asyncHandler(async (req, res, next) => {
  // req.user is set by the 'protect' middleware
  const user = await User.findByPk(req.user.id, {
    include: ['profile'] // Include profile data
  });

  if (!user) {
    return next(new ErrorResponse('User not found', 404));
  }

  res.status(200).json({
    success: true,
    data: user,
  });
});


// Helper to send token response (can be with cookie or as JSON)
const sendTokenResponse = (user, statusCode, res, token) => {
  // Create cookie if you want to send token in cookie
  const options = {
    expires: new Date(
      Date.now() + (parseInt(process.env.JWT_COOKIE_EXPIRE_DAYS) || 30) * 24 * 60 * 60 * 1000
    ),
    httpOnly: true, // Cookie cannot be accessed by client-side scripts
  };

  if (process.env.NODE_ENV === 'production') {
    options.secure = true; // Only send cookie over HTTPS in production
  }

  // Remove password from output if it wasn't excluded by query
  const userOutput = { ...user.get({ plain: true }) };
  delete userOutput.password;


  res
    .status(statusCode)
    // .cookie('token', token, options) // Uncomment if using cookies for token transfer
    .json({
      success: true,
      token, // Send token in response body as well/instead
      data: userOutput,
    });
};

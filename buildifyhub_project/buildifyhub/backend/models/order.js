'use strict';
const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class Order extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
      Order.belongsTo(models.User, { foreignKey: 'builderId', as: 'builder' });
      Order.hasMany(models.OrderItem, { foreignKey: 'orderId', as: 'orderItems', onDelete: 'CASCADE' });
    }
  }
  Order.init({
    builderId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'Users', // Name of the table
        key: 'id'
      },
      onUpdate: 'CASCADE',
      // onDelete: 'SET NULL' // Or 'RESTRICT' depending on business logic for user deletion
    },
    totalAmount: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: false,
      validate: {
        isDecimal: true,
        min: 0
      }
    },
    status: {
      type: DataTypes.ENUM('Pending', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled', 'Refunded'),
      defaultValue: 'Pending'
    },
    shippingAddress: {
      type: DataTypes.TEXT,
      allowNull: true // Could be required depending on order type
    },
    billingAddress: {
      type: DataTypes.TEXT,
      allowNull: true // Could be same as shipping or different
    },
    paymentMethod: {
      type: DataTypes.STRING,
      allowNull: true // e.g., 'Credit Card', 'Bank Transfer', 'COD'
    },
    paymentStatus: {
      type: DataTypes.ENUM('Pending', 'Paid', 'Failed', 'Refunded'),
      defaultValue: 'Pending'
    },
    notes: { // Any special instructions from the builder
        type: DataTypes.TEXT,
        allowNull: true
    }
    // Timestamps (createdAt, updatedAt) are handled by Sequelize by default
  }, {
    sequelize,
    modelName: 'Order',
  });
  return Order;
};

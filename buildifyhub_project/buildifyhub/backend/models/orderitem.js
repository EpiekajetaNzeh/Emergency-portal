'use strict';
const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class OrderItem extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
      OrderItem.belongsTo(models.Order, { foreignKey: 'orderId', as: 'order' });
      OrderItem.belongsTo(models.Material, { foreignKey: 'materialId', as: 'material' });
    }
  }
  OrderItem.init({
    orderId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'Orders', // Name of the table
        key: 'id'
      },
      onUpdate: 'CASCADE',
      onDelete: 'CASCADE' // If an order is deleted, its items are deleted
    },
    materialId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'Materials', // Name of the table
        key: 'id'
      },
      onUpdate: 'CASCADE',
      // onDelete: 'RESTRICT' // Prevent material deletion if it's part of an order item, or 'SET NULL'
    },
    quantity: {
      type: DataTypes.INTEGER,
      allowNull: false,
      validate: {
        isInt: true,
        min: 1 // Must order at least one item
      }
    },
    priceAtOrder: { // Price of the material at the time the order was placed
      type: DataTypes.DECIMAL(10, 2),
      allowNull: false,
      validate: {
        isDecimal: true,
        min: 0
      }
    },
    unitAtOrder: { // Unit of the material at the time of order (e.g. 'kg', 'piece')
        type: DataTypes.STRING,
        allowNull: true
    }
    // Timestamps are handled by Sequelize by default
  }, {
    sequelize,
    modelName: 'OrderItem',
  });
  return OrderItem;
};

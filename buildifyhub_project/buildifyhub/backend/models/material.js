'use strict';
const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class Material extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
      Material.belongsTo(models.User, { foreignKey: 'supplierId', as: 'supplier' });
      Material.hasMany(models.OrderItem, { foreignKey: 'materialId', as: 'orderItems' });
    }
  }
  Material.init({
    supplierId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'Users', // Name of the table
        key: 'id'
      },
      onUpdate: 'CASCADE',
      // onDelete: 'CASCADE' // Or 'SET NULL' if materials can exist without a supplier temporarily
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false
    },
    description: {
      type: DataTypes.TEXT,
      allowNull: true
    },
    price: {
      type: DataTypes.DECIMAL(10, 2), // Precision 10, scale 2 for currency
      allowNull: false,
      validate: {
        isDecimal: true,
        min: 0
      }
    },
    quantity: {
      type: DataTypes.INTEGER,
      allowNull: false,
      validate: {
        isInt: true,
        min: 0
      }
    },
    unit: { // e.g., 'kg', 'piece', 'meter', 'sqm'
      type: DataTypes.STRING,
      allowNull: true,
      defaultValue: 'piece'
    },
    category: { // e.g., 'Cement', 'Bricks', 'Steel', 'Wood'
        type: DataTypes.STRING,
        allowNull: true
    },
    imageUrl: {
      type: DataTypes.STRING,
      allowNull: true,
      validate: {
        isUrl: true // if storing URLs, otherwise can be path string
      }
    },
    // Additional fields like dimensions, grade, brand, etc. can be added
    // brand: DataTypes.STRING,
    // grade: DataTypes.STRING,
    // dimensions: DataTypes.STRING, // e.g., "20x10x5 cm"
    availabilityStatus: {
        type: DataTypes.ENUM('In Stock', 'Out of Stock', 'Available on Order'),
        defaultValue: 'In Stock'
    }
  }, {
    sequelize,
    modelName: 'Material',
  });
  return Material;
};

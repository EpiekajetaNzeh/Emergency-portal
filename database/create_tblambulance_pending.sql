CREATE TABLE tblambulance_pending (
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    AmbulanceType VARCHAR(50) NOT NULL,
    AmbRegNum VARCHAR(50) NOT NULL,
    DriverName VARCHAR(100) NOT NULL,
    DriverContactNumber VARCHAR(15) NOT NULL,
    OwnerName VARCHAR(100) NOT NULL,
    OwnerContact VARCHAR(15) NOT NULL,
    AuthDocument VARCHAR(255),
    Status VARCHAR(20) DEFAULT 'pending',
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

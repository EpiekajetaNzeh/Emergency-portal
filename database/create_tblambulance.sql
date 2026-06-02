-- Table structure for table `tblambulance`
CREATE TABLE IF NOT EXISTS `tblambulance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AmbulanceType` varchar(250) DEFAULT NULL,
  `AmbRegNum` varchar(250) DEFAULT NULL,
  `DriverName` varchar(250) DEFAULT NULL,
  `DriverContactNumber` bigint(20) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` varchar(250) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

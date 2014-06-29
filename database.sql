/*
MySQL Data Transfer
Source Host: localhost
Source Database: hotel
Target Host: localhost
Target Database: hotel
Date: 6/29/2014 2:01:35 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for requests
-- ----------------------------
CREATE TABLE `requests` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `room_number` int(255) DEFAULT NULL,
  `requested_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `comments` blob,
  `duration` int(255) DEFAULT NULL,
  `amount_due` int(255) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_bin DEFAULT 'pending',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
CREATE TABLE `rooms` (
  `r_number` int(255) NOT NULL,
  `r_contents` blob,
  `r_additional_text` blob,
  `status` varchar(255) COLLATE utf8_bin DEFAULT 'available',
  `owner` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `owner_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `price` int(255) DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`r_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `rooms` VALUES ('19', 0x5075742066656174757265732068657265, 0x4920776F6E27742074616C6B2061626F7574207468697320726F6F6D2C206974277320616D617A696E6720696E203C623E616C6C206C616E6775616765733C2F623E3C62723E0D0A49276C6C2074656C6C20796F75206D6F7265206C617465722E, 'taken', 'GiovanniMounir@gmail.com', 'Giovanni Mounir', '', '150', '2014-07-01 13:34:21');
INSERT INTO `rooms` VALUES ('29', 0x5468697320697320746865206265737420726F6F6D20796F752077696C6C206576657220676574, 0x4E6F2070726F6D697365732074686F7567682E, 'taken', 'GiovanniMounir@gmail.com', 'Giovanni Mounir', '', '15', '2014-05-01 13:34:35');

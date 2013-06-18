
--
-- Lookup table for a given postcode
--
CREATE TABLE `civicrm_regionlookup` (
  `postcode` varchar(12) NOT NULL DEFAULT '',
  `district` varchar(127) NOT NULL DEFAULT '',
  `borough` varchar(127) NOT NULL DEFAULT '',
  `city` varchar(127) NOT NULL DEFAULT '',
  `county` varchar(127) NOT NULL DEFAULT '',
  `state` varchar(127) NOT NULL DEFAULT '',
  `country` varchar(127) NOT NULL DEFAULT '',
  `state_riding` varchar(127) NOT NULL DEFAULT '',
  `country_riding` varchar(127) NOT NULL DEFAULT '',
  PRIMARY KEY (`postcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


-- add ID as first primary field

ALTER TABLE civicrm_regionlookup
DROP primary key,
ADD COLUMN `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
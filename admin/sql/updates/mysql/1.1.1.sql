ALTER TABLE `#__ddcbookit_apartment_prices` ADD `apartment_id` INT(11) NULL DEFAULT NULL AFTER `category`, ADD INDEX (`apartment_id`) ;
ALTER TABLE `#__ddcbookit_apartment_prices` ADD `min_days` INT(3) NULL DEFAULT NULL AFTER `apartment_id`, ADD INDEX (`min_days`) ;

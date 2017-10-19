USE `dentists_dsusa_site`;
CREATE OR REPLACE VIEW `user_count_and_city_population` AS
SELECT COUNT(*) AS `user_total`, SUM(`d`.`population`)
FROM `user_company_info` AS `u`
LEFT JOIN`data_locations` AS `d` ON (
`u`.`city` = `d`.`city_name` AND `u`.`state` = `d`.`state_abbr`
) GROUP BY `u`.`state`,`u`.`city`


/* get user_count totals */
USE `dentists_dsusa_site`;
SELECT COUNT(*) AS `user_count`, `u`.`city`, `u`.`state`
FROM `user_company_info` AS `u`
GROUP BY `u`.`state`, `u`.`city`


/* get city_population totals */
USE `dentists_dsusa_site`;
SELECT SUM(`d`.`population`) AS `city_population`, `d`.`city_name`, `d`.`state_abbr`
FROM `data_locations` AS `d`
GROUP BY `d`.`state_abbr`, `d`.`city_name`
RENAME TABLE `appt` TO `temp_appt`;

RENAME TABLE `charges` TO `temp_charges`;

RENAME TABLE `client` TO `temp_client`;

RENAME TABLE `ech` TO `temp_ech`;

RENAME TABLE `echeance` TO `temp_echeance`;

RENAME TABLE `etage` TO `temp_etage`;

RENAME TABLE `gallery` TO `temp_gallery`;

RENAME TABLE `homeetage` TO `temp_homeetage`;

RENAME TABLE `parking` TO `temp_parking`;

RENAME TABLE `residence` TO `temp_residence`;

RENAME TABLE `users` TO `temp_users`;

CREATE TABLE `crm_residences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nfoncier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emplacemnt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npermis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detailMunicipal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `crm_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `crm_users_email_unique` (`email`)
);

CREATE TABLE `crm_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int DEFAULT NULL,
  `date_res` date DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `crm_etages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_id` bigint unsigned NOT NULL,
  `plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hplan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wplan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_etages_residence_id_foreign` (`residence_id`),
  CONSTRAINT `crm_etages_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `crm_residences` (`id`)
);

CREATE TABLE `crm_apparts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etage_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `type` int DEFAULT NULL,
  `surface` double(8, 2) DEFAULT NULL,
  `price` double(8, 2) DEFAULT NULL,
  `x` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `y` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bs` int DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_apparts_etage_id_foreign` (`etage_id`),
  CONSTRAINT `crm_apparts_etage_id_foreign` FOREIGN KEY (`etage_id`) REFERENCES `crm_etages` (`id`)
);

CREATE TABLE `crm_celliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `residence_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_celliers_residence_id_foreign` (`residence_id`),
  CONSTRAINT `crm_celliers_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `crm_residences` (`id`)
);

CREATE TABLE `crm_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sonede` double(8, 2) DEFAULT NULL,
  `syndic` double(8, 2) DEFAULT NULL,
  `avocat` double(8, 2) DEFAULT NULL,
  `contrat` double(8, 2) DEFAULT NULL,
  `foncier` double(8, 2) DEFAULT NULL,
  `appart_id` bigint unsigned NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_charges_appart_id_foreign` (`appart_id`),
  CONSTRAINT `crm_charges_appart_id_foreign` FOREIGN KEY (`appart_id`) REFERENCES `crm_apparts` (`id`) ON DELETE CASCADE
);

CREATE TABLE `crm_echances` (
  `id` bigint unsigned NOT NULL,
  `appart_id` bigint unsigned NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `date` date NULL,
  `date_avance` date NOT NULL,
  `amount_avance` double(8, 2) NOT NULL,
  `preuve_avance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promesse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_promesse_livre` date DEFAULT NULL,
  `date_promesse_legal` date DEFAULT NULL,
  `contrat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_contrat_livre` date DEFAULT NULL,
  `date_contrat_enregistre` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `crm_echances_appart_id_foreign` FOREIGN KEY (`appart_id`) REFERENCES `crm_apparts` (`id`) ON DELETE CASCADE
);

CREATE TABLE `crm_echeances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `echance_id` bigint unsigned NOT NULL,
  `date` date NULL,
  `montant` double(8, 2) NOT NULL,
  `payed` tinyint(1) NOT NULL,
  `modalite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `crm_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `residence_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `crm_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence_id` bigint unsigned DEFAULT NULL,
  `appart_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `crm_parkings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `residence_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_parkings_residence_id_foreign` (`residence_id`),
  CONSTRAINT `crm_parkings_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `crm_residences` (`id`)
);

INSERT INTO
  `crm_users` (`name`, `email`, `password`)
SELECT
  `nom` as `name`,
  `email`,
  '$2y$10$1ZDSZAk56FGUczKRCzcKIOVeTqJSCvuVSZbtNpUZcVzc53nVsLc8a' as `password`
FROM
  `temp_users`;

INSERT INTO
  `crm_clients` (
    `name`,
    `lastName`,
    `phone`,
    `cin`,
    `email`,
    `type`,
    `comments`
  )
SELECT
  `nom`,
  `prenom`,
  `tel`,
  `cin`,
  `adresse`,
  CASE
    WHEN `plus` = 'Client' THEN 0
    WHEN `plus` = 'Prospect' THEN 1
  END AS `type`,
  `observation`
FROM
  `temp_client`;

INSERT INTO
  `crm_residences` (`name`)
SELECT
  `nom`
FROM
  `temp_residence`;

INSERT INTO
  `crm_etages` (
    `name`,
    `residence_id`,
    `plan`,
    `hplan`,
    `wplan`
  )
SELECT
  `temp_etage`.`nom`,
  `temp_etage`.`res`,
  `temp_etage`.`photo`,
  SUBSTRING_INDEX(`temp_homeetage`.`y_pos`, 'px', 1) AS `y_pos`,
  SUBSTRING_INDEX(`temp_homeetage`.`x_pos`, 'px', 1) AS `x_pos`
FROM
  `temp_etage`
  JOIN `temp_homeetage` ON `temp_etage`.`id` = `temp_homeetage`.`id`;

INSERT INTO
  `crm_apparts` (
    `name`,
    `etage_id`,
    `client_id`,
    `type`,
    `surface`,
    `price`,
    `x`,
    `y`,
    `bs`,
    `comments`
  )
SELECT
  `temp_appt`.`id` AS `name`,
  (
    SELECT
      `id`
    FROM
      `crm_etages`
    WHERE
      `name` = `temp_appt`.`etage`
      AND `residence_id` = `temp_appt`.`res`
    LIMIT
      1
  ) AS `etage_id`,
  `temp_appt`.`idclient` AS `client_id`,
  CASE
    WHEN `temp_appt`.`type` = 'Commerce' THEN 0
    WHEN `temp_appt`.`type` = 'Duplex' THEN 1
    WHEN `temp_appt`.`type` = 'Duplex-1' THEN 2
    WHEN `temp_appt`.`type` = 'S+1' THEN 3
    WHEN `temp_appt`.`type` = 'S+2' THEN 4
    WHEN `temp_appt`.`type` = 'S+3' THEN 0
  END AS `type`,
  CAST(
    NULLIF(`temp_appt`.`surface`, '') AS DECIMAL(8, 2)
  ) AS `surface`,
  CAST(NULLIF(`temp_appt`.`prix`, '') AS DECIMAL(8, 2)) AS `price`,
  (
    CAST(
      NULLIF(
        NULLIF(REPLACE(`temp_appt`.`x_pos`, 'px', ''), ''),
        '-'
      ) AS DECIMAL(8, 4)
    ) * 100 / `crm_etages`.`wplan`
  ) AS `x`,
  (
    CAST(
      NULLIF(
        NULLIF(REPLACE(`temp_appt`.`y_pos`, 'px', ''), ''),
        '-'
      ) AS DECIMAL(8, 4)
    ) * 100 / `crm_etages`.`wplan`
  ) AS `y`,
  CASE
    WHEN `temp_appt`.`etat` = 'A vendre' THEN 0
    WHEN `temp_appt`.`etat` = 'reserve' THEN 2
    WHEN `temp_appt`.`etat` = 'vendu' THEN 3
    WHEN `temp_appt`.`etat` = 'Loue' THEN 1
  END AS `bs`,
  `temp_appt`.`plus` AS `comments`
FROM
  `temp_appt`
  JOIN `crm_etages` ON `temp_appt`.`etage` = `crm_etages`.`name`
  AND `temp_appt`.`res` = `crm_etages`.`residence_id`;

INSERT INTO
  `crm_celliers` (`name`, `client_id`, `residence_id`)
SELECT
  `celier`,
  (
    SELECT
      `idclient`
    FROM
      `temp_appt`
    WHERE
      `temp_parking`.`id` = `temp_appt`.`id`
      AND `idclient` IS NOT NULL AND `idclient` != ''
    LIMIT
      1
  ), (
    SELECT
      `res`
    FROM
      `temp_appt`
    WHERE
      `temp_parking`.`id` = `temp_appt`.`id`
    LIMIT
      1
  )
FROM
  `temp_parking`
WHERE
  `celier` IS NOT NULL
  AND `celier` != '';

INSERT INTO
  `crm_parkings` (
    `name`,
    `number`,
    `client_id`,
    `residence_id`
  )
SELECT
  `placeparking`,
  `emplacementparking`,
  (
    SELECT
      `idclient`
    FROM
      `temp_appt`
    WHERE
      `temp_parking`.`id` = `temp_appt`.`id`
      AND `idclient` IS NOT NULL AND `idclient` != ''
    LIMIT
      1
  ), (
    SELECT
      `res`
    FROM
      `temp_appt`
    WHERE
      `temp_parking`.`id` = `temp_appt`.`id`
    LIMIT
      1
  )
FROM
  `temp_parking`
WHERE
  `celier` IS NULL
  OR `celier` != '';
INSERT INTO
  `crm_charges` (
    `sonede`,
    `syndic`,
    `contrat`,
    `foncier`,
    `appart_id`,
    `client_id`
  )
SELECT
  CAST(
    NULLIF(
      NULLIF(`gaz`, ''),
      '-'
    ) AS DECIMAL(8, 2)
  ),
  CAST(
    NULLIF(
      NULLIF(`syndic`, ''),
      '-'
    ) AS DECIMAL(8, 2)
  ),
  CAST(
    NULLIF(
      NULLIF(`contrat`, ''),
      '-'
    ) AS DECIMAL(8, 2)
  ),
  CAST(
    NULLIF(
      NULLIF(`promesse`, ''),
      '-'
    ) AS DECIMAL(8, 2)
  ),
  (
    SELECT `crm_apparts`.`id`
    FROM `crm_apparts`
    JOIN `crm_etages` ON `crm_apparts`.`etage_id` = `crm_etages`.`id`
    WHERE `crm_apparts`.`name` = `temp_charges`.`appt`
      AND `crm_etages`.`residence_id` = `temp_charges`.`res`
    LIMIT 1
  ),
  (
    SELECT `id`
    FROM `crm_clients`
    WHERE CONCAT(CONCAT(`crm_clients`.`name`, ' '), `crm_clients`.`lastName`) = `temp_charges`.`client`
    LIMIT 1
  )
FROM
  `temp_charges`;

INSERT INTO
  `crm_echances` (
    `id`,
    `appart_id`,
    `client_id`,
    `date_avance`,
    `amount_avance`,
    `promesse`,
    `contrat`
  )
SELECT
  `temp_echeance`.`id`,
  (
    SELECT `crm_apparts`.`id`
    FROM `crm_apparts`
    JOIN `crm_etages` ON `crm_apparts`.`etage_id` = `crm_etages`.`id`
    WHERE `crm_apparts`.`name` = `temp_echeance`.`appt`
      AND `crm_etages`.`residence_id` = `temp_echeance`.`res`
    LIMIT 1
  ),
  (
    SELECT `id`
    FROM `crm_clients`
    WHERE CONCAT(CONCAT(`crm_clients`.`name`, ' '), `crm_clients`.`lastName`) = `temp_echeance`.`client`
    LIMIT 1
  ),
  CASE
    WHEN `temp_echeance`.`dateav` IS NOT NULL AND `temp_echeance`.`dateav` != '' THEN
      STR_TO_DATE(`temp_echeance`.`dateav`, '%Y-%m-%d')
    ELSE
      CURDATE()
  END AS `date_avance`,
  `avance`,
  `promesse`,
  `contrat`
FROM
  `temp_echeance`;


INSERT INTO `crm_echeances` (`echance_id`, `date`, `montant`, `payed`, `modalite`)
SELECT `idech`, NULLIF(`dateech`,''), `montant`, CASE WHEN `statut` = 'paye' THEN 1 ELSE 0 END AS `payed` , `modalite`
FROM `temp_ech`;

INSERT INTO
  `crm_images` (`path`, `residence_id`)
SELECT
  `image`,
  `gallery`
FROM
  `temp_gallery`;

RENAME TABLE `temp_appt` TO `old_appt`;

RENAME TABLE `temp_charges` TO `old_charges`;

RENAME TABLE `temp_client` TO `old_client`;

RENAME TABLE `temp_ech` TO `old_ech`;

RENAME TABLE `temp_echeance` TO `old_echeance`;

RENAME TABLE `temp_etage` TO `old_etage`;

RENAME TABLE `temp_gallery` TO `old_gallery`;

RENAME TABLE `temp_homeetage` TO `old_homeetage`;

RENAME TABLE `temp_parking` TO `old_parking`;

RENAME TABLE `temp_residence` TO `old_residence`;

RENAME TABLE `temp_users` TO `old_users`;

ALTER TABLE `crm_echances`
ADD CONSTRAINT `crm_echances_appart_id_foreign_ff`
FOREIGN KEY (`appart_id`) 
REFERENCES `crm_apparts`(`id`);

ALTER TABLE `crm_echeances`
ADD CONSTRAINT `crm_echeances_echance_id_foreign`
FOREIGN KEY (`echance_id`)
REFERENCES `crm_echances`(`id`)
ON DELETE CASCADE;
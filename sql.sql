/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : talent

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 24/10/2022 04:23:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for competency
-- ----------------------------
DROP TABLE IF EXISTS `competency`;
CREATE TABLE `competency`  (
  `competency_id` int(11) NOT NULL AUTO_INCREMENT,
  `competency_code` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `competency_desc` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `competency_score` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`competency_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of competency
-- ----------------------------
INSERT INTO `competency` VALUES (1, 'IA', 'IA', 3);
INSERT INTO `competency` VALUES (2, 'BSI', 'BSI', 3);
INSERT INTO `competency` VALUES (3, 'WS', 'WS', 3);
INSERT INTO `competency` VALUES (4, 'BPWR', 'BPWR', 3);
INSERT INTO `competency` VALUES (5, 'GC', 'GC', 3);
INSERT INTO `competency` VALUES (6, 'BP', 'BP', 3);
INSERT INTO `competency` VALUES (7, 'CF', 'CF', 3);
INSERT INTO `competency` VALUES (8, 'DM', 'DM', 3);
INSERT INTO `competency` VALUES (9, 'PO', 'PO', 3);
INSERT INTO `competency` VALUES (10, 'DO', 'DO', 3);
INSERT INTO `competency` VALUES (11, 'FC', 'FC', 3);
INSERT INTO `competency` VALUES (12, 'IM', 'IM', 3);

-- ----------------------------
-- Table structure for competency_detail
-- ----------------------------
DROP TABLE IF EXISTS `competency_detail`;
CREATE TABLE `competency_detail`  (
  `competency_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `competency_result_id` int(11) NULL DEFAULT NULL,
  `competency_id` int(11) NULL DEFAULT NULL,
  `competency_result` int(11) NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`competency_detail_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of competency_detail
-- ----------------------------
INSERT INTO `competency_detail` VALUES (1, 1, 1, 2, NULL, '2022-10-23 21:45:40');
INSERT INTO `competency_detail` VALUES (2, 1, 2, 2, NULL, '2022-10-23 21:45:40');
INSERT INTO `competency_detail` VALUES (3, 1, 3, 2, NULL, '2022-10-23 21:45:41');
INSERT INTO `competency_detail` VALUES (4, 1, 4, 2, NULL, '2022-10-23 21:45:42');
INSERT INTO `competency_detail` VALUES (5, 1, 5, 2, NULL, '2022-10-23 21:45:42');
INSERT INTO `competency_detail` VALUES (6, 1, 6, 2, NULL, '2022-10-23 21:45:43');
INSERT INTO `competency_detail` VALUES (7, 1, 7, 2, NULL, '2022-10-23 21:45:45');
INSERT INTO `competency_detail` VALUES (8, 1, 8, 2, NULL, '2022-10-23 21:45:44');
INSERT INTO `competency_detail` VALUES (9, 1, 9, 2, NULL, '2022-10-23 21:45:46');
INSERT INTO `competency_detail` VALUES (10, 1, 10, 2, NULL, '2022-10-23 21:45:47');
INSERT INTO `competency_detail` VALUES (11, 2, 1, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (12, 2, 2, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (13, 2, 3, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (14, 2, 4, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (15, 2, 5, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (16, 2, 6, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (17, 2, 7, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (18, 2, 8, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (19, 2, 9, 3, NULL, NULL);
INSERT INTO `competency_detail` VALUES (20, 2, 10, 3, NULL, NULL);

-- ----------------------------
-- Table structure for competency_result
-- ----------------------------
DROP TABLE IF EXISTS `competency_result`;
CREATE TABLE `competency_result`  (
  `competency_result_id` int(11) NOT NULL AUTO_INCREMENT,
  `competency_date` date NULL DEFAULT NULL,
  `employee_id` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `competency_status` int(11) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`competency_result_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of competency_result
-- ----------------------------
INSERT INTO `competency_result` VALUES (1, '2022-10-23', 'abcdefghi1', 0, 1, '2022-10-23 06:31:07', NULL, '2022-10-23 06:32:14', NULL);
INSERT INTO `competency_result` VALUES (2, '2022-10-23', 'abcdefghi1', 1, 1, '2022-10-23 06:32:14', NULL, '2022-10-23 06:32:14', NULL);

-- ----------------------------
-- Table structure for competency_role
-- ----------------------------
DROP TABLE IF EXISTS `competency_role`;
CREATE TABLE `competency_role`  (
  `competency_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NULL DEFAULT NULL,
  `competency_id` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`competency_role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 160 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of competency_role
-- ----------------------------
INSERT INTO `competency_role` VALUES (1, 1, '1');
INSERT INTO `competency_role` VALUES (2, 1, '2');
INSERT INTO `competency_role` VALUES (3, 1, '3');
INSERT INTO `competency_role` VALUES (4, 1, '4');
INSERT INTO `competency_role` VALUES (5, 1, '5');
INSERT INTO `competency_role` VALUES (6, 1, '6');
INSERT INTO `competency_role` VALUES (7, 1, '7');
INSERT INTO `competency_role` VALUES (8, 1, '8');
INSERT INTO `competency_role` VALUES (9, 1, '9');
INSERT INTO `competency_role` VALUES (10, 1, '10');
INSERT INTO `competency_role` VALUES (148, 2, '1');
INSERT INTO `competency_role` VALUES (149, 2, '2');
INSERT INTO `competency_role` VALUES (150, 2, '3');
INSERT INTO `competency_role` VALUES (151, 2, '4');
INSERT INTO `competency_role` VALUES (152, 2, '5');
INSERT INTO `competency_role` VALUES (153, 2, '6');
INSERT INTO `competency_role` VALUES (154, 2, '7');
INSERT INTO `competency_role` VALUES (155, 2, '8');
INSERT INTO `competency_role` VALUES (156, 2, '9');
INSERT INTO `competency_role` VALUES (157, 2, '10');
INSERT INTO `competency_role` VALUES (158, 2, '11');
INSERT INTO `competency_role` VALUES (159, 2, '12');

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `employee_id` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `employee_code` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `employee_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `position_id` int(11) NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`employee_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('8xGB23a48W', 'E-005', 'HARRY KANE', 2, NULL);
INSERT INTO `employee` VALUES ('abcdefghi1', 'E-001', 'Michael Dawson', 1, NULL);
INSERT INTO `employee` VALUES ('abcdefghi2', 'E-002', 'Toby Alderweireld', 1, NULL);
INSERT INTO `employee` VALUES ('b6eqwUEVKp', 'E-004', 'Delle Ali', 2, NULL);
INSERT INTO `employee` VALUES ('UhSNYHOKHJ', 'E-003', 'Jan Vertongen', 2, NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for performance_result
-- ----------------------------
DROP TABLE IF EXISTS `performance_result`;
CREATE TABLE `performance_result`  (
  `performance_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `performance_year` int(11) NULL DEFAULT NULL,
  `performance_result` float NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`performance_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of performance_result
-- ----------------------------
INSERT INTO `performance_result` VALUES (1, 'abcdefghi1', 2020, 105, NULL, '2022-10-21 20:08:23', NULL, '2022-10-21 20:46:19', NULL);
INSERT INTO `performance_result` VALUES (2, 'abcdefghi1', 2021, 89, NULL, '2022-10-21 20:09:11', NULL, '2022-10-21 20:46:20', NULL);
INSERT INTO `performance_result` VALUES (3, 'abcdefghi1', 2022, NULL, 1, '2022-10-21 20:09:13', NULL, '2022-10-23 06:32:14', NULL);
INSERT INTO `performance_result` VALUES (4, 'abcdefghi2', 2020, 99, NULL, '2022-10-21 20:10:02', NULL, '2022-10-21 20:46:24', NULL);
INSERT INTO `performance_result` VALUES (5, 'abcdefghi2', 2021, 100, NULL, '2022-10-21 20:10:03', NULL, '2022-10-21 20:46:25', NULL);
INSERT INTO `performance_result` VALUES (6, 'abcdefghi2', 2022, 99, NULL, '2022-10-21 20:10:06', NULL, '2022-10-21 20:46:26', NULL);
INSERT INTO `performance_result` VALUES (8, 'abcdefghi1', 2022, 200, 1, '2022-10-23 06:27:23', NULL, '2022-10-23 06:31:08', NULL);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `position_desc` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `position_score` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`position_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of position
-- ----------------------------
INSERT INTO `position` VALUES (1, 'VICE PRECIDENT', 30);
INSERT INTO `position` VALUES (2, 'MANAGER', 36);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin', NULL, '$2a$12$WwKK5FUgtI6NEuqY4l7g9OlSxdAvw3rg7d2lfNABpKymDMjAevaQW', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- View structure for view_competency_history
-- ----------------------------
DROP VIEW IF EXISTS `view_competency_history`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_competency_history` AS SELECT
  competency_result.competency_result_id,
	competency_result.competency_date,
	competency_result.employee_id,
	SUM( competency_result ) AS competency_total,
	( SUM( competency_result ) / position_score ) * 100 AS competency_percent
FROM
	competency_result
	JOIN competency_detail ON competency_result.competency_result_id = competency_detail.competency_result_id
	JOIN employee ON competency_result.employee_id = employee.employee_id
	JOIN position ON employee.position_id = position.position_id 
GROUP BY
	competency_result.competency_result_id, competency_result.employee_id ;

-- ----------------------------
-- View structure for view_competency_result
-- ----------------------------
DROP VIEW IF EXISTS `view_competency_result`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_competency_result` AS SELECT
  competency_result.competency_result_id,
	competency_result.competency_date,
	competency_result.employee_id,
	SUM( competency_result ) AS competency_total,
	( SUM( competency_result ) / position_score ) * 100 AS competency_percent
FROM
	competency_result
	JOIN competency_detail ON competency_result.competency_result_id = competency_detail.competency_result_id
	JOIN employee ON competency_result.employee_id = employee.employee_id
	JOIN position ON employee.position_id = position.position_id 
WHERE
	competency_status = 1 
GROUP BY
	competency_result.competency_result_id, competency_result.employee_id ;

-- ----------------------------
-- View structure for view_performance_result
-- ----------------------------
DROP VIEW IF EXISTS `view_performance_result`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_performance_result` AS SELECT
	employee_id,
	ROUND(
	AVG( performance_result )) AS performance_total 
FROM
	performance_result 
WHERE
	performance_year BETWEEN YEAR (
	DATE_SUB( CURDATE(), INTERVAL 2 YEAR )) 
	AND YEAR (
	CURDATE()) 
GROUP BY
	employee_id ;

SET FOREIGN_KEY_CHECKS = 1;

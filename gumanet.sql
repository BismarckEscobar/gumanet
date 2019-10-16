/*
 Navicat Premium Data Transfer

 Source Server         : wamp64
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : gumanet

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 16/10/2019 10:25:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES (1, 'UNIMARK', 0, '2019-10-11 09:08:09', '2019-10-11 09:08:13');
INSERT INTO `companies` VALUES (2, 'GUMAPHARMA', 0, '2019-10-11 09:08:28', '2019-10-11 09:08:31');
INSERT INTO `companies` VALUES (3, 'PRODUN', 0, '2019-10-11 09:08:47', '2019-10-11 09:08:53');

-- ----------------------------
-- Table structure for company_user
-- ----------------------------
DROP TABLE IF EXISTS `company_user`;
CREATE TABLE `company_user`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `company_id`) USING BTREE,
  INDEX `company_user_company_id_foreign`(`company_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of company_user
-- ----------------------------
INSERT INTO `company_user` VALUES (1, 1, 0, '2019-10-15 16:51:46', '2019-10-15 16:51:50');
INSERT INTO `company_user` VALUES (1, 3, 0, '2019-10-15 16:51:58', '2019-10-15 16:52:02');
INSERT INTO `company_user` VALUES (2, 2, 0, '2019-10-15 16:52:13', '2019-10-15 16:52:15');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_10_01_231048_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_10_10_142205_create_companies_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_10_10_212513_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_10_11_191908_create_roles_table', 2);
INSERT INTO `migrations` VALUES (6, '2019_10_15_165549_create_company_user_table', 3);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `estado` int(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador', 'Administrador de todo el sitio', 0, '2019-10-11 13:33:50', '2019-10-11 13:33:53');
INSERT INTO `roles` VALUES (2, 'General', 'visualiza vistas de inventario', 0, '2019-10-11 14:40:13', '2019-10-11 14:40:16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Ennio Javier', 'Sáenz Martinez', 'enniosaenz@gmail.com', '$2y$10$bJ3t7uU7dR28MlBmdl64mOpty2VaZdjCesUDt2qq6FFtatg8teQ7u', '1', '3', 'Administrador del sistema', 'C:\\wamp64\\tmp\\phpAAA0.tmp', 0, '7xr3W0EdffiujGhDeKBnDsw1anLzbQJ6rHJoSGi6pXuKrt7sx6FhGSe3TTTV', '2019-10-08 23:00:00', '2019-10-08 23:00:00');
INSERT INTO `users` VALUES (2, 'Norman', 'Maurie', 'admin@gmail.com', '$2y$10$TnVemqGF0QbNSoxCsdALau0kqU967ApawfKcWLHtZGCDN2jGQBfsy', '1', '1', 'Administrador del sistema', NULL, 0, 'H07KbjiWB1ijObJw8JedKGOx1qYXRNiFDFpm8syYvIrPVtaQv0aSMfdbGQew', '2019-10-11 23:37:02', '2019-10-11 23:37:02');
INSERT INTO `users` VALUES (7, 'Nombre Prueba', 'Apellido prueba', 'prueba@prueba.com', '$2y$10$ZfnVqqSav47zsJPKPoEXV.nTE1BT60o5VQW1n8nTz7OdsP4CUFHDC', '2', '2', 'nada que descrivir', NULL, 0, 'wApc679L6WP8y9xyioXhtVeJtZsyWbOhLKkhKpslKfpSdsOBd95R6ZUq37Wu', '2019-10-14 14:45:48', '2019-10-14 14:45:48');

SET FOREIGN_KEY_CHECKS = 1;

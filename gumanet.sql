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

 Date: 21/10/2019 09:57:53
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
INSERT INTO `companies` VALUES (1, 'UNIMARK', 0, '2019-10-17 16:16:28', '2019-10-17 16:16:30');
INSERT INTO `companies` VALUES (2, 'GUMAPHARMA', 0, '2019-10-17 16:16:48', '2019-10-17 16:16:52');
INSERT INTO `companies` VALUES (3, 'PRODUN', 0, '2019-10-17 16:17:39', '2019-10-17 16:17:42');

-- ----------------------------
-- Table structure for company_user
-- ----------------------------
DROP TABLE IF EXISTS `company_user`;
CREATE TABLE `company_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `company_user_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `company_user_company_id_foreign`(`company_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of company_user
-- ----------------------------
INSERT INTO `company_user` VALUES (1, 1, 1, '2019-10-18 10:03:26', '2019-10-18 10:03:28');
INSERT INTO `company_user` VALUES (2, 1, 3, '2019-10-18 10:03:35', '2019-10-18 10:03:38');
INSERT INTO `company_user` VALUES (21, 37, 1, '2019-10-18 00:00:00', '2019-10-18 00:00:00');
INSERT INTO `company_user` VALUES (22, 37, 2, '2019-10-18 00:00:00', '2019-10-18 00:00:00');
INSERT INTO `company_user` VALUES (23, 37, 3, '2019-10-18 00:00:00', '2019-10-18 00:00:00');
INSERT INTO `company_user` VALUES (27, 42, 3, '2019-10-18 12:21:19', '2019-10-18 12:21:19');
INSERT INTO `company_user` VALUES (26, 42, 1, '2019-10-18 12:21:19', '2019-10-18 12:21:19');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (6, '2019_10_01_231048_create_users_table', 1);
INSERT INTO `migrations` VALUES (7, '2019_10_10_142205_create_companies_table', 1);
INSERT INTO `migrations` VALUES (8, '2019_10_10_212513_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (9, '2019_10_11_191908_create_roles_table', 1);
INSERT INTO `migrations` VALUES (11, '2019_10_15_165549_create_company_user_table', 2);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador', 'Administrador del sitio', 0, '2019-10-17 16:15:24', '2019-10-17 16:15:26');
INSERT INTO `roles` VALUES (2, 'General', 'Acceso general', 0, '2019-10-17 16:16:01', '2019-10-17 16:16:04');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Ennio Javier', 'Sáenz Martinez', 'enniosaenz@gmail.com', '$2y$10$5Qg.awPeCqVS4ug4WH7y2eqgFXMqNF56W9D9iHbnDuS04jlTVyfKW', '1', 'Administrador del sistema', 'C:\\wamp64\\tmp\\phpAAA0.tmp', 0, 'bskX9SmJZqSAmTMXq16IifBd78i6PsaG0EVN9lDe9VRRsqxDVYkCL98rsrzb', '2019-10-08 23:00:00', '2019-10-08 23:00:00');
INSERT INTO `users` VALUES (37, 'Admin', 'admin', 'admin@admin.com', '$2y$10$q2LGPXHkSgXfcSnp8WNjveIWS655JO.6d1QPq2i8Hm6gvShkzL6Ae', '2', 'Administrador del sistema', NULL, 0, NULL, '2019-10-18 17:50:30', '2019-10-18 17:50:30');
INSERT INTO `users` VALUES (42, 'Prubea', 'prueba', 'admin@sdsdsdsddd.vom', '$2y$10$HD1tRlowqYTZzXC6eDSvH.eBDRpmvb3gAZbd3uMKIieZi2Qju9dya', '1', 'Este tema es sobre como el universo ayuda a la imaginacion humana en sus....', NULL, 0, 'wWsi9dW8bE4qz5Cma7BOXkOKn1jlBJhzhQt4Hh58vHv3CIxsYyBrgMZR8aZw', '2019-10-18 12:21:19', '2019-10-18 12:21:19');

SET FOREIGN_KEY_CHECKS = 1;

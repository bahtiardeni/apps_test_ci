/*
 Navicat Premium Data Transfer

 Source Server         : __LOCAL
 Source Server Type    : MySQL
 Source Server Version : 80100 (8.1.0)
 Source Host           : localhost:3306
 Source Schema         : apps_test

 Target Server Type    : MySQL
 Target Server Version : 80100 (8.1.0)
 File Encoding         : 65001

 Date: 12/05/2026 07:18:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for __sys_config
-- ----------------------------
DROP TABLE IF EXISTS `__sys_config`;
CREATE TABLE `__sys_config`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_object` int NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `other` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of __sys_config
-- ----------------------------
INSERT INTO `__sys_config` VALUES (1, NULL, '_config-transaction_min_date', '5', NULL, '2024-10-20 23:15:25', 1, '2024-10-20 23:15:49', 1);
INSERT INTO `__sys_config` VALUES (2, NULL, '_config-transaction_return_date', '1', NULL, '2024-10-20 23:15:25', 1, '2024-10-20 23:15:25', 1);
INSERT INTO `__sys_config` VALUES (3, NULL, '_app_version', '1.1', NULL, '2024-10-27 21:31:23', 1, '2024-10-29 21:13:25', 1);
INSERT INTO `__sys_config` VALUES (4, NULL, '_expire_time_reset', '30', NULL, '2024-10-31 11:09:31', 1, '2024-10-31 11:28:04', 1);

-- ----------------------------
-- Table structure for __sys_fields
-- ----------------------------
DROP TABLE IF EXISTS `__sys_fields`;
CREATE TABLE `__sys_fields`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_master` int NULL DEFAULT NULL,
  `id_source` int NULL DEFAULT NULL,
  `source` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `field` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `position` int NULL DEFAULT NULL,
  `form` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `datatable` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `other` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_fields_master`(`id_master` ASC) USING BTREE,
  INDEX `fk_fields_source`(`id_source` ASC) USING BTREE,
  CONSTRAINT `fk_field_master` FOREIGN KEY (`id_master`) REFERENCES `__sys_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_field_source` FOREIGN KEY (`id_source`) REFERENCES `__sys_sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2806 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of __sys_fields
-- ----------------------------
INSERT INTO `__sys_fields` VALUES (578, 53, 191, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2021-08-18 08:14:32', 1, '2024-01-02 10:57:00', 1);
INSERT INTO `__sys_fields` VALUES (579, 53, 191, 'FIELD', 'code', 'code', 'Text', 3, '{\"position\":3,\"render\":1,\"validation\":[\"required\",\"unique\"],\"label\":\"Code\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":2,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"label\":\"Code\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2021-08-18 08:14:40', 1, '2024-01-02 11:35:28', 1);
INSERT INTO `__sys_fields` VALUES (580, 53, 191, 'FIELD', 'name', 'name', 'Text', 4, '{\"position\":4,\"render\":1,\"validation\":[\"required\"],\"label\":\"Name\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"label\":\"Name\",\"width\":\"250\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2021-08-18 08:14:47', 1, '2024-01-02 11:35:28', 1);
INSERT INTO `__sys_fields` VALUES (581, 53, 191, 'FIELD', 'description', 'description', 'Textarea', 6, '{\"position\":6,\"render\":1,\"label\":\"Description\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"label\":\"Description\",\"width\":\"400\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2021-08-18 08:15:02', 1, '2024-01-02 11:35:28', 1);
INSERT INTO `__sys_fields` VALUES (582, 53, 191, 'FIELD', 'status', 'status', 'Radio Key', 7, '{\"position\":5,\"render\":1,\"validation\":[\"required\"],\"label\":\"Status\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":5,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"label\":\"Status\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":[\"Inactive\",\"Active\"]}', '2021-08-18 08:15:30', 1, '2024-01-02 11:35:28', 1);
INSERT INTO `__sys_fields` VALUES (1941, 53, 191, 'FIELD', 'id_parent', 'id_parent', 'Select Master Tree', 2, '{\"position\":\"2\",\"render\":\"1\",\"label\":\"Parent\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0,\"position\":2}', '{\"source\":{\"id\":\"447\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"code\",\"name\",\"description\"]}}', '2024-01-02 10:54:50', 1, '2024-01-02 10:57:09', 1);
INSERT INTO `__sys_fields` VALUES (1942, 53, NULL, 'METADATA', 'users', '', 'Number', 5, NULL, '{\"position\":3,\"render\":1,\"filter\":\"0\",\"sort\":\"0\",\"wrap\":\"0\",\"label\":\"Total Users\",\"width\":\"100\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-01-02 10:58:26', 1, '2024-01-02 11:35:28', 1);
INSERT INTO `__sys_fields` VALUES (2703, 175, 581, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2024-10-09 23:28:28', 1, '2024-10-31 12:11:21', 1);
INSERT INTO `__sys_fields` VALUES (2704, 175, 581, 'FIELD', 'id_role', 'id_role', 'Select Master', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Role\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Role\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"583\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\",\"description\"]}}', '2024-10-09 23:28:46', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2705, 175, 581, 'FIELD', 'division', 'division', 'Select Master', 7, '{\"render\":1,\"position\":8}', '{\"position\":8,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Satuan\\/Koordinator Kerja\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"582\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\",\"description\"]}}', '2024-10-09 23:29:07', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2706, 175, 581, 'FIELD', 'email', 'email', 'Email', 4, '{\"position\":5,\"render\":1,\"validation\":[\"required\",\"unique\"],\"label\":\"Email\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":5,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Email\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-09 23:29:16', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2707, 175, 581, 'FIELD', 'password', 'password', 'Password', 5, '{\"position\":6,\"render\":1,\"validation\":[\"required\"],\"label\":\"Password\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-09 23:29:29', 1, '2024-10-31 12:11:21', 1);
INSERT INTO `__sys_fields` VALUES (2708, 175, 581, 'FIELD', 'name', 'name', 'Text', 6, '{\"render\":1,\"position\":7}', '{\"position\":7,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-09 23:29:37', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2709, 175, 581, 'FIELD', 'position', 'position', 'Text', 8, '{\"render\":1,\"position\":9}', '{\"position\":9,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jabatan\\/Posisi\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-09 23:29:46', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2710, 175, 581, 'FIELD', 'status', 'status', 'Select List Key', 11, '{\"render\":1,\"position\":12}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Status\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"\"},\"list\":{\"0\":\"Tidak Aktif\",\"1\":\"Verifikasi User\",\"3\":\"Verifikasi Admin\",\"9\":\"Aktif\"}}', '2024-10-09 23:30:19', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2711, 175, 581, 'FIELD', 'created', 'created', 'Sysdate', 13, '{\"render\":0}', '{\"position\":10,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Registrasi\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-09 23:30:29', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2712, 175, 581, 'FIELD', 'type', 'type', 'Select List Value', 3, '{\"position\":\"3\",\"render\":\"1\",\"label\":\"Jenis Pengguna\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":2,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jenis Pengguna\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":[\"Perorangan\",\"Perusahaan\"]}', '2024-10-10 01:17:26', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2713, 176, 584, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0,\"position\":1}', '', '2024-10-10 01:47:26', 1, '2024-10-10 01:49:45', 1);
INSERT INTO `__sys_fields` VALUES (2714, 176, 584, 'FIELD', 'name', 'name', 'Text', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Satuan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Satuan\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:33', 1, '2024-10-10 02:05:18', 1);
INSERT INTO `__sys_fields` VALUES (2715, 176, 584, 'FIELD', 'created', 'created', 'Sysdate', 4, '{\"render\":0}', '{\"position\":\"3\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:42', 1, '2024-10-10 01:49:43', 1);
INSERT INTO `__sys_fields` VALUES (2716, 176, 584, 'FIELD', 'description', 'description', 'Textarea', 3, '{\"render\":1,\"position\":3}', '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Keterangan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:48:01', 1, '2024-10-10 01:49:45', 1);
INSERT INTO `__sys_fields` VALUES (2717, 177, 585, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0,\"position\":1}', '', '2024-10-10 01:47:26', 1, '2024-10-10 01:49:45', 1);
INSERT INTO `__sys_fields` VALUES (2718, 177, 585, 'FIELD', 'name', 'name', 'Text', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Kondisi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Kondisi\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:33', 1, '2024-10-10 10:33:49', 1);
INSERT INTO `__sys_fields` VALUES (2719, 177, 585, 'FIELD', 'created', 'created', 'Sysdate', 5, '{\"render\":0}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:42', 1, '2024-10-10 10:33:49', 1);
INSERT INTO `__sys_fields` VALUES (2720, 177, 585, 'FIELD', 'description', 'description', 'Textarea', 4, '{\"render\":1,\"position\":3}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Keterangan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:48:01', 1, '2024-10-10 10:33:49', 1);
INSERT INTO `__sys_fields` VALUES (2721, 178, 586, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0,\"position\":1}', '', '2024-10-10 01:47:26', 1, '2024-10-10 01:49:45', 1);
INSERT INTO `__sys_fields` VALUES (2722, 178, 586, 'FIELD', 'code', 'code', 'Text', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Kondisi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Kondisi\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"\"}}', '2024-10-10 01:47:33', 1, '2024-10-10 10:30:32', 1);
INSERT INTO `__sys_fields` VALUES (2723, 178, 586, 'FIELD', 'created', 'created', 'Sysdate', 5, '{\"render\":0}', '{\"position\":5,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:42', 1, '2024-10-10 10:30:32', 1);
INSERT INTO `__sys_fields` VALUES (2724, 178, 586, 'FIELD', 'description', 'description', 'Textarea', 4, '{\"render\":1,\"position\":3}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Keterangan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:48:01', 1, '2024-10-10 10:30:32', 1);
INSERT INTO `__sys_fields` VALUES (2725, 178, 586, 'FIELD', 'is_bibi', 'is_bibi', 'Radio Key', 6, NULL, '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Lokasi berdasarkan Bibi\",\"width\":\"50\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":[\"Tidak\",\"Ya\"]}', '2024-10-10 10:29:37', 1, '2024-10-10 10:30:32', 1);
INSERT INTO `__sys_fields` VALUES (2726, 178, NULL, 'METADATA', 'jumlah_barang', '', 'Number', 3, NULL, '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"0\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jumlah Barang\",\"width\":\"50\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 10:30:25', 1, '2024-10-10 10:30:51', 1);
INSERT INTO `__sys_fields` VALUES (2727, 177, NULL, 'METADATA', 'jumlah_barang', '', 'Number', 3, NULL, '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"0\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jumlah Barang\",\"width\":\"50\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 10:33:43', 1, '2024-10-10 10:34:04', 1);
INSERT INTO `__sys_fields` VALUES (2728, 179, 587, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0,\"position\":1}', '', '2024-10-10 01:47:26', 1, '2024-10-10 11:16:48', 1);
INSERT INTO `__sys_fields` VALUES (2729, 179, 587, 'FIELD', 'name', 'name', 'Text', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Tipe\\/Merk\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"1\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tipe\\/Merk\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:33', 1, '2024-10-10 11:16:57', 1);
INSERT INTO `__sys_fields` VALUES (2730, 179, 587, 'FIELD', 'created', 'created', 'Sysdate', 5, '{\"render\":0}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:42', 1, '2024-10-10 11:16:18', 1);
INSERT INTO `__sys_fields` VALUES (2731, 179, 587, 'FIELD', 'description', 'description', 'Textarea', 4, '{\"render\":1,\"position\":3}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Keterangan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:48:01', 1, '2024-10-10 11:16:48', 1);
INSERT INTO `__sys_fields` VALUES (2732, 180, 588, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0,\"position\":1}', '', '2024-10-10 01:47:26', 1, '2024-10-10 01:49:45', 1);
INSERT INTO `__sys_fields` VALUES (2733, 180, 588, 'FIELD', 'name', 'name', 'Text', 2, '{\"position\":\"2\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Kategori\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"1\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Kategori\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:33', 1, '2024-10-10 11:14:33', 1);
INSERT INTO `__sys_fields` VALUES (2734, 180, 588, 'FIELD', 'created', 'created', 'Sysdate', 5, '{\"render\":0}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:47:42', 1, '2024-10-10 11:13:53', 1);
INSERT INTO `__sys_fields` VALUES (2735, 180, 588, 'FIELD', 'description', 'description', 'Textarea', 4, '{\"render\":1,\"position\":3}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Keterangan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 01:48:01', 1, '2024-10-10 11:13:53', 1);
INSERT INTO `__sys_fields` VALUES (2736, 180, NULL, 'METADATA', 'jumlah_barang', '', 'Number', 3, NULL, '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"0\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jumlah Barang\",\"width\":\"50\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 11:13:46', 1, '2024-10-10 11:14:21', 1);
INSERT INTO `__sys_fields` VALUES (2737, 179, NULL, 'METADATA', 'jumlah_barang', '', 'Number', 3, '{\"render\":0}', '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"0\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jumlah Barang\",\"width\":\"50\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 11:16:10', 1, '2024-10-10 11:16:47', 1);
INSERT INTO `__sys_fields` VALUES (2738, 181, 589, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2024-10-10 11:46:15', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2739, 181, 589, 'FIELD', 'no_inventaris', 'no_inventaris', 'Text', 3, '{\"position\":3,\"render\":1,\"validation\":[\"required\",\"unique\"],\"label\":\"No Inventaris\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"input-lg\"}', '{\"position\":\"1\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"No Inventaris\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 11:46:21', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2740, 181, 589, 'FIELD', 'name', 'name', 'Text', 4, '{\"position\":4,\"render\":1,\"validation\":[\"required\"],\"label\":\"Nama\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama\",\"width\":\"250\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 11:46:28', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2741, 181, 589, 'FIELD', 'bibi_name', 'bibi_name', 'Text', 5, '{\"position\":5,\"render\":1,\"label\":\"Nama Bibi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:47:41', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2742, 181, 589, 'FIELD', 'id_merk', 'id_merk', 'Select Master', 6, '{\"position\":6,\"render\":1,\"validation\":[\"required\"],\"label\":\"Tipe\\/Merk\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"6\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tipe\\/Merk\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"591\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-10 11:47:59', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2743, 181, 589, 'FIELD', 'year_procurement', 'year_procurement', 'Text', 7, '{\"position\":7,\"render\":1,\"validation\":[\"required\"],\"label\":\"Tahun Pembelian\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:48:15', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2744, 181, 589, 'FIELD', 'year_made', 'year_made', 'Text', 8, '{\"position\":8,\"render\":1,\"label\":\"Tahun Pembuatan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:48:22', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2745, 181, 589, 'FIELD', 'acquisition_value', 'acquisition_value', 'Number', 9, '{\"position\":9,\"render\":1,\"label\":\"Nilai Perolehan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:48:31', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2746, 181, 589, 'FIELD', 'id_category', 'id_category', 'Select Master', 10, '{\"position\":10,\"render\":1,\"validation\":[\"required\"],\"label\":\"Kategori\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"5\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Kategori\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"590\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-10 11:48:49', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2747, 181, 589, 'FIELD', 'id_location', 'id_location', 'Select Master', 11, '{\"position\":11,\"render\":1,\"validation\":[\"required\"],\"label\":\"Lokasi Penyimpanan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"593\",\"field_label\":\"code\",\"field_order\":\"code\",\"field_show\":[\"code\",\"description\"]}}', '2024-10-10 11:49:17', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2748, 181, 589, 'FIELD', 'id_bibi_location', 'id_bibi_location', 'Select Master', 12, '{\"position\":12,\"render\":1,\"label\":\"Lokasi Bibi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"594\",\"field_label\":\"code\",\"field_order\":\"code\",\"field_show\":[\"code\",\"description\"]}}', '2024-10-10 11:51:17', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2749, 181, 589, 'FIELD', 'id_condition', 'id_condition', 'Select Master', 13, '{\"position\":13,\"render\":1,\"validation\":[\"required\"],\"label\":\"Kondisi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"592\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-10 11:51:33', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2750, 181, 589, 'FIELD', 'id_unit', 'id_unit', 'Select Master', 14, '{\"position\":14,\"render\":1,\"label\":\"Satuan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"595\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-10 11:52:36', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2751, 181, 589, 'FIELD', 'specification', 'specification', 'Textarea', 18, '{\"position\":15,\"render\":1,\"label\":\"Spesifikasi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:52:47', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2752, 181, 589, 'FIELD', 'description', 'description', 'Textarea', 19, '{\"position\":16,\"render\":1,\"label\":\"Keterangan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 11:53:03', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2753, 181, 589, 'FIELD', 'is_verified', 'is_verified', 'Radio Key', 20, '{\"render\":1,\"position\":17}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Verifikasi\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":[\"Tidak\",\"Ya\"]}', '2024-10-10 11:53:50', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2754, 181, 589, 'FIELD', 'is_avaliable', 'is_avaliable', 'Select List Key', 21, '{\"position\":18,\"render\":1,\"validation\":[\"required\"],\"label\":\"Status\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":\"3\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Ketersediaan\",\"width\":\"120\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":{\"1\":\"Tersedia\",\"2\":\"Tidak Tersedia\",\"3\":\"Pengajuan Peminjaman\",\"4\":\"Dipinjam\"}}', '2024-10-10 11:54:20', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2755, 181, 589, 'FIELD', 'pic', 'pic', 'Text', 22, '{\"render\":0,\"position\":18}', '{\"render\":0}', '', '2024-10-10 11:54:29', 1, '2024-10-25 11:05:15', 1);
INSERT INTO `__sys_fields` VALUES (2756, 181, 589, 'FIELD', 'created', 'created', 'Sysdate', 23, '{\"render\":0}', '{\"position\":\"9\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"150\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-10 11:54:40', 1, '2024-10-25 11:05:15', 1);
INSERT INTO `__sys_fields` VALUES (2757, 181, 589, 'FIELD', 'gambar', 'gambar', 'File Image Multiple', 24, '{\"position\":19,\"render\":1,\"label\":\"Gambar\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-10 13:47:23', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2758, 182, 596, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":0}', '{\"render\":0}', '', '2024-10-12 09:08:57', 1, '2024-10-12 09:15:31', 1);
INSERT INTO `__sys_fields` VALUES (2759, 182, 596, 'FIELD', 'project_name', 'project_name', 'Text', 2, '{\"position\":1,\"render\":1,\"validation\":[\"required\"],\"label\":\"Nama Kegiatan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":2,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama Kegiatan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-12 09:09:07', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2760, 182, 596, 'FIELD', 'region_name', 'region_name', 'Text', 3, '{\"position\":2,\"render\":1,\"validation\":[\"required\"],\"label\":\"Nama Daerah\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:09:16', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2761, 182, 596, 'FIELD', 'region_city', 'region_city', 'Select Master', 4, '{\"position\":3,\"render\":1,\"validation\":[\"required\"],\"label\":\"Kota\\/Kabupaten\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"597\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-12 09:10:31', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2762, 182, 596, 'FIELD', 'region_province', 'region_province', 'Select Master', 5, '{\"position\":4,\"render\":1,\"validation\":[\"required\"],\"label\":\"Provinsi\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"598\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-12 09:10:45', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2763, 182, 596, 'FIELD', 'start_date', 'start_date', 'Date', 6, '{\"position\":\"9\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Mulai\",\"default_value\":\"\",\"note\":\"Peminjaman Minimal H-3\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Mulai\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-12 09:10:55', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2764, 182, 596, 'FIELD', 'end_date', 'end_date', 'Date', 7, '{\"position\":10,\"render\":1,\"validation\":[\"required\"],\"label\":\"Selesai\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":5,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Selesai\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-12 09:11:03', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2765, 182, 596, 'FIELD', 'borrow_letter_number', 'borrow_letter_number', 'Text', 8, '{\"position\":5,\"render\":1,\"validation\":[\"required\"],\"label\":\"Nomor Pengajuan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:11:11', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2766, 182, 596, 'FIELD', 'borrow_letter_date', 'borrow_letter_date', 'Date', 9, '{\"position\":\"12\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Tanggal Pengajuan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:11:21', 1, '2024-10-15 15:10:18', 1);
INSERT INTO `__sys_fields` VALUES (2767, 182, 596, 'FIELD', 'borrow_regard', 'borrow_regard', 'Text', 10, '{\"position\":6,\"render\":1,\"validation\":[\"required\"],\"label\":\"Perihal\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:11:36', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2768, 182, 596, 'FIELD', 'borrow_content', 'borrow_content', 'HTML', 11, '{\"position\":11,\"render\":1,\"validation\":[\"required\"],\"label\":\"Isi Surat Pengajuan\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:11:47', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2769, 182, 596, 'FIELD', 'team_leader', 'team_leader', 'Text', 12, '{\"position\":7,\"render\":1,\"validation\":[\"required\"],\"label\":\"Ketua Tim\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:11:57', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2770, 182, 596, 'FIELD', 'leader_nip', 'leader_nip', 'Text', 13, '{\"position\":8,\"render\":1,\"validation\":[\"required\"],\"label\":\"NIP Ketua Tim\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2024-10-12 09:12:08', 1, '2024-10-15 15:09:53', 1);
INSERT INTO `__sys_fields` VALUES (2771, 182, 596, 'FIELD', 'status', 'status', 'Select List Key', 15, '{\"render\":0}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Status\",\"width\":\"100\",\"halign\":\"text-left\",\"align\":\"left\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"\"}}', '2024-10-12 09:12:33', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2772, 182, 596, 'FIELD', 'created', 'created', 'Sysdate', 16, '{\"render\":0}', '{\"position\":7,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-12 09:12:44', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2773, 182, 596, 'FIELD', 'createdby', 'createdby', 'Select Master', 17, '{\"render\":0}', '{\"position\":3,\"render\":0,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Pemohon\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"599\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"name\"]}}', '2024-10-13 01:43:18', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2774, 175, 581, 'FIELD', 'company_name', 'company_name', 'Text', 9, '{\"render\":1,\"position\":10}', '{\"position\":11,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama Perusahaan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-17 11:45:17', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2775, 175, 581, 'FIELD', 'company_address', 'company_address', 'Textarea', 10, '{\"render\":1,\"position\":11}', '{\"position\":12,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"1\",\"cut_string\":\"0\",\"label\":\"Alamat Perusahaan\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-17 11:45:30', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2776, 181, 589, 'FIELD', 'price', 'price', 'Number', 15, '{\"render\":1,\"position\":20}', '{\"position\":7,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Harga Sewa\",\"width\":\"100\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-20 23:37:21', 1, '2024-10-30 10:51:40', 1);
INSERT INTO `__sys_fields` VALUES (2777, 181, 589, 'FIELD', 'price_unit', 'price_unit', 'Select List Key', 16, '{\"render\":1,\"position\":21}', '{\"position\":8,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Satuan Harga\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-20 23:37:41', 1, '2024-10-25 11:05:24', 1);
INSERT INTO `__sys_fields` VALUES (2778, 181, 589, 'FIELD', 'id_parent', 'id_parent', 'Select Master', 2, '{\"position\":2,\"render\":1,\"label\":\"Parent\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '{\"source\":{\"id\":\"600\",\"field_label\":\"name\",\"field_order\":\"name\",\"field_show\":[\"no_inventaris\",\"name\"]}}', '2024-10-21 09:41:13', 1, '2024-10-25 11:05:23', 1);
INSERT INTO `__sys_fields` VALUES (2779, 182, 596, 'FIELD', 'biaya', 'biaya', 'Number', 14, NULL, '{\"position\":6,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Biaya Peminjaman\",\"width\":\"150\",\"halign\":\"text-right\",\"align\":\"right\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-23 11:46:08', 1, '2024-10-23 12:11:04', 1);
INSERT INTO `__sys_fields` VALUES (2780, 182, 599, 'FIELD', 'name', 'name', 'Text', 18, NULL, '{\"position\":\"3\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Pemohon\",\"width\":\"130\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-23 12:10:49', 1, '2024-10-23 12:11:51', 1);
INSERT INTO `__sys_fields` VALUES (2781, 181, 589, 'FIELD', 'price_calculate_child', 'price_calculate_child', 'Radio Key Horizontal', 17, '{\"position\":\"22\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Harga Kalkulasi\",\"default_value_type\":\"text\",\"default_value\":\"0\",\"note\":\"Jika Tidak, maka harga yang tertera tidak terpengaruh dari harga Barang yang dibawahnya. Jika Ya, maka harga akan dipengaruhi dari harga Barang dibawahnya.\",\"class_container\":\"\",\"class_element\":\"\"}', NULL, '{\"list\":[\"Tidak\",\"Ya\"]}', '2024-10-25 11:05:09', 1, '2024-10-25 11:21:35', 1);
INSERT INTO `__sys_fields` VALUES (2782, 183, 601, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2024-10-31 01:06:24', 1, '2024-10-31 01:09:15', 1);
INSERT INTO `__sys_fields` VALUES (2783, 183, 601, 'FIELD', 'name', 'name', 'Select Tags', 2, '{\"render\":1,\"position\":2}', '{\"position\":\"1\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama Bank\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-31 01:06:41', 1, '2024-10-31 01:09:15', 1);
INSERT INTO `__sys_fields` VALUES (2784, 183, 601, 'FIELD', 'account', 'account', 'Text', 3, '{\"render\":1,\"position\":3}', '{\"position\":\"2\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nomor Rekening\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-31 01:06:52', 1, '2024-10-31 01:09:15', 1);
INSERT INTO `__sys_fields` VALUES (2785, 183, 601, 'FIELD', 'created', 'created', 'Sysdate', 4, '{\"render\":0}', '{\"position\":\"3\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-31 01:07:04', 1, '2024-10-31 01:09:13', 1);
INSERT INTO `__sys_fields` VALUES (2786, 175, 581, 'FIELD', 'type_user', 'type_user', 'Radio Key', 12, '{\"render\":1,\"position\":4}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tipe Pengguna\",\"width\":\"50\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":{\"1\":\"INTERNAL\",\"2\":\"EXTERNAL\"}}', '2024-10-31 12:05:05', 1, '2024-10-31 21:40:11', 1);
INSERT INTO `__sys_fields` VALUES (2787, 175, 581, 'FIELD', 'nip', 'nip', 'Text', 14, NULL, '{\"position\":\"6\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"NIP\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2024-10-31 21:40:03', 1, '2024-10-31 21:40:21', 1);
INSERT INTO `__sys_fields` VALUES (2788, 184, 602, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2026-05-12 05:56:24', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2789, 184, 602, 'FIELD', 'nip', 'nip', 'Text', 3, '{\"render\":1,\"position\":3}', '{\"position\":2,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nomor Induk Pegawai\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 05:56:31', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2790, 184, 602, 'FIELD', 'nama', 'nama', 'Text', 4, '{\"render\":1,\"position\":4}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama Lenngkap\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 05:56:39', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2791, 184, 602, 'FIELD', 'tanggal_lahir', 'tanggal_lahir', 'Date', 5, '{\"render\":1,\"position\":5}', '{\"position\":7,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Lahir\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 05:56:48', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2792, 184, 602, 'FIELD', 'jenis_kelamin', 'jenis_kelamin', 'Radio Value', 6, '{\"render\":1,\"position\":6}', '{\"position\":8,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jenis Kelamin\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":[\"Laki-laki\",\"Perempuan\"]}', '2026-05-12 05:57:14', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2793, 184, 602, 'FIELD', 'agama', 'agama', 'Select List Value', 7, '{\"render\":1,\"position\":7}', '{\"position\":9,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Agama\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"\"},\"list\":[\"Islam\",\"Kristen\",\"Katolik\",\"Hindu\",\"Buddha\",\"Konghucu\"]}', '2026-05-12 05:57:47', 1, '2026-05-12 03:38:03', 1);
INSERT INTO `__sys_fields` VALUES (2794, 184, 602, 'FIELD', 'alamat', 'alamat', 'Textarea', 8, '{\"render\":1,\"position\":8}', '{\"position\":10,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Alamat\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 05:57:56', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2795, 184, 602, 'FIELD', 'id_jabatan', 'id_jabatan', 'Select Master', 9, '{\"render\":1,\"position\":10}', '{\"position\":5,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Jabatan\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"603\",\"field_label\":\"nama\",\"field_order\":\"nama\",\"field_show\":[\"nama\"]}}', '2026-05-12 05:59:46', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2796, 184, 602, 'FIELD', 'id_divisi', 'id_divisi', 'Select Master', 10, '{\"render\":1,\"position\":9}', '{\"position\":4,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Divisi\\/Departemen\",\"width\":\"100\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"604\",\"field_label\":\"nama\",\"field_order\":\"nama\",\"field_show\":[\"nama\"]}}', '2026-05-12 06:16:12', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2797, 184, 602, 'FIELD', 'status', 'status', 'Radio Key', 11, '{\"render\":1,\"position\":11}', '{\"position\":6,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Status\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":{\"1\":\"Aktif\",\"0\":\"Inactive\"}}', '2026-05-12 06:16:37', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2798, 184, 602, 'FIELD', 'created', 'created', 'Sysdate', 12, '{\"render\":0,\"position\":9}', '{\"position\":11,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Dibuat\",\"width\":\"100\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 02:36:21', 1, '2026-05-12 03:08:57', 1);
INSERT INTO `__sys_fields` VALUES (2799, 184, 602, 'FIELD', 'foto', 'foto', 'File Image', 2, '{\"render\":1,\"position\":2}', '{\"position\":\"1\",\"render\":\"1\",\"filter\":\"0\",\"sort\":\"0\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Foto\",\"width\":\"50\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 03:08:47', 1, '2026-05-12 03:09:14', 1);
INSERT INTO `__sys_fields` VALUES (2800, 185, 605, 'FIELD', 'id_pegawai', 'id_pegawai', 'Select Master', 2, '{\"position\":2,\"render\":1,\"validation\":[\"required\"],\"label\":\"Nama Pegawai\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":1,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Nama\",\"width\":\"200\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"source\":{\"id\":\"606\",\"field_label\":\"nama\",\"field_order\":\"nama\",\"field_show\":[\"nip\",\"nama\"]}}', '2026-05-12 03:52:23', 1, '2026-05-12 03:55:12', 1);
INSERT INTO `__sys_fields` VALUES (2801, 185, 605, 'FIELD', 'id', 'id', 'ID', 1, '{\"render\":1,\"position\":1}', '{\"render\":0}', '', '2026-05-12 03:52:30', 1, '2026-05-12 03:55:12', 1);
INSERT INTO `__sys_fields` VALUES (2802, 185, 605, 'FIELD', 'email', 'email', 'Email', 3, '{\"position\":3,\"render\":1,\"validation\":[\"required\"],\"label\":\"Email\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":2,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Email\",\"width\":\"\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 03:52:40', 1, '2026-05-12 03:55:12', 1);
INSERT INTO `__sys_fields` VALUES (2803, 185, 605, 'FIELD', 'password', 'password', 'Password', 4, '{\"position\":4,\"render\":1,\"validation\":[\"required\"],\"label\":\"Password\",\"default_value\":\"\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"render\":0}', '', '2026-05-12 03:52:48', 1, '2026-05-12 03:55:12', 1);
INSERT INTO `__sys_fields` VALUES (2804, 185, 605, 'FIELD', 'status', 'status', 'Radio Key', 5, '{\"position\":\"5\",\"render\":\"1\",\"validation\":[\"required\"],\"label\":\"Status\",\"default_value_type\":\"text\",\"default_value\":\"1\",\"note\":\"\",\"class_container\":\"\",\"class_element\":\"\"}', '{\"position\":3,\"render\":1,\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Status\",\"width\":\"50\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '{\"list\":{\"1\":\"Active\",\"0\":\"Inactive\"}}', '2026-05-12 03:53:12', 1, '2026-05-12 03:55:18', 1);
INSERT INTO `__sys_fields` VALUES (2805, 185, 605, 'FIELD', 'created', 'created', 'Sysdate', 6, '{\"render\":0}', '{\"position\":\"4\",\"render\":\"1\",\"filter\":\"1\",\"sort\":\"1\",\"wrap\":\"0\",\"cut_string\":\"0\",\"label\":\"Tanggal Dibuat\",\"width\":\"150\",\"halign\":\"text-center\",\"align\":\"center\",\"class_th\":\"\",\"class_td\":\"\"}', '', '2026-05-12 03:53:21', 1, '2026-05-12 03:54:40', 1);

-- ----------------------------
-- Table structure for __sys_master
-- ----------------------------
DROP TABLE IF EXISTS `__sys_master`;
CREATE TABLE `__sys_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `label` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `description` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `modules` int NULL DEFAULT NULL,
  `url` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `other` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 186 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of __sys_master
-- ----------------------------
INSERT INTO `__sys_master` VALUES (53, 'config-roles', 'ROLES', '', NULL, 'config/roles', '{\"datatable\":{\"type\":\"TREETABLE\",\"tree_label\":\"name\",\"tree_parent\":\"id_parent\",\"table_sort\":\"code\",\"table_sort_type\":\"asc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_VIEW_POPUP\",\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2021-08-18 08:13:21', 1, '2024-10-13 09:54:33', 1);
INSERT INTO `__sys_master` VALUES (175, 'users', 'USERS', '', NULL, 'users', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"EXPORT\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_VIEW_LINK\",\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-09 23:27:22', 1, '2024-11-01 00:51:48', 1);
INSERT INTO `__sys_master` VALUES (176, 'satuan', 'SATUAN', '', NULL, 'goods/satuan', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 01:46:53', 1, '2024-10-13 09:54:36', 1);
INSERT INTO `__sys_master` VALUES (177, 'kondisi', 'KONDISI', '', NULL, 'goods/kondisi', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 01:46:53', 1, '2024-10-13 09:54:38', 1);
INSERT INTO `__sys_master` VALUES (178, 'lokasi', 'LOKASI', '', NULL, 'goods/lokasi', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 01:46:53', 1, '2024-10-13 09:54:40', 1);
INSERT INTO `__sys_master` VALUES (179, 'merk', 'MERK', '', NULL, 'goods/merk', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 01:46:53', 1, '2024-10-13 09:54:42', 1);
INSERT INTO `__sys_master` VALUES (180, 'kategori', 'KATEGORI', '', NULL, 'goods/kategori', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 01:46:53', 1, '2024-10-13 09:54:44', 1);
INSERT INTO `__sys_master` VALUES (181, 'barang', 'BARANG', '', NULL, 'goods/barang', '{\"datatable\":{\"protocol\":\"POST\",\"type\":\"DATATABLE\",\"tree_label\":\"no_inventaris\",\"tree_parent\":\"id_parent\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"EXPORT\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_VIEW_LINK\",\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-10 11:39:13', 1, '2024-11-01 00:52:00', 1);
INSERT INTO `__sys_master` VALUES (182, 'peminjaman', 'PEMINJAMAN', '', NULL, 'transaction/peminjaman/', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"EXPORT\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_VIEW_LINK\"]}}', '2024-10-12 09:08:25', 1, '2024-10-31 23:43:12', 1);
INSERT INTO `__sys_master` VALUES (183, 'bank', 'BANK', '', NULL, 'setting/bank', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"name\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"EXPORT\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2024-10-31 01:05:53', 1, '2024-10-31 01:09:08', 1);
INSERT INTO `__sys_master` VALUES (184, 'data-pegawai', 'DATA - PEGAWAI', '', NULL, 'pegawai', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_VIEW_LINK\",\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2026-05-12 05:55:46', 1, '2026-05-12 02:37:00', 1);
INSERT INTO `__sys_master` VALUES (185, 'data-users', 'DATA - USERS', '', NULL, 'users', '{\"datatable\":{\"protocol\":\"GET\",\"type\":\"DATATABLE\",\"tree_all\":\"0\",\"tree_rownumbers\":\"0\",\"table_sort\":\"created\",\"table_sort_type\":\"desc\",\"table_size_page\":\"10\",\"button_table\":[\"ADD\",\"CLEAR\",\"REFRESH\"],\"button_action\":[\"ACTION_EDIT\",\"ACTION_DELETE\"]}}', '2026-05-12 03:49:53', 1, '2026-05-12 03:54:36', 1);

-- ----------------------------
-- Table structure for __sys_metadata
-- ----------------------------
DROP TABLE IF EXISTS `__sys_metadata`;
CREATE TABLE `__sys_metadata`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_object` int NOT NULL,
  `id_field` int NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1727 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of __sys_metadata
-- ----------------------------

-- ----------------------------
-- Table structure for __sys_sources
-- ----------------------------
DROP TABLE IF EXISTS `__sys_sources`;
CREATE TABLE `__sys_sources`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_master` int NOT NULL,
  `table_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `table_alias` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `table_primary` bit(1) NULL DEFAULT b'0',
  `primary_key` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `join_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `join_table` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `join_key` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `conditions` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `position` int NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_fields_master`(`id_master` ASC) USING BTREE,
  CONSTRAINT `fk_source_master` FOREIGN KEY (`id_master`) REFERENCES `__sys_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 607 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of __sys_sources
-- ----------------------------
INSERT INTO `__sys_sources` VALUES (191, 53, 'mst_roles', 'roles', b'1', 'id', '', 'roles', NULL, '[]', 1, '2021-08-18 08:13:35', 1, '2021-08-18 08:13:49', 1);
INSERT INTO `__sys_sources` VALUES (581, 175, 'mst_users', 'users', b'1', 'id', '', 'users', NULL, '[]', 1, '2024-10-09 23:27:31', 1, '2024-10-09 23:27:38', 1);
INSERT INTO `__sys_sources` VALUES (582, 175, 'mst_satuan_kerja', 'satuan_kerja', b'0', 'id', 'LEFT', 'users', 'division', '[]', 2, '2024-10-09 23:27:45', 1, '2024-10-09 23:28:06', 1);
INSERT INTO `__sys_sources` VALUES (583, 175, 'mst_roles', 'roles', b'0', 'id', 'LEFT', 'users', 'id_role', '[]', 3, '2024-10-09 23:28:10', 1, '2024-10-09 23:28:21', 1);
INSERT INTO `__sys_sources` VALUES (584, 176, 'mst_satuan', 'satuan', b'1', 'id', '', 'satuan', NULL, '[]', 1, '2024-10-10 01:47:11', 1, '2024-10-10 01:47:17', 1);
INSERT INTO `__sys_sources` VALUES (585, 177, 'mst_condition', 'condition', b'1', 'id', '', 'condition', NULL, '[]', 1, '2024-10-10 01:47:11', 1, '2024-10-10 10:15:11', 1);
INSERT INTO `__sys_sources` VALUES (586, 178, 'mst_location', 'location', b'1', 'id', '', 'location', NULL, '[]', 1, '2024-10-10 01:47:11', 1, '2024-10-10 10:28:31', 1);
INSERT INTO `__sys_sources` VALUES (587, 179, 'mst_merk', 'merk', b'1', 'id', '', 'merk', NULL, '[]', 1, '2024-10-10 01:47:11', 1, '2024-10-10 11:10:55', 1);
INSERT INTO `__sys_sources` VALUES (588, 180, 'mst_categories', 'kategori', b'1', 'id', '', 'kategori', NULL, '[]', 1, '2024-10-10 01:47:11', 1, '2024-10-10 11:11:07', 1);
INSERT INTO `__sys_sources` VALUES (589, 181, 'mst_barang', 'barang', b'1', 'id', '', 'barang', NULL, '[]', 1, '2024-10-10 11:39:28', 1, '2024-10-10 11:39:35', 1);
INSERT INTO `__sys_sources` VALUES (590, 181, 'mst_categories', 'categories', b'0', 'id', 'LEFT', 'barang', 'id_category', '[]', 2, '2024-10-10 11:39:42', 1, '2024-10-10 11:40:02', 1);
INSERT INTO `__sys_sources` VALUES (591, 181, 'mst_merk', 'merk', b'0', 'id', 'LEFT', 'barang', 'id_merk', '[]', 3, '2024-10-10 11:40:23', 1, '2024-10-10 11:45:45', 1);
INSERT INTO `__sys_sources` VALUES (592, 181, 'mst_condition', 'kondisi', b'0', 'id', 'LEFT', 'barang', 'id_condition', '[]', 4, '2024-10-10 11:45:12', 1, '2024-10-10 12:22:05', 1);
INSERT INTO `__sys_sources` VALUES (593, 181, 'mst_location', 'location', b'0', 'id', 'LEFT', 'barang', 'id_location', '[]', 5, '2024-10-10 11:45:54', 1, '2024-10-10 11:46:04', 1);
INSERT INTO `__sys_sources` VALUES (594, 181, 'mst_location', 'location_bibi', b'0', 'id', 'LEFT', 'barang', 'id_bibi_location', '[]', 6, '2024-10-10 11:50:12', 1, '2024-10-10 11:50:47', 1);
INSERT INTO `__sys_sources` VALUES (595, 181, 'mst_satuan', 'satuan', b'0', 'id', 'LEFT', 'barang', 'id_unit', '[]', 7, '2024-10-10 11:51:59', 1, '2024-10-10 11:52:11', 1);
INSERT INTO `__sys_sources` VALUES (596, 182, 'mst_transaction', 'transaction', b'1', 'id', '', 'transaction', NULL, '[]', 1, '2024-10-12 09:08:36', 1, '2024-10-12 09:08:44', 1);
INSERT INTO `__sys_sources` VALUES (597, 182, 'mst_area_cities', 'cities', b'0', 'id', 'LEFT', 'transaction', 'region_city', '[]', 2, '2024-10-12 09:09:31', 1, '2024-10-12 09:09:44', 1);
INSERT INTO `__sys_sources` VALUES (598, 182, 'mst_area_provinces', 'province', b'0', 'id', 'LEFT', 'transaction', 'region_province', '[]', 3, '2024-10-12 09:09:50', 1, '2024-10-12 09:10:04', 1);
INSERT INTO `__sys_sources` VALUES (599, 182, 'mst_users', 'user_created', b'0', 'id', 'LEFT', 'transaction', 'createdby', '[]', 4, '2024-10-13 01:39:04', 1, '2024-10-13 01:40:17', 1);
INSERT INTO `__sys_sources` VALUES (600, 181, 'mst_barang', 'parent', b'0', 'id', 'LEFT', 'barang', 'id_parent', '[]', 8, '2024-10-21 09:40:28', 1, '2024-10-21 09:40:49', 1);
INSERT INTO `__sys_sources` VALUES (601, 183, 'mst_bank', 'bank', b'1', 'id', '', 'bank', NULL, '[]', 1, '2024-10-31 01:06:05', 1, '2024-10-31 01:06:14', 1);
INSERT INTO `__sys_sources` VALUES (602, 184, 'tbl_pegawai', 'pagawai', b'1', 'id', '', 'pagawai', NULL, '[]', 1, '2026-05-12 05:56:07', 1, '2026-05-12 05:56:14', 1);
INSERT INTO `__sys_sources` VALUES (603, 184, 'tbl_jabatan', 'jabatan', b'0', 'id', 'LEFT', 'pagawai', 'id_jabatan', '[]', 2, '2026-05-12 05:58:52', 1, '2026-05-12 05:59:03', 1);
INSERT INTO `__sys_sources` VALUES (604, 184, 'tbl_divisi', 'divisi', b'0', 'id', 'LEFT', 'pagawai', 'id_divisi', '[]', 3, '2026-05-12 05:59:09', 1, '2026-05-12 05:59:24', 1);
INSERT INTO `__sys_sources` VALUES (605, 185, 'tbl_users', 'users', b'1', 'id', '', '', '', '[]', 1, '2026-05-12 03:50:04', 1, '2026-05-12 03:57:40', 1);
INSERT INTO `__sys_sources` VALUES (606, 185, 'tbl_pegawai', 'pegawai', b'0', 'id', 'LEFT', 'users', 'id_pegawai', '[]', 2, '2026-05-12 03:50:16', 1, '2026-05-12 03:57:40', 1);

-- ----------------------------
-- Table structure for tbl_divisi
-- ----------------------------
DROP TABLE IF EXISTS `tbl_divisi`;
CREATE TABLE `tbl_divisi`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_divisi
-- ----------------------------
INSERT INTO `tbl_divisi` VALUES (1, 'Accounting', '2024-10-07 15:32:33', 1, '2026-05-12 05:54:16', 1);
INSERT INTO `tbl_divisi` VALUES (2, 'Keuangan', '2026-05-12 05:52:52', 1, '2026-05-12 05:54:21', 1);
INSERT INTO `tbl_divisi` VALUES (3, 'Procurement', '2026-05-12 05:52:56', 1, '2026-05-12 05:54:26', 1);
INSERT INTO `tbl_divisi` VALUES (4, 'Legal', '2026-05-12 05:53:03', 1, '2026-05-12 05:54:33', 1);
INSERT INTO `tbl_divisi` VALUES (5, 'Manager', '2026-05-12 05:53:07', 1, '2026-05-12 05:53:34', 1);

-- ----------------------------
-- Table structure for tbl_files
-- ----------------------------
DROP TABLE IF EXISTS `tbl_files`;
CREATE TABLE `tbl_files`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_type` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `directory` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `file_name_ori` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `file_name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'File size in bytes',
  `file_size` float(11, 2) NULL DEFAULT NULL,
  `file_tmp` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `meta` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `status` int NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_file_name`(`file_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_files
-- ----------------------------
INSERT INTO `tbl_files` VALUES (1, '', 'public/uploads/20260511', 'WhatsApp Image 2026-04-01 at 09.19.03.jpeg', '1778530388_2878dcf0ad67ec5f0ac8.jpeg', 'jpeg', 160359.00, NULL, NULL, 1, '2026-05-12 03:13:08', 1, '2026-05-12 03:13:08', 1);
INSERT INTO `tbl_files` VALUES (2, '', 'public/uploads/20260511', '1689203032176.jpeg', '1778530411_da18780e8cb58ea1a41f.jpeg', 'jpeg', 6551.00, NULL, NULL, 1, '2026-05-12 03:13:31', 1, '2026-05-12 03:13:31', 1);

-- ----------------------------
-- Table structure for tbl_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_jabatan`;
CREATE TABLE `tbl_jabatan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_jabatan
-- ----------------------------
INSERT INTO `tbl_jabatan` VALUES (1, 'Komisaris', '2024-10-07 15:32:33', 1, '2026-05-12 05:52:46', 1);
INSERT INTO `tbl_jabatan` VALUES (2, 'Direktur Utama', '2026-05-12 05:52:52', 1, '2026-05-12 05:53:33', 1);
INSERT INTO `tbl_jabatan` VALUES (3, 'Direktur Keuangan', '2026-05-12 05:52:56', 1, '2026-05-12 05:53:33', 1);
INSERT INTO `tbl_jabatan` VALUES (4, 'Kepala Divisi', '2026-05-12 05:53:03', 1, '2026-05-12 05:53:34', 1);
INSERT INTO `tbl_jabatan` VALUES (5, 'Manager', '2026-05-12 05:53:07', 1, '2026-05-12 05:53:34', 1);
INSERT INTO `tbl_jabatan` VALUES (6, 'Assistant Manager', '2026-05-12 05:53:18', 1, '2026-05-12 05:53:34', 1);
INSERT INTO `tbl_jabatan` VALUES (7, 'Staff/Officer', '2026-05-12 05:53:24', 1, '2026-05-12 05:53:35', 1);

-- ----------------------------
-- Table structure for tbl_pegawai
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pegawai`;
CREATE TABLE `tbl_pegawai`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `foto` int NULL DEFAULT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `jenis_kelamin` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `agama` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `id_jabatan` int NULL DEFAULT NULL,
  `id_divisi` int NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 122 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_pegawai
-- ----------------------------
INSERT INTO `tbl_pegawai` VALUES (1, 2, '10109099', 'Deni Bahtiar', '2002-05-01', 'Laki-laki', 'Islam', 'Tangerang Selatan', 7, 2, 1, '2026-05-12 05:50:16', 1, '2026-05-11 20:13:44', 1);
INSERT INTO `tbl_pegawai` VALUES (22, NULL, '00000001', 'Pegawai 1', '1995-12-01', 'Perempuan', 'Islam', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (23, NULL, '00000002', 'Pegawai 2', '2001-11-03', 'Laki-laki', 'Islam', NULL, 7, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (24, NULL, '00000003', 'Pegawai 3', '1994-04-07', 'Perempuan', 'Kristen', NULL, 5, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (25, NULL, '00000004', 'Pegawai 4', '2000-02-17', 'Perempuan', 'Kristen', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (26, NULL, '00000005', 'Pegawai 5', '1986-11-20', 'Laki-laki', 'Buddha', NULL, 2, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (27, NULL, '00000006', 'Pegawai 6', '1980-12-15', 'Perempuan', 'Buddha', NULL, 6, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (28, NULL, '00000007', 'Pegawai 7', '1990-06-26', 'Perempuan', 'Hindu', NULL, 2, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (29, NULL, '00000008', 'Pegawai 8', '1992-11-10', 'Laki-laki', 'Katolik', NULL, 3, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (30, NULL, '00000009', 'Pegawai 9', '2003-08-22', 'Perempuan', 'Konghucu', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (31, NULL, '00000010', 'Pegawai 10', '2000-03-31', 'Laki-laki', 'Konghucu', NULL, 3, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (32, NULL, '00000011', 'Pegawai 11', '1987-01-09', 'Laki-laki', 'Hindu', NULL, 2, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (33, NULL, '00000012', 'Pegawai 12', '1990-12-17', 'Laki-laki', 'Islam', NULL, 7, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (34, NULL, '00000013', 'Pegawai 13', '2004-05-14', 'Perempuan', 'Kristen', NULL, 2, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (35, NULL, '00000014', 'Pegawai 14', '1983-09-21', 'Laki-laki', 'Buddha', NULL, 3, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (36, NULL, '00000015', 'Pegawai 15', '2001-04-20', 'Laki-laki', 'Katolik', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (37, NULL, '00000016', 'Pegawai 16', '2002-10-06', 'Laki-laki', 'Katolik', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (38, NULL, '00000017', 'Pegawai 17', '1982-04-18', 'Perempuan', 'Konghucu', NULL, 6, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (39, NULL, '00000018', 'Pegawai 18', '1982-05-29', 'Perempuan', 'Buddha', NULL, 7, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (40, NULL, '00000019', 'Pegawai 19', '1982-09-21', 'Laki-laki', 'Hindu', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (41, NULL, '00000020', 'Pegawai 20', '1994-12-14', 'Perempuan', 'Buddha', NULL, 4, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (42, NULL, '00000021', 'Pegawai 21', '1993-02-19', 'Perempuan', 'Buddha', NULL, 2, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (43, NULL, '00000022', 'Pegawai 22', '1980-08-18', 'Laki-laki', 'Buddha', NULL, 1, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (44, NULL, '00000023', 'Pegawai 23', '1982-12-15', 'Perempuan', 'Konghucu', NULL, 2, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (45, NULL, '00000024', 'Pegawai 24', '2000-03-04', 'Laki-laki', 'Konghucu', NULL, 5, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (46, NULL, '00000025', 'Pegawai 25', '1980-03-14', 'Perempuan', 'Buddha', NULL, 7, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (47, NULL, '00000026', 'Pegawai 26', '1994-03-13', 'Laki-laki', 'Hindu', NULL, 2, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (48, NULL, '00000027', 'Pegawai 27', '1996-07-25', 'Perempuan', 'Hindu', NULL, 3, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (49, NULL, '00000028', 'Pegawai 28', '1985-06-23', 'Perempuan', 'Konghucu', NULL, 6, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (50, NULL, '00000029', 'Pegawai 29', '2004-12-04', 'Laki-laki', 'Hindu', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (51, NULL, '00000030', 'Pegawai 30', '1987-07-07', 'Laki-laki', 'Katolik', NULL, 4, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (52, NULL, '00000031', 'Pegawai 31', '1983-06-06', 'Perempuan', 'Islam', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (53, NULL, '00000032', 'Pegawai 32', '1988-04-22', 'Laki-laki', 'Katolik', NULL, 1, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (54, NULL, '00000033', 'Pegawai 33', '1999-03-26', 'Laki-laki', 'Katolik', NULL, 1, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (55, NULL, '00000034', 'Pegawai 34', '1994-05-23', 'Laki-laki', 'Islam', NULL, 4, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (56, NULL, '00000035', 'Pegawai 35', '1994-08-01', 'Laki-laki', 'Buddha', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (57, NULL, '00000036', 'Pegawai 36', '2002-01-07', 'Perempuan', 'Buddha', NULL, 7, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (58, NULL, '00000037', 'Pegawai 37', '1988-03-28', 'Laki-laki', 'Buddha', NULL, 5, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (59, NULL, '00000038', 'Pegawai 38', '1991-10-24', 'Perempuan', 'Islam', NULL, 3, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (60, NULL, '00000039', 'Pegawai 39', '2004-05-01', 'Laki-laki', 'Buddha', NULL, 2, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (61, NULL, '00000040', 'Pegawai 40', '1983-07-29', 'Perempuan', 'Hindu', NULL, 2, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (62, NULL, '00000041', 'Pegawai 41', '2001-02-15', 'Laki-laki', 'Buddha', NULL, 3, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (63, NULL, '00000042', 'Pegawai 42', '1987-12-24', 'Perempuan', 'Islam', NULL, 3, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (64, NULL, '00000043', 'Pegawai 43', '1992-04-09', 'Perempuan', 'Buddha', NULL, 7, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (65, NULL, '00000044', 'Pegawai 44', '1988-05-16', 'Perempuan', 'Islam', NULL, 6, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (66, NULL, '00000045', 'Pegawai 45', '2001-02-04', 'Perempuan', 'Kristen', NULL, 3, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (67, NULL, '00000046', 'Pegawai 46', '1999-02-09', 'Perempuan', 'Katolik', NULL, 2, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (68, NULL, '00000047', 'Pegawai 47', '1996-10-03', 'Perempuan', 'Buddha', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (69, NULL, '00000048', 'Pegawai 48', '1985-05-27', 'Perempuan', 'Islam', NULL, 1, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (70, NULL, '00000049', 'Pegawai 49', '1992-04-11', 'Laki-laki', 'Konghucu', NULL, 4, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (71, NULL, '00000050', 'Pegawai 50', '1986-12-08', 'Laki-laki', 'Konghucu', NULL, 1, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (72, NULL, '00000051', 'Pegawai 51', '2005-08-05', 'Laki-laki', 'Katolik', NULL, 6, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (73, NULL, '00000052', 'Pegawai 52', '1989-04-29', 'Perempuan', 'Hindu', NULL, 7, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (74, NULL, '00000053', 'Pegawai 53', '1984-04-20', 'Perempuan', 'Konghucu', NULL, 7, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (75, NULL, '00000054', 'Pegawai 54', '1989-01-23', 'Perempuan', 'Katolik', NULL, 3, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (76, NULL, '00000055', 'Pegawai 55', '1985-03-13', 'Laki-laki', 'Islam', NULL, 2, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (77, NULL, '00000056', 'Pegawai 56', '2003-08-26', 'Perempuan', 'Konghucu', NULL, 6, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (78, NULL, '00000057', 'Pegawai 57', '1999-09-15', 'Laki-laki', 'Katolik', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (79, NULL, '00000058', 'Pegawai 58', '1987-07-16', 'Laki-laki', 'Katolik', NULL, 1, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (80, NULL, '00000059', 'Pegawai 59', '1999-12-11', 'Laki-laki', 'Hindu', NULL, 7, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (81, NULL, '00000060', 'Pegawai 60', '1991-03-31', 'Perempuan', 'Islam', NULL, 2, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (82, NULL, '00000061', 'Pegawai 61', '1993-11-11', 'Perempuan', 'Kristen', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (83, NULL, '00000062', 'Pegawai 62', '1996-10-12', 'Perempuan', 'Kristen', NULL, 3, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (84, NULL, '00000063', 'Pegawai 63', '1994-11-26', 'Perempuan', 'Buddha', NULL, 7, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (85, NULL, '00000064', 'Pegawai 64', '1991-07-20', 'Laki-laki', 'Hindu', NULL, 5, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (86, NULL, '00000065', 'Pegawai 65', '1988-02-02', 'Perempuan', 'Katolik', NULL, 6, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (87, NULL, '00000066', 'Pegawai 66', '1996-08-03', 'Perempuan', 'Konghucu', NULL, 7, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (88, NULL, '00000067', 'Pegawai 67', '1997-03-22', 'Laki-laki', 'Islam', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (89, NULL, '00000068', 'Pegawai 68', '1996-05-06', 'Laki-laki', 'Hindu', NULL, 6, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (90, NULL, '00000069', 'Pegawai 69', '1993-01-02', 'Perempuan', 'Buddha', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (91, NULL, '00000070', 'Pegawai 70', '1998-02-17', 'Perempuan', 'Katolik', NULL, 6, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (92, NULL, '00000071', 'Pegawai 71', '2000-05-15', 'Laki-laki', 'Hindu', NULL, 1, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (93, NULL, '00000072', 'Pegawai 72', '1993-03-02', 'Perempuan', 'Katolik', NULL, 4, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (94, NULL, '00000073', 'Pegawai 73', '1999-02-14', 'Laki-laki', 'Hindu', NULL, 5, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (95, NULL, '00000074', 'Pegawai 74', '1990-02-07', 'Laki-laki', 'Katolik', NULL, 6, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (96, NULL, '00000075', 'Pegawai 75', '1983-11-28', 'Perempuan', 'Hindu', NULL, 3, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (97, NULL, '00000076', 'Pegawai 76', '2000-01-19', 'Laki-laki', 'Katolik', NULL, 3, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (98, NULL, '00000077', 'Pegawai 77', '1980-09-27', 'Perempuan', 'Islam', NULL, 4, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (99, NULL, '00000078', 'Pegawai 78', '1983-09-25', 'Perempuan', 'Kristen', NULL, 7, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (100, NULL, '00000079', 'Pegawai 79', '2004-05-29', 'Perempuan', 'Katolik', NULL, 7, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (101, NULL, '00000080', 'Pegawai 80', '2000-05-08', 'Laki-laki', 'Kristen', NULL, 4, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (102, NULL, '00000081', 'Pegawai 81', '1988-04-10', 'Laki-laki', 'Islam', NULL, 1, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (103, NULL, '00000082', 'Pegawai 82', '1998-11-19', 'Perempuan', 'Islam', NULL, 7, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (104, NULL, '00000083', 'Pegawai 83', '2004-03-28', 'Perempuan', 'Islam', NULL, 2, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (105, NULL, '00000084', 'Pegawai 84', '1999-06-29', 'Perempuan', 'Konghucu', NULL, 4, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (106, NULL, '00000085', 'Pegawai 85', '2004-06-05', 'Laki-laki', 'Konghucu', NULL, 4, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (107, NULL, '00000086', 'Pegawai 86', '1998-12-13', 'Laki-laki', 'Buddha', NULL, 6, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (108, NULL, '00000087', 'Pegawai 87', '1993-10-19', 'Laki-laki', 'Buddha', NULL, 5, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (109, NULL, '00000088', 'Pegawai 88', '1992-12-14', 'Perempuan', 'Islam', NULL, 6, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (110, NULL, '00000089', 'Pegawai 89', '2005-07-30', 'Perempuan', 'Buddha', NULL, 1, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (111, NULL, '00000090', 'Pegawai 90', '1984-07-16', 'Perempuan', 'Buddha', NULL, 2, 1, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:51', 1);
INSERT INTO `tbl_pegawai` VALUES (112, NULL, '00000091', 'Pegawai 91', '1994-10-16', 'Perempuan', 'Hindu', NULL, 5, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (113, NULL, '00000092', 'Pegawai 92', '1986-08-21', 'Laki-laki', 'Konghucu', NULL, 1, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (114, NULL, '00000093', 'Pegawai 93', '1997-02-03', 'Laki-laki', 'Kristen', NULL, 5, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (115, NULL, '00000094', 'Pegawai 94', '1997-11-21', 'Perempuan', 'Kristen', NULL, 4, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (116, NULL, '00000095', 'Pegawai 95', '2002-10-12', 'Perempuan', 'Katolik', NULL, 3, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (117, NULL, '00000096', 'Pegawai 96', '1984-05-01', 'Perempuan', 'Kristen', NULL, 4, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (118, NULL, '00000097', 'Pegawai 97', '1998-10-07', 'Perempuan', 'Konghucu', NULL, 4, 4, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (119, NULL, '00000098', 'Pegawai 98', '1986-04-23', 'Perempuan', 'Kristen', NULL, 1, 2, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (120, NULL, '00000099', 'Pegawai 99', '1987-04-02', 'Perempuan', 'Hindu', NULL, 5, 5, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);
INSERT INTO `tbl_pegawai` VALUES (121, NULL, '00000100', 'Pegawai 100', '1982-09-28', 'Laki-laki', 'Buddha', NULL, 4, 3, 1, '2026-05-12 03:40:05', 1, '2026-05-12 03:40:52', 1);

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `password` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `nama` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT 1,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_user_pegawai`(`id_pegawai` ASC) USING BTREE,
  CONSTRAINT `fk_user_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `tbl_pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES (1, 1, 'bahtiardeni@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Deni Bahtiar', 1, '2024-10-07 15:32:33', 1, '2026-05-11 20:59:22', 1);
INSERT INTO `tbl_users` VALUES (23, 22, 'pegawai1@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, '2026-05-11 20:59:48', 1, '2026-05-11 20:59:48', 1);

SET FOREIGN_KEY_CHECKS = 1;

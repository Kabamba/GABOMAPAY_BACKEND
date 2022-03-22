-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 21 mars 2022 à 16:49
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gaboma_pay`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte_gabon_to_gabons`
--

DROP TABLE IF EXISTS `compte_gabon_to_gabons`;
CREATE TABLE IF NOT EXISTS `compte_gabon_to_gabons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `recever_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compte_gabon_to_gabons_transaction_id_foreign` (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_gabon_to_gabons`
--

INSERT INTO `compte_gabon_to_gabons` (`id`, `transaction_id`, `recever_id`, `created_at`, `updated_at`) VALUES
(1, 2, 16, '2022-03-18 10:44:09', '2022-03-18 10:44:09'),
(2, 3, 16, '2022-03-18 11:10:40', '2022-03-18 11:10:40');

-- --------------------------------------------------------

--
-- Structure de la table `compte_to_compte_rdcs`
--

DROP TABLE IF EXISTS `compte_to_compte_rdcs`;
CREATE TABLE IF NOT EXISTS `compte_to_compte_rdcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `recever_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compte_to_compte_rdcs_transaction_id_foreign` (`transaction_id`),
  KEY `compte_to_compte_rdcs_recever_id_foreign` (`recever_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_to_compte_rdcs`
--

INSERT INTO `compte_to_compte_rdcs` (`id`, `transaction_id`, `recever_id`, `created_at`, `updated_at`) VALUES
(1, 1, 14, '2022-03-17 11:05:01', '2022-03-17 11:05:01');

-- --------------------------------------------------------

--
-- Structure de la table `compte_to_mobile_rdcs`
--

DROP TABLE IF EXISTS `compte_to_mobile_rdcs`;
CREATE TABLE IF NOT EXISTS `compte_to_mobile_rdcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `operator_id` bigint(20) UNSIGNED NOT NULL,
  `recever_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_total` double(8,2) NOT NULL,
  `pourcentage` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compte_to_mobile_rdcs_operator_id_foreign` (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numcode` int(11) DEFAULT NULL,
  `phonecode` int(11) NOT NULL,
  `devise_id` bigint(20) UNSIGNED NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `countries_devise_id_foreign` (`devise_id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `devise_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, 3, NULL, NULL, 1),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, 3, NULL, NULL, 1),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, 3, NULL, NULL, 1),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, 3, NULL, NULL, 1),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, 3, NULL, NULL, 1),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, 3, NULL, NULL, 1),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, 3, NULL, NULL, 1),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0, 3, NULL, NULL, 1),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, 3, NULL, NULL, 1),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, 3, NULL, NULL, 1),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, 3, NULL, NULL, 1),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, 3, NULL, NULL, 1),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, 3, NULL, NULL, 1),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, 3, NULL, NULL, 1),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, 3, NULL, NULL, 1),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, 3, NULL, NULL, 1),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, 3, NULL, NULL, 1),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, 3, NULL, NULL, 1),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, 3, NULL, NULL, 1),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, 3, NULL, NULL, 1),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, 3, NULL, NULL, 1),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, 3, NULL, NULL, 1),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, 3, NULL, NULL, 1),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, 3, NULL, NULL, 1),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, 3, NULL, NULL, 1),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, 3, NULL, NULL, 1),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, 3, NULL, NULL, 1),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, 3, NULL, NULL, 1),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0, 3, NULL, NULL, 1),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, 3, NULL, NULL, 1),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246, 3, NULL, NULL, 1),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, 3, NULL, NULL, 1),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, 3, NULL, NULL, 1),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, 3, NULL, NULL, 1),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, 3, NULL, NULL, 1),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, 3, NULL, NULL, 1),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, 3, NULL, NULL, 1),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, 3, NULL, NULL, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, 3, NULL, NULL, 1),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, 3, NULL, NULL, 1),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, 3, NULL, NULL, 1),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, 3, NULL, NULL, 1),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, 3, NULL, NULL, 1),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, 3, NULL, NULL, 1),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61, 3, NULL, NULL, 1),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672, 3, NULL, NULL, 1),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, 3, NULL, NULL, 1),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, 3, NULL, NULL, 1),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, 3, NULL, NULL, 1),
(50, 'CD', 'DEMOCRATIC REPUBLIC OF CONGO', 'Democratic Republic of congo', 'COD', 180, 243, 3, NULL, NULL, 1),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, 3, NULL, NULL, 1),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, 3, NULL, NULL, 1),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225, 3, NULL, NULL, 1),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, 3, NULL, NULL, 1),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, 3, NULL, NULL, 1),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, 3, NULL, NULL, 1),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, 3, NULL, NULL, 1),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, 3, NULL, NULL, 1),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, 3, NULL, NULL, 1),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, 3, NULL, NULL, 1),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, 3, NULL, NULL, 1),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, 3, NULL, NULL, 1),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, 3, NULL, NULL, 1),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, 3, NULL, NULL, 1),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, 3, NULL, NULL, 1),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, 3, NULL, NULL, 1),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, 3, NULL, NULL, 1),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, 3, NULL, NULL, 1),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, 3, NULL, NULL, 1),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, 3, NULL, NULL, 1),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, 3, NULL, NULL, 1),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, 3, NULL, NULL, 1),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, 3, NULL, NULL, 1),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, 3, NULL, NULL, 1),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, 3, NULL, NULL, 1),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0, 3, NULL, NULL, 1),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, 1, NULL, NULL, 1),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, 3, NULL, NULL, 1),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, 3, NULL, NULL, 1),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, 3, NULL, NULL, 1),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, 3, NULL, NULL, 1),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, 3, NULL, NULL, 1),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, 3, NULL, NULL, 1),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, 3, NULL, NULL, 1),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, 3, NULL, NULL, 1),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, 3, NULL, NULL, 1),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, 3, NULL, NULL, 1),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, 3, NULL, NULL, 1),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, 3, NULL, NULL, 1),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, 3, NULL, NULL, 1),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, 3, NULL, NULL, 1),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, 3, NULL, NULL, 1),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0, 3, NULL, NULL, 1),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, 3, NULL, NULL, 1),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, 3, NULL, NULL, 1),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, 3, NULL, NULL, 1),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, 3, NULL, NULL, 1),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, 3, NULL, NULL, 1),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, 3, NULL, NULL, 1),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, 3, NULL, NULL, 1),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, 3, NULL, NULL, 1),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, 3, NULL, NULL, 1),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, 3, NULL, NULL, 1),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, 3, NULL, NULL, 1),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, 3, NULL, NULL, 1),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, 3, NULL, NULL, 1),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, 3, NULL, NULL, 1),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, 3, NULL, NULL, 1),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, 3, NULL, NULL, 1),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, 3, NULL, NULL, 1),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, 3, NULL, NULL, 1),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850, 3, NULL, NULL, 1),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, 3, NULL, NULL, 1),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, 3, NULL, NULL, 1),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, 3, NULL, NULL, 1),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856, 3, NULL, NULL, 1),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, 3, NULL, NULL, 1),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, 3, NULL, NULL, 1),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, 3, NULL, NULL, 1),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, 3, NULL, NULL, 1),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, 3, NULL, NULL, 1),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, 3, NULL, NULL, 1),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, 3, NULL, NULL, 1),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, 3, NULL, NULL, 1),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, 3, NULL, NULL, 1),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, 3, NULL, NULL, 1),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, 3, NULL, NULL, 1),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, 3, NULL, NULL, 1),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, 3, NULL, NULL, 1),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, 3, NULL, NULL, 1),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, 3, NULL, NULL, 1),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, 3, NULL, NULL, 1),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, 3, NULL, NULL, 1),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, 3, NULL, NULL, 1),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, 3, NULL, NULL, 1),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, 3, NULL, NULL, 1),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269, 3, NULL, NULL, 1),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, 3, NULL, NULL, 1),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, 3, NULL, NULL, 1),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, 3, NULL, NULL, 1),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, 3, NULL, NULL, 1),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, 3, NULL, NULL, 1),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, 3, NULL, NULL, 1),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, 3, NULL, NULL, 1),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, 3, NULL, NULL, 1),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, 3, NULL, NULL, 1),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, 3, NULL, NULL, 1),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, 3, NULL, NULL, 1),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, 3, NULL, NULL, 1),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, 3, NULL, NULL, 1),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, 3, NULL, NULL, 1),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, 3, NULL, NULL, 1),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, 3, NULL, NULL, 1),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, 3, NULL, NULL, 1),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, 3, NULL, NULL, 1),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, 3, NULL, NULL, 1),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, 3, NULL, NULL, 1),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, 3, NULL, NULL, 1),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, 3, NULL, NULL, 1),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, 3, NULL, NULL, 1),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, 3, NULL, NULL, 1),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, 3, NULL, NULL, 1),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, 3, NULL, NULL, 1),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970, 3, NULL, NULL, 1),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, 3, NULL, NULL, 1),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, 3, NULL, NULL, 1),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, 3, NULL, NULL, 1),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, 3, NULL, NULL, 1),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, 3, NULL, NULL, 1),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, 3, NULL, NULL, 1),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, 3, NULL, NULL, 1),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, 3, NULL, NULL, 1),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, 3, NULL, NULL, 1),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, 3, NULL, NULL, 1),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, 3, NULL, NULL, 1),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, 3, NULL, NULL, 1),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, 3, NULL, NULL, 1),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, 3, NULL, NULL, 1),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, 3, NULL, NULL, 1),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, 3, NULL, NULL, 1),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, 3, NULL, NULL, 1),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, 3, NULL, NULL, 1),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, 3, NULL, NULL, 1),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, 3, NULL, NULL, 1),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, 3, NULL, NULL, 1),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, 3, NULL, NULL, 1),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, 3, NULL, NULL, 1),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, 3, NULL, NULL, 1),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381, 3, NULL, NULL, 1),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, 3, NULL, NULL, 1),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, 3, NULL, NULL, 1),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, 3, NULL, NULL, 1),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, 3, NULL, NULL, 1),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, 3, NULL, NULL, 1),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, 3, NULL, NULL, 1),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, 3, NULL, NULL, 1),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, 3, NULL, NULL, 1),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0, 3, NULL, NULL, 1),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, 3, NULL, NULL, 1),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, 3, NULL, NULL, 1),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, 3, NULL, NULL, 1),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, 3, NULL, NULL, 1),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, 3, NULL, NULL, 1),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, 3, NULL, NULL, 1),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, 3, NULL, NULL, 1),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, 3, NULL, NULL, 1),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, 3, NULL, NULL, 1),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, 3, NULL, NULL, 1),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, 3, NULL, NULL, 1),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, 3, NULL, NULL, 1),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, 3, NULL, NULL, 1),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670, 3, NULL, NULL, 1),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, 3, NULL, NULL, 1),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, 3, NULL, NULL, 1),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, 3, NULL, NULL, 1),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, 3, NULL, NULL, 1),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, 3, NULL, NULL, 1),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, 3, NULL, NULL, 1),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, 3, NULL, NULL, 1),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, 3, NULL, NULL, 1),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, 3, NULL, NULL, 1),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, 3, NULL, NULL, 1),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, 3, NULL, NULL, 1),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, 3, NULL, NULL, 1),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, 3, NULL, NULL, 1),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, 3, NULL, NULL, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1, 3, NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, 3, NULL, NULL, 1),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, 3, NULL, NULL, 1),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, 3, NULL, NULL, 1),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, 3, NULL, NULL, 1),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, 3, NULL, NULL, 1),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, 3, NULL, NULL, 1),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, 3, NULL, NULL, 1),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, 3, NULL, NULL, 1),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, 3, NULL, NULL, 1),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, 3, NULL, NULL, 1),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, 3, NULL, NULL, 1),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, 3, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `depot_gabons`
--

DROP TABLE IF EXISTS `depot_gabons`;
CREATE TABLE IF NOT EXISTS `depot_gabons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `billing_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentsystem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `depot_gabons_transaction_id_foreign` (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `depot_rdcs`
--

DROP TABLE IF EXISTS `depot_rdcs`;
CREATE TABLE IF NOT EXISTS `depot_rdcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant_total` float NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `capture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator_id` int(11) NOT NULL,
  `pourcentage` float NOT NULL,
  `montant_frais` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `depot_rdcs_transaction_id_foreign` (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devises`
--

DROP TABLE IF EXISTS `devises`;
CREATE TABLE IF NOT EXISTS `devises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbole` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `devises`
--

INSERT INTO `devises` (`id`, `libelle`, `symbole`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Francs CFA', 'CFA', '2022-01-01 07:40:21', '2022-03-18 12:08:41', 1),
(2, 'Euros', '€', '2022-01-01 07:41:21', '2022-01-01 08:15:12', 1),
(3, 'Dollars', '$', '2022-01-06 09:40:25', '2022-03-18 12:22:28', 1),
(4, 'Francs congolais', 'FC', NULL, NULL, 1),
(5, 'YEN', 'YN', '2022-01-14 07:33:15', '2022-01-14 07:34:50', 1),
(6, 'Amsterdam', '$', '2022-02-10 14:09:09', '2022-02-10 14:09:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gabon_to_mobile_rdcs`
--

DROP TABLE IF EXISTS `gabon_to_mobile_rdcs`;
CREATE TABLE IF NOT EXISTS `gabon_to_mobile_rdcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `operator_id` bigint(20) UNSIGNED NOT NULL,
  `montant_total` double(8,2) NOT NULL,
  `montant_convertit` double(8,2) NOT NULL,
  `pourcentage_int` double(8,2) NOT NULL,
  `pourcentage_operator` double(8,2) NOT NULL,
  `taux_convers` double(8,2) NOT NULL,
  `recever_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gabon_to_mobile_rdcs_transaction_id_foreign` (`transaction_id`),
  KEY `gabon_to_mobile_rdcs_operator_id_foreign` (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(13, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(14, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(15, '2016_06_01_000004_create_oauth_clients_table', 1),
(16, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(17, '2019_08_19_000000_create_failed_jobs_table', 1),
(18, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(19, '2021_12_31_182445_create_devises_table', 2),
(20, '2022_01_01_001625_create_posts_table', 3),
(21, '2022_01_02_224223_create_countries_table', 4),
(22, '2022_01_05_232529_create_transacrtions_table', 5),
(23, '2022_02_04_215848_create_operators_table', 6),
(24, '2022_02_05_133815_create_tarifs_table', 7),
(25, '2022_02_07_151319_create_tauxes_table', 8),
(26, '2022_02_08_160036_create_depot_gabons_table', 9),
(27, '2022_02_08_165954_create_depot_rdcs_table', 10),
(28, '2022_02_08_173233_create_compte_to_compte_rdcs_table', 11),
(29, '2022_02_08_175037_create_compte_to_mobile_rdcs_table', 12),
(30, '2022_02_08_190716_create_compte_rdc_to_gabons_table', 13),
(31, '2022_02_08_192818_create_compte_gabon_to_gabons_table', 14),
(32, '2022_02_08_194533_create_gabon_to_mobile_rdcs_table', 15),
(33, '2022_02_08_204512_create_compte_gabon_to_rdcs_table', 16),
(34, '2022_02_10_093150_create_retrait_rdcs_table', 17),
(35, '2022_02_27_173109_create_players_table', 18),
(36, '2022_02_27_173644_create_player_images_table', 18),
(37, '2022_02_27_174406_create_positions_table', 18);

-- --------------------------------------------------------

--
-- Structure de la table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('85c435534972e651fc44d70cd1f01ca071c1c511d38e531950a50b92e409cdcc5be0011bbbc122fb', 6, 3, 'Antoinette Lejeune', '[]', 0, '2022-03-03 21:25:12', '2022-03-03 21:25:12', '2022-04-03 22:25:12'),
('df737928814550724342a52327df2bb7932c25704db21db6adcb1aff93fb32662ddeff04b162a4f6', 14, 3, 'Kabamba', '[]', 0, '2022-03-18 11:37:48', '2022-03-18 11:37:48', '2022-04-18 12:37:48'),
('c366ed2283bdedb286d63b489e6b7ffac66526487e0e9076cdb36d9a0d8201bde01b796f822a09d3', 1, 3, 'Charlotte Lombard', '[]', 0, '2022-03-18 11:21:46', '2022-03-18 11:21:46', '2022-04-18 12:21:46'),
('c8a0294e429a2ce7f89753508e6b4b0382ddbf9be8fe1dcb8a76c0b5d6b660e905ba7b3e49c37ae7', 14, 3, 'Kabamba', '[]', 0, '2022-03-18 12:11:12', '2022-03-18 12:11:12', '2022-04-18 13:11:12'),
('5235165295e4eeade8ec61013bc4c6b16169e0926ff1c951408a2097f51227ff1fdf32984162c5fd', 14, 3, 'Kabamba', '[]', 0, '2022-03-18 12:11:21', '2022-03-18 12:11:21', '2022-04-18 13:11:21'),
('eea577f5be4d91cb0dffb261e92808ce954d625da8f2a311abcc6b7eace6d93a6d404c560def2e17', 1, 3, 'Charlotte Lombard', '[]', 0, '2022-03-18 11:23:54', '2022-03-18 11:23:54', '2022-04-18 12:23:54'),
('e6830c54e2b6b8e467aefe0ad52266dc7420e31ac0bd968bf60d1ceac1da5b9cec7c8b9177a0daff', 1, 3, 'Charlotte Lombard', '[]', 0, '2022-03-18 11:26:38', '2022-03-18 11:26:38', '2022-04-18 12:26:38'),
('fee23b3ca592292378456113a7709e6cb8ae87bc44c3b9e85f142db7ea082e8c12cc4daf41d7d64a', 1, 3, 'Charlotte Lombard', '[]', 0, '2022-03-18 11:27:39', '2022-03-18 11:27:39', '2022-04-18 12:27:39'),
('8a4a1bb61ffa94865696b38dcd11b05d4e0cddcde47e5888c52ca7be88db1a67e12e2b83cd879b32', 23, 3, 'Mulamba', '[]', 0, '2022-01-18 09:54:15', '2022-01-18 09:54:15', '2022-02-18 01:54:15'),
('f490208d836063e9903c825dd32e8254efd29be4f7a1f5c2b4d4de1dfc51df1476bd4a29f5ec5953', 24, 3, 'Kabamba', '[]', 0, '2022-01-18 10:31:01', '2022-01-18 10:31:01', '2022-02-18 02:31:01'),
('4ccbb282337f3399546a298184e2d8c5725f0b37c241cb279ab9df03f530428868262f0c403a249a', 25, 3, 'Kabamba', '[]', 0, '2022-01-18 10:35:29', '2022-01-18 10:35:29', '2022-02-18 02:35:29'),
('75d4688c25d294236a1ed3ec0b3fe4b764913d181f12d0721abc78d771bdda10042eb2d5ce1e9804', 26, 3, 'Kabamba', '[]', 0, '2022-01-18 10:38:13', '2022-01-18 10:38:13', '2022-02-18 02:38:13'),
('0db7cc61b2efd857cc9e9f1f84b151ed9e874ca77053afaf53bb7fbd98a4f0401ffd9562354d2dd3', 27, 3, 'Kabamba', '[]', 0, '2022-01-18 10:40:58', '2022-01-18 10:40:58', '2022-02-18 02:40:58'),
('19f70675d8d267b30a8823da9f471cf95cae5a86e31c4ea968a7d30c1dff07a900d50630ca50f068', 28, 3, 'Kabamba', '[]', 0, '2022-01-20 09:06:25', '2022-01-20 09:06:25', '2022-02-20 01:06:25'),
('4471bc63242ef0e974aa036d441f490b38772219d81493dd88b14cba627031ff80bc38ba335361cb', 6, 3, 'Antoinette Lejeune', '[]', 0, '2022-02-16 08:49:21', '2022-02-16 08:49:21', '2022-03-16 09:49:21'),
('6396e6589ea634e1af803c433e7272fd670643fbdf76922fcf123004410e4e052ffbb844d77bd651', 2, 3, 'Kabamba', '[]', 0, '2022-02-04 20:49:24', '2022-02-04 20:49:24', '2022-03-04 21:49:24'),
('0a9e3aa90a2a05e4db1a2bf3570569d78be093ede98f4854db76ce47dbcfa4306c2bfff49ef4560e', 5, 3, 'Jean Leroux', '[]', 0, '2022-02-10 19:15:58', '2022-02-10 19:15:58', '2022-03-10 20:15:58');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'Rj9WUU9WYnZkKiQn5lgL4T0ERpGk5GcZKgDPGF28', NULL, 'http://localhost', 1, 0, 0, '2022-01-11 06:54:14', '2022-01-11 06:54:14'),
(2, NULL, 'Laravel Password Grant Client', 'CV3hN5JbSsbU0UYL8v3ZxuQUP84VEwO8AwC65jEX', 'users', 'http://localhost', 0, 1, 0, '2022-01-11 06:54:14', '2022-01-11 06:54:14'),
(3, NULL, 'Laravel Personal Access Client', 'oXyRxNfNo19hVBld00eo9KZ0krUVrskB6yGTms8r', NULL, 'http://localhost', 1, 0, 0, '2022-01-11 07:19:40', '2022-01-11 07:19:40'),
(4, NULL, 'Laravel Password Grant Client', 'vaMuimkewoCJfj64H0gNaFLC5RlMbXT4aktz4ZAs', 'users', 'http://localhost', 0, 1, 0, '2022-01-11 07:19:40', '2022-01-11 07:19:40');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-12-30 06:40:43', '2021-12-30 06:40:43'),
(2, 3, '2022-01-11 06:15:38', '2022-01-11 06:15:38'),
(3, 1, '2022-01-11 06:54:14', '2022-01-11 06:54:14'),
(4, 3, '2022-01-11 07:19:40', '2022-01-11 07:19:40');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `operators`
--

DROP TABLE IF EXISTS `operators`;
CREATE TABLE IF NOT EXISTS `operators` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `min` float NOT NULL DEFAULT '10',
  `max` float NOT NULL DEFAULT '1000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `operators`
--

INSERT INTO `operators` (`id`, `libelle`, `agent_number`, `is_active`, `min`, `max`, `created_at`, `updated_at`) VALUES
(1, 'M-pesa', '+243812277379', 1, 10, 1500, '2022-02-04 21:07:56', '2022-03-18 12:09:02'),
(2, 'Orange money', '+243852277379', 1, 10, 1000, '2022-02-05 12:20:05', '2022-02-05 12:20:05'),
(3, 'Airtel money', '+243992277379', 1, 10, 1000, '2022-02-05 12:20:34', '2022-02-05 12:20:34'),
(4, 'Afrimoney', '+243902277379', 1, 10, 1000, '2022-02-05 12:21:17', '2022-02-05 12:21:17');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ban@gmail.com', 'Hn1GsyI0IN', '2022-03-03 22:09:09');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chemin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `description`, `chemin`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'icone_192x192_163428792_1647609061.webp', 1, '2022-03-18 12:11:01', '2022-03-18 12:11:01');

-- --------------------------------------------------------

--
-- Structure de la table `retrait_rdcs`
--

DROP TABLE IF EXISTS `retrait_rdcs`;
CREATE TABLE IF NOT EXISTS `retrait_rdcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `operator_id` bigint(20) UNSIGNED NOT NULL,
  `recever_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_total` double(8,2) NOT NULL,
  `pourcentage` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `retrait_rdcs_transaction_id_foreign` (`transaction_id`),
  KEY `retrait_rdcs_operator_id_foreign` (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

DROP TABLE IF EXISTS `tarifs`;
CREATE TABLE IF NOT EXISTS `tarifs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `frais_ope` float NOT NULL,
  `frais_perso` float NOT NULL,
  `operator_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarifs_operator_id_foreign` (`operator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `frais_ope`, `frais_perso`, `operator_id`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 1, '2022-02-20 02:01:36', '2022-02-20 02:01:36'),
(2, 2, 3, 2, '2022-02-20 02:01:53', '2022-02-20 02:01:53'),
(3, 2, 1, 3, '2022-02-20 02:02:04', '2022-02-20 02:02:04'),
(4, 3, 3, 4, '2022-02-20 02:02:16', '2022-02-20 02:02:16');

-- --------------------------------------------------------

--
-- Structure de la table `tauxes`
--

DROP TABLE IF EXISTS `tauxes`;
CREATE TABLE IF NOT EXISTS `tauxes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux_change` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tauxes`
--

INSERT INTO `tauxes` (`id`, `libelle`, `taux_change`, `created_at`, `updated_at`) VALUES
(1, 'TAUX DE CONVERSION FCFA', '578.50', NULL, '2022-02-20 00:54:18'),
(2, 'FRAIS DE TRANSFERT RDC - GABON', '3.00', NULL, NULL),
(3, 'FRAIS DE TRANSFERT GABON - RDC', '2.00', NULL, '2022-02-20 00:54:06');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` float NOT NULL,
  `date_trans` date DEFAULT NULL,
  `date_time_trans` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `type_trans` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `second_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `raison` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `transacrtions_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `montant`, `date_trans`, `date_time_trans`, `reference`, `status`, `type_trans`, `user_id`, `second_id`, `created_at`, `updated_at`, `country_id`, `raison`) VALUES
(1, 100, '2022-03-17', '2022-03-17 13:05:00', '623323ecdc379', 1, 3, 17, 14, '2022-03-17 11:05:00', '2022-03-17 11:05:00', 50, NULL),
(2, 100000, '2022-03-18', '2022-03-18 12:44:09', '623470897113c', 1, 5, 18, 16, '2022-03-18 10:44:09', '2022-03-18 10:44:09', 77, NULL),
(3, 20000, '2022-03-18', '2022-03-18 13:10:40', '623476c0a9286', 1, 5, 18, 16, '2022-03-18 11:10:40', '2022-03-18 11:10:40', 77, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `identite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `solde` float NOT NULL DEFAULT '0',
  `admin_level` int(11) NOT NULL DEFAULT '2',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0123456789',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `prenom`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `is_active`, `identite`, `sexe`, `adresse`, `profile`, `country_id`, `solde`, `admin_level`, `phone`) VALUES
(1, 'Charlotte Lombard', 'Matuidi', 'francois21@example.net', '2022-02-07 16:57:39', '$2y$10$9AS9tlSnXCL.34gS7I/tkeWEKnyOht.EY9AEPdYV28Vzn129DraIO', 1, 'RDueOfUE8B', '2022-02-07 16:57:40', '2022-03-18 11:19:56', 1, NULL, 'M', NULL, NULL, 50, 0, 2, '0123456789'),
(18, 'Moanda', 'JP', 'moand@gmail.com', NULL, '$2y$10$5f27Dsr504Tq.e8clkhGfO18cVbcVDwh2S0GiXRNinS5SOL/FI0Cm', 2, NULL, '2022-03-18 10:41:55', '2022-03-18 11:10:40', 1, NULL, NULL, NULL, NULL, 77, 380000, 2, '012365476'),
(15, 'Andorra', 'Andorra', 'andorra@gmail.com', NULL, '$2y$10$uJc1JxCALNUyo2VggC7QBuFpgYsS9FQoGS44KldDE4S1DOx4ekyNy', 2, NULL, '2022-03-15 13:30:15', '2022-03-15 13:30:15', 1, NULL, NULL, NULL, NULL, 81, 0, 2, '0840397611'),
(16, 'Gabon', 'Gabon', 'gabon@gmail.com', NULL, '$2y$10$pDXM1il6nejCBrzUHY2exO7Vaq66niNDOFkojW5gfnGisqjQjzfU6', 2, NULL, '2022-03-17 10:08:42', '2022-03-18 11:10:40', 1, NULL, NULL, NULL, NULL, 77, 120000, 2, '081099178'),
(17, 'congo', 'congo', 'congo@gmail.com', NULL, '$2y$10$IWAQDdUfUKjof9dZQMv2OO84aEcU0eXanWExT/8X99MEnt11rRzJm', 2, NULL, '2022-03-17 10:26:48', '2022-03-17 11:05:00', 1, NULL, NULL, NULL, NULL, 50, 400, 2, '0852277375'),
(14, 'Kabamba', 'Enock', 'enockmulamba1802@gmail.com', NULL, '$2y$10$RawJClqAzC9uaGq1mbwKyejlzuRsCz/nCQ/jt6y49Mx/3O.OoqN/6', 2, NULL, '2022-03-12 10:50:28', '2022-03-18 12:51:11', 1, NULL, 'null', 'null', '512x512_2_2048086459_1647611471.webp', 50, 100, 2, '0852277379');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 20:41:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `revive`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment_replies`
--

CREATE TABLE `comment_replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contributors`
--

CREATE TABLE `contributors` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id` int(11) NOT NULL,
  `mediaID` int(11) NOT NULL,
  `ContributorID` int(11) NOT NULL,
  `departamento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `last_active_timestamp` datetime DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `register_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devices`
--

INSERT INTO `devices` (`id`, `user_id`, `device_name`, `last_active_timestamp`, `token`, `register_at`) VALUES
(1, 42, 'Lotfi', '2025-05-17 00:29:40', 'fc54aab5b3947932f018', NULL),
(2, 42, 'Lotfi', '2025-05-17 00:29:51', 'b19050742b6df04996e7', NULL),
(3, 42, 'Lotfi', '2025-05-17 10:15:40', '79874082d9aa42cca174984e82fc89aadb469e5821f6ccfff0c917dd1e0db805', NULL),
(4, 41, 'Desconocido - Desconocido', '2025-05-17 18:17:08', '5ee5216be23502bea334f411c6a184d17cb3fce537c4f02a24b886b5024bc850', '2025-05-17 18:17:08'),
(5, 42, 'Windows - WebKit', '2025-05-17 18:18:07', '383927f68c0b70a13fe274d301a18885ce380da86518d0afb4d976a9728b951a', '2025-05-17 18:18:07'),
(6, 42, 'Windows - WebKit', '2025-05-17 18:38:40', 'b6e07169a60e7f27a647d30c7d773d6b9849ad40dcce6779a302c617fbaeb54e', '2025-05-17 18:38:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `media_id` int(11) NOT NULL,
  `episode_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `episodes`
--

INSERT INTO `episodes` (`id`, `season_id`, `media_id`, `episode_number`) VALUES
(636, 73, 758, 1),
(637, 73, 759, 2),
(638, 73, 761, 3),
(639, 73, 762, 4),
(640, 74, 763, 1),
(641, 73, 765, 5),
(642, 74, 766, 2),
(643, 75, 768, 1),
(644, 73, 769, 6),
(645, 74, 770, 3),
(646, 73, 771, 7),
(647, 75, 772, 2),
(648, 76, 773, 1),
(649, 73, 774, 8),
(650, 74, 775, 4),
(651, 75, 776, 3),
(652, 74, 777, 5),
(653, 75, 778, 4),
(654, 76, 779, 2),
(655, 75, 780, 5),
(656, 76, 781, 3),
(657, 74, 782, 6),
(658, 75, 783, 6),
(659, 75, 784, 7),
(660, 76, 785, 4),
(661, 74, 786, 7),
(662, 75, 787, 8),
(663, 76, 788, 5),
(664, 74, 789, 8),
(665, 75, 790, 9),
(666, 76, 791, 6),
(667, 74, 792, 9),
(668, 75, 793, 10),
(669, 76, 794, 7),
(670, 74, 795, 10),
(671, 76, 796, 8),
(672, 75, 797, 11),
(673, 74, 798, 11),
(674, 76, 799, 9),
(675, 75, 800, 12),
(676, 76, 801, 10),
(677, 75, 802, 13),
(678, 74, 803, 12),
(679, 76, 804, 11),
(680, 76, 805, 12),
(681, 77, 808, 1),
(682, 77, 810, 2),
(683, 77, 811, 3),
(684, 78, 812, 1),
(685, 77, 814, 4),
(686, 78, 815, 2),
(687, 77, 816, 5),
(688, 78, 817, 3),
(689, 77, 818, 6),
(690, 78, 819, 4),
(691, 77, 820, 7),
(692, 78, 821, 5),
(693, 79, 822, 1),
(694, 77, 823, 8),
(695, 78, 824, 6),
(696, 79, 825, 2),
(697, 77, 826, 9),
(698, 79, 828, 3),
(699, 77, 829, 10),
(700, 79, 830, 4),
(701, 80, 832, 1),
(702, 77, 833, 11),
(703, 79, 834, 5),
(704, 81, 835, 1),
(705, 80, 836, 2),
(706, 79, 837, 6),
(707, 77, 838, 12),
(708, 81, 839, 2),
(709, 80, 840, 3),
(710, 77, 841, 13),
(711, 81, 842, 3),
(712, 79, 843, 7),
(713, 77, 844, 14),
(714, 81, 845, 4),
(715, 80, 846, 4),
(716, 77, 847, 15),
(717, 79, 848, 8),
(718, 81, 849, 5),
(719, 77, 850, 16),
(720, 81, 851, 6),
(721, 80, 853, 5),
(722, 79, 854, 9),
(723, 77, 855, 17),
(724, 81, 856, 7),
(725, 80, 857, 6),
(726, 79, 858, 10),
(727, 77, 860, 18),
(728, 81, 861, 8),
(729, 82, 862, 1),
(730, 79, 863, 11),
(731, 81, 864, 9),
(732, 77, 865, 19),
(733, 82, 866, 2),
(734, 80, 867, 7),
(735, 83, 868, 1),
(736, 79, 869, 12),
(737, 77, 870, 20),
(738, 81, 871, 10),
(739, 82, 872, 3),
(740, 80, 873, 8),
(741, 77, 874, 21),
(742, 81, 875, 11),
(743, 82, 876, 4),
(744, 79, 877, 13),
(745, 83, 878, 2),
(746, 80, 880, 9),
(747, 77, 881, 22),
(748, 81, 882, 12),
(749, 82, 883, 5),
(750, 79, 884, 14),
(751, 77, 885, 23),
(752, 80, 887, 10),
(753, 81, 888, 13),
(754, 83, 889, 3),
(755, 77, 890, 24),
(756, 82, 891, 6),
(757, 79, 892, 15),
(758, 84, 893, 1),
(759, 80, 895, 11),
(760, 81, 896, 14),
(761, 77, 897, 25),
(762, 83, 898, 4),
(763, 82, 899, 7),
(764, 84, 900, 2),
(765, 79, 901, 16),
(766, 85, 902, 1),
(767, 80, 903, 12),
(768, 82, 904, 8),
(769, 83, 905, 5),
(770, 77, 906, 26),
(771, 84, 907, 3),
(772, 79, 908, 17),
(773, 85, 909, 2),
(774, 86, 910, 1),
(775, 82, 911, 9),
(776, 80, 912, 13),
(777, 77, 913, 27),
(778, 83, 914, 6),
(779, 85, 915, 3),
(780, 79, 916, 18),
(781, 84, 917, 4),
(782, 82, 918, 10),
(783, 86, 919, 2),
(784, 80, 920, 14),
(785, 77, 921, 28),
(786, 85, 922, 4),
(787, 83, 923, 7),
(788, 82, 924, 11),
(789, 84, 925, 5),
(790, 86, 926, 3),
(791, 80, 927, 15),
(792, 77, 928, 29),
(793, 79, 929, 19),
(794, 85, 930, 5),
(795, 83, 931, 8),
(796, 82, 932, 12),
(797, 84, 933, 6),
(798, 86, 934, 4),
(799, 79, 935, 20),
(800, 80, 936, 16),
(801, 77, 937, 30),
(802, 85, 938, 6),
(803, 83, 939, 9),
(804, 82, 940, 13),
(805, 84, 941, 7),
(806, 86, 942, 5),
(807, 79, 943, 21),
(808, 77, 944, 31),
(809, 85, 945, 7),
(810, 83, 946, 10),
(811, 84, 947, 8),
(812, 82, 948, 14),
(813, 80, 949, 17),
(814, 77, 950, 32),
(815, 86, 951, 6),
(816, 85, 952, 8),
(817, 79, 953, 22),
(818, 83, 954, 11),
(819, 82, 955, 15),
(820, 80, 956, 18),
(821, 77, 957, 33),
(822, 84, 958, 9),
(823, 86, 959, 7),
(824, 85, 960, 9),
(825, 83, 961, 12),
(826, 80, 962, 19),
(827, 77, 963, 34),
(828, 82, 964, 16),
(829, 84, 965, 10),
(830, 86, 966, 8),
(831, 83, 967, 13),
(832, 85, 968, 10),
(833, 80, 969, 20),
(834, 77, 970, 35),
(835, 82, 971, 17),
(836, 86, 972, 9),
(837, 84, 973, 11),
(838, 85, 974, 11),
(839, 83, 975, 14),
(840, 77, 976, 36),
(841, 82, 977, 18),
(842, 80, 978, 21),
(843, 86, 979, 10),
(844, 84, 980, 12),
(845, 85, 981, 12),
(846, 83, 982, 15),
(847, 82, 983, 19),
(848, 77, 984, 37),
(849, 80, 985, 22),
(850, 86, 986, 11),
(851, 84, 987, 13),
(852, 85, 988, 13),
(853, 82, 989, 20),
(854, 83, 990, 16),
(855, 77, 991, 38),
(856, 86, 992, 12),
(857, 80, 993, 23),
(858, 84, 994, 14),
(859, 82, 995, 21),
(860, 85, 996, 14),
(861, 83, 997, 17),
(862, 77, 998, 39),
(863, 86, 999, 13),
(864, 82, 1000, 22),
(865, 84, 1001, 15),
(866, 85, 1002, 15),
(867, 83, 1003, 18),
(868, 77, 1004, 40),
(869, 84, 1005, 16),
(870, 85, 1006, 16),
(871, 86, 1007, 14),
(872, 83, 1008, 19),
(873, 84, 1009, 17),
(874, 77, 1010, 41),
(875, 82, 1011, 23),
(876, 85, 1012, 17),
(877, 86, 1013, 15),
(878, 84, 1014, 18),
(879, 83, 1015, 20),
(880, 77, 1016, 42),
(881, 82, 1017, 24),
(882, 86, 1018, 16),
(883, 85, 1019, 18),
(884, 84, 1020, 19),
(885, 83, 1021, 21),
(886, 82, 1022, 25),
(887, 77, 1023, 43),
(888, 86, 1024, 17),
(889, 85, 1025, 19),
(890, 84, 1026, 20),
(891, 82, 1027, 26),
(892, 77, 1028, 44),
(893, 86, 1029, 18),
(894, 83, 1030, 22),
(895, 84, 1031, 21),
(896, 85, 1032, 20),
(897, 77, 1033, 45),
(898, 86, 1034, 19),
(899, 83, 1035, 23),
(900, 85, 1036, 21),
(901, 84, 1037, 22),
(902, 77, 1038, 46),
(903, 86, 1039, 20),
(904, 83, 1040, 24),
(905, 85, 1041, 22),
(906, 84, 1042, 23),
(907, 77, 1043, 47),
(908, 86, 1044, 21),
(909, 85, 1045, 23),
(910, 84, 1046, 24),
(911, 77, 1047, 48),
(912, 86, 1048, 22),
(913, 85, 1049, 24),
(914, 77, 1050, 49),
(915, 86, 1051, 23),
(916, 77, 1052, 50),
(917, 77, 1053, 51),
(918, 77, 1054, 53),
(919, 77, 1055, 54),
(920, 77, 1056, 55),
(921, 77, 1057, 56),
(922, 77, 1058, 57),
(923, 77, 1059, 58),
(924, 77, 1060, 59),
(925, 77, 1061, 60),
(926, 77, 1062, 61),
(927, 77, 1063, 62),
(928, 77, 1064, 63),
(929, 77, 1065, 64),
(930, 77, 1066, 65),
(931, 77, 1067, 66),
(932, 77, 1068, 67),
(933, 77, 1069, 68),
(934, 77, 1070, 69),
(935, 77, 1071, 70),
(936, 77, 1072, 71),
(937, 77, 1073, 72),
(938, 77, 1074, 73),
(939, 77, 1075, 74),
(940, 77, 1076, 75),
(941, 77, 1077, 76),
(942, 77, 1078, 77),
(943, 77, 1079, 78),
(944, 77, 1080, 79),
(945, 77, 1081, 80),
(946, 77, 1082, 81),
(947, 77, 1083, 82),
(948, 77, 1084, 83),
(949, 77, 1085, 84),
(950, 77, 1086, 85),
(951, 77, 1087, 86),
(952, 77, 1088, 87),
(953, 77, 1089, 88),
(954, 77, 1090, 89),
(955, 77, 1091, 90),
(956, 77, 1092, 91),
(957, 77, 1093, 92),
(958, 77, 1094, 93),
(959, 77, 1095, 94),
(960, 77, 1096, 95),
(961, 77, 1097, 96),
(962, 77, 1098, 97),
(963, 77, 1099, 98),
(964, 77, 1100, 99),
(965, 77, 1101, 100),
(966, 77, 1102, 101),
(967, 77, 1103, 102),
(968, 77, 1104, 103),
(969, 77, 1105, 104),
(970, 77, 1106, 105),
(971, 77, 1107, 106),
(972, 77, 1108, 107),
(973, 77, 1109, 108),
(974, 77, 1110, 109),
(975, 77, 1111, 110),
(976, 77, 1112, 111),
(977, 77, 1113, 112),
(978, 77, 1114, 113),
(979, 77, 1115, 114),
(980, 77, 1116, 115),
(981, 77, 1117, 116),
(982, 77, 1118, 117),
(983, 77, 1119, 118),
(984, 77, 1120, 119),
(985, 77, 1121, 120),
(986, 77, 1122, 121),
(987, 77, 1123, 122),
(988, 77, 1124, 123),
(989, 77, 1125, 124),
(990, 77, 1126, 125),
(991, 77, 1127, 126),
(992, 77, 1128, 127),
(993, 77, 1129, 128),
(994, 77, 1130, 129),
(995, 77, 1131, 130),
(996, 77, 1132, 131);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generomedia`
--

CREATE TABLE `generomedia` (
  `id` int(11) NOT NULL,
  `media` int(11) NOT NULL,
  `genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generomedia`
--

INSERT INTO `generomedia` (`id`, `media`, `genero`) VALUES
(104, 756, 10759),
(105, 756, 16),
(106, 756, 35),
(107, 756, 10765),
(108, 806, 35),
(109, 1133, 35),
(110, 1134, 80),
(111, 1134, 18),
(112, 1135, 80),
(113, 1135, 18),
(114, 1136, 10759),
(115, 1136, 18),
(116, 1136, 10768),
(117, 1137, 18),
(118, 1137, 9648),
(119, 1138, 10759),
(120, 1138, 18),
(121, 1138, 10765),
(122, 1139, 80),
(123, 1139, 18),
(124, 1139, 9648),
(125, 1140, 18),
(126, 1140, 9648),
(127, 1140, 10765),
(128, 1141, 35),
(129, 1142, 10759),
(130, 1142, 80),
(131, 1142, 18),
(132, 1143, 10759),
(133, 1143, 80),
(134, 1143, 18),
(135, 1143, 10765),
(136, 1144, 18),
(137, 1144, 9648),
(138, 1144, 10765),
(139, 1145, 80),
(140, 1145, 18),
(141, 1146, 10759),
(142, 1146, 10765),
(143, 1147, 10765),
(144, 1147, 37),
(145, 1148, 80),
(146, 1148, 18),
(147, 1149, 10759),
(148, 1149, 18),
(149, 1149, 10765),
(150, 1150, 10759),
(151, 1150, 16),
(152, 1150, 10765),
(153, 1151, 28),
(154, 1151, 12),
(155, 1151, 18),
(156, 1152, 80),
(157, 1152, 18),
(158, 1153, 12),
(159, 1153, 878),
(160, 1154, 28),
(161, 1154, 12),
(162, 1154, 878),
(163, 1155, 18),
(164, 1155, 10749),
(165, 1156, 18),
(166, 1156, 10749),
(167, 1157, 28),
(168, 1157, 12),
(169, 1157, 878),
(170, 1158, 12),
(171, 1158, 14),
(172, 1159, 28),
(173, 1159, 12),
(174, 1159, 878),
(175, 1160, 28),
(176, 1160, 12),
(177, 1160, 878);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre_genero` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre_genero`) VALUES
(28, 'Acción'),
(10759, 'Action & Adventure'),
(16, 'Animación'),
(12, 'Aventura'),
(10752, 'Bélica'),
(878, 'Ciencia ficción'),
(35, 'Comedia'),
(80, 'Crimen'),
(99, 'Documental'),
(18, 'Drama'),
(10751, 'Familia'),
(14, 'Fantasía'),
(36, 'Historia'),
(10762, 'Kids'),
(9648, 'Misterio'),
(10402, 'Música'),
(10763, 'News'),
(10770, 'Película de TV'),
(10764, 'Reality'),
(10749, 'Romance'),
(10765, 'Sci-Fi & Fantasy'),
(10766, 'Soap'),
(53, 'Suspense'),
(10767, 'Talk'),
(27, 'Terror'),
(10768, 'War & Politics'),
(37, 'Western');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `tmdb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `title`, `description`, `release_date`, `tmdb_id`) VALUES
(756, 'Mob Psycho 100', 'Kageyama Shigeo, más conocido por el apodo \"Mob\", parece un chico tímido con problemas para relacionarse con los demás, pero en realidad. es un poderoso Esper. Mob quiere ser un niño normal y corriente pero, para mantener su poder psíquico bajo control, tiene que reprimir constantemente sus emociones. Sin embargo, los problemas le persiguen, y vive rodeado por falsos Espers, espíritus malignos y misteriosas organizaciones.', '2016-07-12', 67075),
(757, 'Especiales', '', '2016-09-28', 67075),
(758, 'Episodio 1', '', '2016-09-28', 67075),
(759, 'Episodio 2', '', '2016-10-26', 67075),
(760, 'Temporada 1', '', '2016-07-11', 67075),
(761, 'Episodio 3', '', '2016-11-23', 67075),
(762, 'Episodio 4', '', '2016-12-21', 67075),
(763, 'El psíquico autoproclamado: Reigen Arataka ~Y Mob~', 'Los psíquicos pelean con fenómenos sobrenaturales que la ciencia no puede explicar. Reigen Arataka, que dirige la oficina de consultas Espíritus y Tal, es uno de esos videntes... bueno, uno falso. Su única esperanza es un superaburrido estudiante de secundaria llamado Kageyama Shigeo, alias Mob.', '2016-07-12', 67075),
(764, 'Temporada 2', 'La temporada 2 de Mob Psycho 100 se estrenó el Enero 7, 2019.', '2019-01-06', 67075),
(765, 'Episodio 5', '', '2017-01-25', 67075),
(766, 'Las dudas de la juventud ~Aparece el club de telepatía~', 'Al Club de Telepatía se le informa que el consejo estudiantil los clausurará debido a la falta de miembros. Fue entonces cuando uno de los miembros, Inukawa, pensó en conseguir que Mob se uniera. Sin embargo, Mob recibe una llamada de Reigen para que se ocupe de un incidente en la Academia de Niñas de Highso.\n\nfuente: animehdpro.com', '2016-07-19', 67075),
(767, 'Temporada 3', '', '2022-10-05', 67075),
(768, 'Hecho pedazos ~Hay alguien mirando~', 'Mob sigue intentando llevar una vida diaria corriente, pero la gente de su alrededor no se lo permite e intenta sacarlo de su zona de confort con desastrosos resultados.', '2019-01-07', 67075),
(769, 'Episodio 6', '', '2017-02-22', 67075),
(770, 'Un invitación ~En resumen, quiero ser popular~', 'Es genial que Mob se haya unido al Body Improvement Club, pero de repente se desmaya mientras corre a lo largo de la orilla del río. Su deseo es ser más fuerte y ser capaz de acercarse a su amada Tsubomi-chan. Un día, mientras la mafia se siente preocupada, una mujer con una extraña máscara se le acerca ... Progreso hacia la explosión de la mafia: 20%\n\nfuente: animehdpro.com', '2016-07-26', 67075),
(771, 'Mob Psycho 100 Reigen', 'Un resumen de 60 minutos de los eventos de la primera temporada.', '2018-03-18', 67075),
(772, 'Leyendas urbanas ~Encontrándose con rumores~', 'Reigen busca nuevos modos de conseguir algo de dinero y decide que las leyendas urbanas son lo que lo sacarán de la pobreza de una vez por todas.', '2019-01-14', 67075),
(773, 'Episodio 1', '', '2022-10-06', 67075),
(774, 'Primer viaje de Espíritus y demás ~ Guía de viaje', 'Un grupo de psíquicos y consejeros, incluyendo a Mob y Ekubo, además del nuevo miembro, Serizawa, se dirigen a las aguas termales ocultas de Ibogami, las cuales se encuentran en la parte de atrás de la montaña de Shiba. Reigen fue quien recibió una petición de la posada localizada en tal lugar, la cual decía lo siguiente: ‘Quiero que descubráis el terrorífico misterio en torno a las aguas termales y salvéis la posada’. Con dicha petición entre manos, Reigen se decide a invitar también a Ritsu y Teru en lo que cree será un pequeño viaje de dos noches en el que divertirse y descansar. Sin embargo, las cosas comienzan a complicarse a medio camino…', '2019-09-25', 67075),
(775, 'Un evento exclusivo para idiotas ~Kin~', 'Después del incidente con la organización religiosa (LOL), el espíritu malvado, Dimple, sigue siguiendo a Mob. Además, debido al incidente, Mezato Ichi del periódico escolar también comienza a seguir a Mob. Entonces, un día, otro alumno se une al Body Improvement Club. Avance hacia la explosión de la mafia: 45%\n\nfuente: animehdpro.com', '2016-08-02', 67075),
(776, 'Un peligro tras otro ~Degeneración~', 'La idea de Reigen de abrir la página web ha sido todo un éxito. Desde ese instante no dejan de recibir encargos de todo tipo por parte de la gente.', '2019-01-21', 67075),
(777, 'Ochimusha ~Los poderes psíquicos y yo~', 'La mafia tiene el desafío de una pelea uno a uno con el líder de la sombra de Black Vinegar Middle School, Hanazawa Teruki, también conocido como Teru. La mafia no usa sus poderes, pero Teru se aprovecha de él, destruyendo todo lo que lo rodea. Teru continúa desatando su increíble poder cuando Mob repentinamente recuerda una tragedia que ocurrió entre él y Ritsu\n\nfuente: animehdpro.com', '2016-08-09', 67075),
(778, 'Interior ~Espectro~', 'Reigen y muchísimos otros psíquicos reciben la petición de un hombre millonario para liberar a su hija de una posesión espiritual.', '2019-01-28', 67075),
(779, 'Episodio 2', '', '2022-10-13', 67075),
(780, 'Discordia ~Elección~', 'Mob se encuentra encerrado en el mundo creado por Mogami. El psíquico intentará convencer a Mob a la fuerza para que se vuelva como él, pero ¿lo conseguirá?', '2019-02-04', 67075),
(781, 'Episodio 3', '', '2022-10-20', 67075),
(782, 'Discordancia ~Volverse uno~', 'Los días de paz regresan después de la pelea de Mob con Teru. Como de costumbre, Reigen sigue engañando a la gente como un psíquico falso, y el presidente del Telepathy Club, Kurata Tome, arrastra a Mob para encontrar otros espers. Entonces, un día, un hombre misterioso habla con el hermano menor de Mob, Ritsu ..\n\nfuente: animehdpro.com', '2016-08-16', 67075),
(783, 'Un día blanco solitario', 'Mob quiere tener una vida acorde a la edad que tiene, pero Reigen no lo permite porque siempre le está dando trabajo. Y la paciencia de Mob parece tener un límite.', '2019-02-11', 67075),
(784, 'Fase final ~Identidad~', 'La fama de Reigen está creciendo cada vez más e incluso lo invitan a programas de televisión. Aunque quizás ser partícipe de la fama sea una mala idea.', '2019-02-18', 67075),
(785, 'Episodio 4', '', '2022-10-27', 67075),
(786, 'Exaltación ~Solo conseguí pérdidas~', 'La Escuela Intermedia Salt se somete a una limpieza profunda liderada por el presidente del consejo estudiantil, Kamuro, y un matón tras otro es el objetivo. Mientras tanto, la historia sobre Mob derrotando al líder de la sombra en Black Vinegar Middle School comienza a embellecerse y adquiere una vida propia, y Mob se conoce como \"White T Poison\". Todos los líderes de las pandillas de las otras escuelas comienzan a reunirse en Salt Middle School para enfrentar White T Poison. Además, Ritsu despierta a sus poderes psíquicos dormidos, y Dimple logra convencer a Ritsu para que se empareje con él y se vuelva más fuerte que su hermano. Ritsu finalmente experimenta esos poderes por sí mismo, pero ...\n\nfuente: animehdpro.com', '2016-08-23', 67075),
(787, 'Aun así ~Avanza~', 'Pronto se celebrará la maratón en la escuela de Mob. Podría ser algo irrelevante, pero es de vital importancia para los planes amorosos de Mob.', '2019-02-25', 67075),
(788, 'Episodio 5', '', '2022-11-03', 67075),
(789, 'El mayor se postra ~Intenciones destructivas~', 'Después de derrotar a todos los líderes de pandillas de las escuelas de los alrededores, Ritsu se siente omnipotente. Y luego, se enfrenta a nada menos que a su hermano mayor, la mafia. La mafia sabía que Ritsu había querido poderes psíquicos por un tiempo, así que lo felicita. Sin embargo, Ritsu no saluda a su hermano con amabilidad. Mientras tanto, un hombre misterioso observa a los hermanos desde la distancia. Fácilmente logra agarrar a Ritsu, e intenta arrastrarlo fuera. La mafia activa sus poderes para salvar a su hermano, pero.\n\nfuente: animehdpro.com', '2016-08-30', 67075),
(790, 'Muéstralo ~Reunión~', 'El líder de Garra ha reaparecido tras un tiempo en las sombras, se ha rodeado de nuevos y poderosos aliados y se dispone a declararle la guerra al mundo entero.', '2019-03-04', 67075),
(791, 'Episodio 6', '', '2022-11-10', 67075),
(792, 'Garra ~La séptima división~', 'Ritsu y los demás son secuestrados por un misterioso hombre llamado Koyama, y son llevados a la organización secreta de la 7ma División de la Garra. Claw es una organización que intenta liderar el mundo hacia un futuro mejor asumiéndolo. Uno de los asesinos de Garra, Terada va detrás de Mob y Teru, pero ellos lo dominan y hacen que les cuente secretos sobre la organización. Para salvar a Ritsu, Mob se dirige a la 7ª División pero se encuentra con otro miembro de Claw, y ...\n\nfuente: animehdpro.com', '2016-09-06', 67075),
(793, 'Colisión ~Potencia~', 'El primer ministro ha desaparecido tras el primer ataque de Garra y los psíquicos rebeldes intentan encontrar un modo de repelerlos. Mientras tanto, Mob sigue dormido y no puede hacer nada.', '2019-03-11', 67075),
(794, 'Episodio 7', '', '2022-11-17', 67075),
(795, 'Gran aura maléfica ~Mente maestra~', 'La Mafia y Teru se infiltran en la 7ma División de la Garra para salvar a Ritsu. Mientras tanto, Ritsu intenta escapar con los otros niños Esper y se topan con el escalón superior y el líder de la 7ma División. Teru y Dimple se encuentran en problemas después de una batalla extenuante, y el jefe de Claw finalmente se muestra a sí mismo ...\n\nfuente: animehdpro.com', '2016-09-13', 67075),
(796, 'Episodio 8', '', '2022-11-24', 67075),
(797, 'Guía ~Psíquicos perceptivos~', 'Ha comenzado la ofensiva total de los psíquicos que quieren derrotar a Garra, pero Los Supercinco son realmente poderosos y les darán más de un problema.', '2019-03-18', 67075),
(798, 'El maestro ~El líder~', 'La mafia finalmente llega a su límite cuando tiene que enfrentarse a Sakurai, Muraki, Matsuo e Ishiguro del escalón superior. Pero luego, llega a una decisión bastante sorprendente\n\nfuente: animehdpro.com', '2016-09-20', 67075),
(799, 'Episodio 9', '', '2022-12-01', 67075),
(800, 'Batalla del retorno de la sociedad ~Amistad~', 'Mob se enfrenta a Serizawa, el último escollo que hay entre el líder de Garra y él, pero su poder oculta una tristeza insondable a la que Mob intentará apelar.', '2019-03-25', 67075),
(801, 'Episodio 10', '', '2022-12-08', 67075),
(802, 'Batalla contra el jefe ~La última luz~', 'La batalla de Mob contra el presidente llega a su punto álgido y dos poderes descomunales chocan entre sí. ¿Quién vencerá en esta batalla de voluntades y fuerza?', '2019-04-01', 67075),
(803, 'Mob y Reigen ~La aparición del tsuchinoko gigante~', 'La situación es crítica durante la pelea contra la plana mayor de la Séptima División. Mob se ve superado por la situación y está perdido, pero las palabras de Reigen cambiarán su perspectiva por completo.', '2016-09-27', 67075),
(804, 'Episodio 11', '', '2022-12-15', 67075),
(805, 'Episodio 12', '', '2022-12-22', 67075),
(806, 'The Office', 'Steve Carell protagoniza The Office, un fresco y divertido vistazo, con formato pseudo-documental, al día a día en la vida de unos excéntricos trabajadores de la empresa Dunder Mifflin. El serio pero despistadísimo director Michael Scott se considera un magnífico jefe y mentor, pero realmente inspira más críticas que respeto a sus empleados.', '2005-03-24', 2316),
(807, 'Especiales', '', '2006-07-13', 2316),
(808, 'Los Contables: Los libros no cuadran', 'Los contadores informan a Jan que los libros no cuadran y faltan 3000$. Los contables deciden interrogar a los demás empleados de la oficina, pero Oscar está seguro de que Michael lo tomó.', '2006-07-13', 2316),
(809, 'Temporada 1', 'En la primera temporada, Michael Scott, gerente regional de Dunder Mifflin, guiará al equipo que rueda el documental y a sus empleados a través de comportamientos inapropiados, comentarios bienintencionados pero descaminados y una miríada de nefastas técnicas de dirección.', '2005-03-24', 2316),
(810, 'Los Contables: Phyllis', 'Los contables interrogan a Phyllis y ella confiesa que pidió prestados 14$ y se olvidó de informar.', '2006-07-13', 2316),
(811, 'Los Contables: Meredith', 'Meredith es la siguiente empleada en ser interrogada. Ella afirma que no estaría en el trabajo si lo hiciera y que no se arriesgaría a ser arrestada porque tiene un hijo del que cuidar. También indica que ya perdió la custodia de su otro hijo, una hija, por lo que no se arriesgaría.', '2006-07-20', 2316),
(812, 'Piloto', 'Un equipo documental llega a la oficina de Dunder Mifflin para ver a los empleados y aprender de su moderna dirección, guiados por Michael Scott, el jefe de la oficina. Mientras, Jim, se pelea con Dwight y coquetea con la recepcionista Pam.', '2005-03-24', 2316),
(813, 'Temporada 2', 'La segunda temporada de esta alabada comedia sigue el día a día de Michael Scott, gerente regional de Dunder Mifflin, y sus ambivalentes empleados.', '2005-09-20', 2316),
(814, 'Los Contables: Stanley', 'Los contables hablan con Stanley. Stanley cree que quienquiera que lo haya hecho es inteligente para robar tanto.', '2006-07-27', 2316),
(815, 'Día de la Diversidad', 'Un consultor llega a la oficina para impartir un seminario sobre tolerancia y diversidad en el lugar de trabajo, pero Michael insiste en impartir sus propios métodos. Mientras tanto, Jim no tiene un buen día con todas las interrupciones.', '2005-03-29', 2316),
(816, 'Los Contables: Alguien del almacén', '¿Alguien en el almacén robó los 3000$?', '2006-08-03', 2316),
(817, 'El seguro médico', 'Michael encarga a Dwight la elección del seguro medico para la oficina, pero este se lo toma muy en serio. Mientras, Jim y Pam fingirán sufrir enfermedades mortales para molestarlo.', '2005-04-05', 2316),
(818, 'Los Contables: La circular', 'Contabilidad pide, en una circular, que el ladrón se presente de forma anónima.', '2006-08-10', 2316),
(819, 'El pacto', 'Michael prepara una fiesta de cumpleaños para Meredith. Jim y Dwight hacen una alianza para evitar que los despidan. Por otro lado, Michael debe decir a Oscar que no va a patrocinar la marcha solidaria en la que participa su sobrino.', '2005-04-12', 2316),
(820, 'Los Contables: Las cosas se ponen tensas', 'Kevin y Angela se acusan mutuamente de ser el ladrón.', '2006-08-17', 2316),
(821, 'Baloncesto', 'Todo el personal de la oficina, incluido Michael, desafía a los trabajadores del almacén con un partido de baloncesto. Esta es la situación que aprovecha Jim para acercarse e impresionar a Pam, intentando derrotar al equipo contrario en el que juega el prometido de la chica.', '2005-04-19', 2316),
(822, 'Los premios Dundies', 'Es el día de entrega de los premios Dundies en la oficina y Michael está nervioso porque es el presentador de la velada. Estos premios se otorgan a casi todo el personal de la empresa y es Michael el único que disfruta entregándolos porque son algo humillantes. Toda la oficina se encuentra en el Chili\'s para la celebración de los premios y viven una noche que nunca olvidarán. Por otro lado, Dwight escucha un rumor sobre un graffiti en el lavabo de señoras y decide averiguar más sobre el asunto.\n\n', '2005-09-20', 2316),
(823, 'Los Contables: Eres mala', 'Contabilidad espera a que Michael se vaya para registrar su despacho.', '2006-08-24', 2316),
(824, 'La chica sexy', 'Katy, una atractiva mujer, visita la oficina. Todos los hombres comienzan a competir por la atención de la chica, incluido Michael. Mientras, Pam comienza a sentirse celosa de Katy, ya que ha dejado de ser el centro de atención.', '2005-04-26', 2316),
(825, 'Acoso sexual', 'Debido a la marcha de Randall por acoso sexual en la oficina, el encargado de RR.HH. considera apropiado recordar a todos los trabajadores la política de la empresa sobre ese tipo de cuestiones en el entorno laboral. Michael no está de acuerdo con que se eliminen los chistes y se acabe con el reenvío de mensajes sexuales, ya que los considera algo divertido e inofensivo para el personal.\n\n', '2005-09-27', 2316),
(826, 'Los Contables: El despacho de Michael', 'Contabilidad registra la oficina de Michael.', '2006-08-31', 2316),
(827, 'Temporada 3', 'La tercera temporada ficha entrada con el inesperado traslado de Jim Halpert a la filial de Stamford, pero ¿fichará salida con el cierre de Scranton?', '2006-09-21', 2316),
(828, 'Olimpiadas en la oficina', 'Mientras Michael y Dwight están fuera de la oficina tratando de firmar un contrato de compra de una nueva vivienda para Michael, Jim y Pam convencen al personal para que participen en unas olimpiadas en la oficina. Los juegos consisten en invenciones de los trabajadores, tales como correr con una taza de café sin derramarlo o comerse un gran número de caramelos. Al final del día, los juegos animan a todo el mundo, incluso al propio Michael.\n\n', '2005-10-04', 2316),
(829, 'Los Contables: El mejor día de mi vida', 'Se revela la verdad sobre los fondos faltantes.', '2006-09-07', 2316),
(830, 'Fuego', 'Toda la oficina se ve obligada a permanecer en el parking durante todo el día al desatarse un fuego en la cocina. Para matar el aburrimiento, Jim propone jugar a ¿qué llevarías a una isla desierta? y ¿con quién te acostarías?, donde todo el mundo revela demasiada información sobre su vida privada. Mientras, Michael habla de negocios con Ryan, lo que hace sentir a Dwight inferior ante los ojos de su jefe.\n\n', '2005-10-11', 2316),
(831, 'Temporada 4', 'Llega la cuarta temporada con muchas novedades en la oficina. Ryan, antiguo trabajador temporal, es ahora el jefe de todos y está fomentando una nueva iniciativa web que amenaza el cómodo mundo de la sede de Scranton. Jan, su exjefa, prueba la vida doméstica en el apartamento de Michael. La relación de Jim y Pam ha alcanzado nuevas cotas, pero Dwight y Angela tienen graves importantes.', '2007-09-27', 2316),
(832, 'La caza de brujas gays', 'En cuatro meses las cosas han cambiado mucho en Dunder Mifflin. Michael sin querer hace público que Oscar es gay y descubrimos qué ha pasado con Jim y Pam.', '2006-09-21', 2316),
(833, 'Carrete de tomas falsas de la temporada 2', 'Carrete de tomas falsas de la temporada 2', '2006-09-12', 2316),
(834, 'Noche de Halloween', 'Mientras todo el mundo en la oficina disfruta con los preparativos de Halloween, Michael se plantea a quién despedir cuando la amenaza de reducción de plantilla se convierta en una realidad. Jim y Pam cuelgan el curriculum de Dwight en una página web de búsqueda de empleo, lo que podría ponerle las cosas más fáciles a Michael a la hora de decidirse.', '2005-10-18', 2316),
(835, 'Carrera benéfica', 'Un accidente extraño propicia que Michael piense que la oficina está maldita. Michael decide hacer una carrera benéfica de cinco mil dólares. Y otros romances entre compañeros de trabajo.', '2007-09-27', 2316),
(836, 'La convención', 'Michael y Dwight acuden junto a Jan a una convención de proveedores de material de oficina. Michael intenta organizar una fiesta en la habitación de Dwight.', '2006-09-28', 2316),
(837, 'La pelea', 'Cuando Dwight deja en ridículo a Michael dándole un puñetazo en el estómago, Jim organiza una revancha a la hora de la comida. Mientras, Pam se enfada con Jim cuando éste pasa la barrera de lo físico con ella y Ryan se ocupa de actualizar el fichero de las persona de contacto a las que acudir en cada caso si alguien sufre una emergencia.\n\n', '2005-11-01', 2316),
(838, 'Carrete de tomas falsas de la temporada 3', 'Carrete de tomas falsas de la temporada 3', '2007-09-04', 2316),
(839, 'Proyecto Infinity', 'Ryan vuelve de la sucursal de Dubder-Mifflin para introducir a la compañía a la era digital. Ángela sigue disgustado por su gato.', '2007-10-04', 2316),
(840, 'El insurrecto', 'Jan despide a Michael por poner películas a los trabajadores en horas laborables y Angela incita a Dwight a que se haga con el puesto de Michael.', '2006-10-05', 2316),
(841, 'El Préstamo de Kevin: Problemas de dinero', 'Kevin habla de todos sus problemas de dinero y Oscar se cansa de escucharlo.', '2008-07-10', 2316),
(842, 'La fiesta de inauguración', 'Michael se anticipa para ir a Nueva York para la fiesta de lanzamiento de la página Web de la compañía. Dwight intenta vender más papel en un día que en la página Web.', '2007-10-11', 2316),
(843, 'El cliente', 'Cuando Michael y Jan tratan de atrapar a un cliente potencial llevándole al Chillis, Michael sorprende a todo el mundo con su embarazosa actitud. De vuelta en la oficina, Jim encuentra una obra semi-autobiográfica escrita por Michael y toda la oficina pasa un buen rato interpretándola. Más tarde, Pam y Jim tienen su primera cita no oficial en la que un sándwich, velas y los ridículos fuegos artificiales a cargo de Dwight son los protagonistas.\n\n', '2005-11-08', 2316),
(844, 'El Préstamo de Kevin: Los conos de Malone', 'Kevin decide comenzar su propio negocio, pero su entrevista con el oficial de préstamos no va muy bien.', '2008-07-17', 2316),
(845, 'Dinero', 'Michael intenta combatir su creciente deuda pidiéndole préstamos a los empleados. Jim y Pam pasan la noche en la finca de la familia de Dwight, que ha sido convertida en un hostal.', '2007-10-18', 2316),
(846, 'El pésame', 'Al enterarse que el antiguo jefe regional de Dunder Mifflin ha muerto, Michael trata que toda la compañía honre al fallecido y dé el pésame.', '2006-10-12', 2316),
(847, 'El Préstamo de Kevin: Cables pelados', 'Mientras Kevin lucha por conseguir un préstamo, Darryl se ofrece a ayudarlo.', '2008-07-24', 2316),
(848, 'El examen de resultados', 'Michael se reúne con todo el equipo para discutir su trabajo en la oficina hasta el momento. Sin embargo, Michael parece más preocupado en retomar su relación con Jan que en si sus empleados están haciendo o no su trabajo. Mas tarde, un nervioso Michael planea utilizar las ideas más interesantes de los trabajadores para usarlas como suyas en su discusión con Jan sobre su trabajo. El plan de Michael fracasa cuando Jan pide estar presente en la reunión. Mientras tanto, Jim y Pam tratan de hacer creer a Dwight que es viernes en lugar de jueves.\n\n', '2005-11-15', 2316),
(849, 'Publicidad local', 'Michael aprovecha la oportunidad de exponer su creatividad cuando la sucursal de Scranton debe participar en un anuncio de la compañía. Dwight explora el mundo online de Second Life.', '2007-10-25', 2316),
(850, 'El Préstamo de Kevin: Saborea el helado', 'El segundo intento de Kevin de asegurar una carga bancaria sale tan mal como el primero, por lo que intenta saldar su deuda de otra manera.', '2008-07-31', 2316),
(851, 'Guerra entre oficinas', 'Michael declara la guerra a Karen porque quiere que Stanley deje la filial de Scranton. Mientras tanto, Pam, Toby y Oscar comienzan un club de lectura tan exclusivo que el resto de los empleados se ponen celosos.', '2007-11-01', 2316),
(852, 'Temporada 5', 'La temporada anterior dejó boquiabiertos a los fans de The Office y ansiosos por más episodios. El mundo de los incautos trabajadores de Dunder Mifflin sigue plagado de nuevas y patéticas peripecias.', '2008-09-25', 2316),
(853, 'La iniciación', 'Ryan acompaña a Dwight en su primera salida como vendedor desde que ha sido contratado a tiempo completo. Dwight le hará pasar por todo tipo de pruebas.', '2006-10-19', 2316),
(854, 'Correo intervenido', 'Michael comienza a revisar los e-mails enviados desde la oficina de Dunder-Mifflin, lo que molesta a los trabajadores. Mientras, Pam cree que la relación entre Dwigth y Angela es más que una relación laboral. Más tarde, Jim organiza una barbacoa en su casa para mostrar a su compañero de habitación las personas con las que se relaciona cada día, y Michael, después de enfadar a todo el mundo con sus clases de improvisación, revienta la fiesta de Jim con una esperpéntica actuación en el karaoke.\n\n', '2005-11-22', 2316),
(855, 'Carrete de tomas falsas de la temporada 4', 'Carrete de tomas falsas de la temporada 4', '2008-09-02', 2316),
(856, 'El superviviente', 'Cuando Ryan lo excluye de un retiro en el parque natural, Michael entra en los bosques para vivir su propia aventura de supervivencia. Jim trata de revolucionar la fiesta de cumpleaños de oficina.', '2007-11-08', 2316),
(857, 'Fiesta de Diwali', 'Michael quiere fomentar la diversidad animando a toda la oficina a celebrar Diwali, la fiesta hindú de las luces.', '2006-11-02', 2316),
(858, 'La fiesta de Navidad', 'Michael celebra una fiesta de Navidad en la oficina pero de alguna manera estropea el espíritu navideño cuando cambia las reglas del juego ?amigo invisible? y obliga a sus empleados a darle el regalo comprador a otra persona diferente. Para levantar la moral, Michael echa un poco de vodka en la bebida mientras los demás compiten para ganar un iPod. Mientras, Jim estudia la jugada para procurara que su regalo sentimental a Pam no termine en manos de Dwight y Angela se enfurece por las consecuencias de la idea de Michael.\n\n', '2005-12-06', 2316),
(859, 'Temporada 6', '¿Suenan campanas de boda? ¿Se escuchan correteos infantiles por el suelo de la oficina? ¿Se ha convertido Michael en un capo de la mafia? Es posible que se vea obligado a ello con Dunder Mifflin al borde de la quiebra, o tal vez haya llegado el momento de cambiar de directivos.', '2009-09-17', 2316),
(860, 'El Estallido: La llamada', 'Oscar está hablando por teléfono en el trabajo y de repente tiene un colapso que deja a sus compañeros de trabajo preguntándose qué ha sucedido.', '2008-11-20', 2316),
(861, 'La declaración', 'Jan demanda a Dunder Mifflin, y Michael declara como testigo. Kelly habla mal de Pam después de que Darryl vence a Jim en el ping-pong.', '2007-11-15', 2316),
(862, 'Concurso de adelgazamiento', 'Los empleados de Dunder Mifflin participan en un concurso de adelgazamiento. Mientras, Michael quiere hacerse amigo de una nueva trabajadora.', '2008-09-25', 2316),
(863, 'Crucero con barra libre', 'Michael se marcha con toda la empresa a un crucero con barra libre al lago de Wallenpaupack. Sus planes resultan un fracaso cuando todos prefieren distraerse con las actividades que encuentran en el lugar. Por otro lado, la relación entre Jim y Katy da un giro cuando Roy y Pam fijan finalmente el día su boda. Al final de la noche, Michael deja de dar por perdido el viaje de motivación cuando mantiene una conversación personal con uno de los empleados.\n\n', '2006-01-05', 2316),
(864, 'Cena con fiesta', 'A Pam y a Jim se les acaban las excusas y tienen que asistir a una cena en la casa de Jan y Michael. Cuando Dwight se entera que Angela y Andy también están invitados, los celos sacan lo mejor de él.', '2008-04-10', 2316),
(865, 'El Estallido: La investigación', 'Los compañeros de trabajo de Oscar comienzan a fastidiarlo sobre por qué estalló.', '2008-11-26', 2316),
(866, 'Ética profesional', 'Holly se apunta a un seminario de ética profesional. Meredith revela que ha tenido un lío con un proveedor. Mientras, Jim desafía a Dwight.', '2008-10-09', 2316),
(867, 'El cierre de la sucursal', 'La noticia de que la sucursal de Scranton va a cerrar lleva a la plantilla de Dunder Mifflin a imaginarse cómo serán sus vidas lejos de la oficina.', '2006-11-09', 2316),
(868, 'Cotilleo', 'Michael se dedica a extender rumores sobre todo el mundo para tapar el que ha ido contando Stanley sobre él. Pero, sin querer, da con una verdad.', '2009-09-17', 2316),
(869, 'El accidente', 'Michael se quema el pie con un mini-grill y pretende que todos sus empleados estén pendientes de él y de su quemadura. Mientras, Dwight actúa de una manera muy extraña siendo amable y servicial con Pam. No es hasta el final de la jornada laboral cuando todo el mundo se da cuenta de que el accidente de coche en el que se había visto envuelto esa misma mañana le ha provocado unas consecuencias fatales. Rápidamente le llevan al hospital, donde Michael se pone celoso por la atención que los médicos y enfermeras le prestan a su empleado.\n\n', '2006-01-12', 2316),
(870, 'El Estallido: La búsqueda', 'El deseo de aprender más sobre el estallido tiene a los compañeros de trabajo de Oscar invadiendo su espacio personal.', '2008-12-04', 2316),
(871, 'La modelo de silla', 'Una modelo de catálogo de artículos de oficina despierta sentimientos en Michael. Para ganar los espacios de aparcamiento de Dunder-Mifflin, Kevin y Andy se oponen a los jefes de cinco empresas.', '2008-04-17', 2316),
(872, 'La fiesta para el bebé', 'Michael y Dwight practican para cuando nazca el bebé de Jan. Por otro lado, Michael le confiesa a Holly que fingirá despreciarla en beneficio de Jan.', '2008-10-16', 2316),
(873, 'La fusión', 'Las sucursales de Scranton y Stamford se fusionan lo que provoca que Pam y Jim vuelvan a estar juntos en la oficina tras meses separados.', '2006-11-16', 2316),
(874, 'El Estallido: La explicación', 'La razón del estallido de Oscar en el trabajo se revela a todos sus compañeros de trabajo.', '2008-12-11', 2316),
(875, 'La salida nocturna', 'Michael y Dwight deciden sorprender a Ryan en Nueva York. El personal de Scranton tiene que trabajar el sábado para el proyecto de la página Web de Ryan.', '2008-04-24', 2316),
(876, 'La subasta benéfica', 'Michael decide ayudar a Pam para que pueda pagarse sus clases de arte. Cuando roban en la oficina Michael decide hacer una subasta y recaudar fondos.', '2008-10-23', 2316),
(877, 'El secreto', 'Cuando Michael le deja caer a Jim algún que otro comentario sobre su relación con Pam, éste se asegura de que nadie más en la empresa haya descubierto que ha perdido la cabeza por su compañera, mientras se arrepiente enormemente de habérselo contado a Michael. Sus intentos por mantener su secreto a salvo terminan por perjudicar su relación con la propia Pam. Mientras, Dwight investiga los verdaderos motivos que han llevado a Oscar a faltar al trabajo y lo que descubre le deja de piedra.\n\n', '2006-01-19', 2316),
(878, 'La reunión', 'Michael se preocupa cuando ve que David Wallace y Jim se reúnen. La demanda de los trabajadores de Darryl hace sospechar a Dwight.', '2009-09-24', 2316),
(879, 'Temporada 7', 'Errar es humano, pero lo que Michael Scott hace es irritar. Es irritante, irracional e irreprimible, pero esas mismas características lo hacen irresistible.', '2010-09-23', 2316),
(880, 'El preso', 'Los empleados de la oficina descubren que un trabajador proveniente de la sucursal de Stamford es un ex convicto.', '2006-11-30', 2316),
(881, 'Chantaje: Oscar', 'Creed ha estado chantajeando a personas por razones desconocidas y su primer objetivo es Oscar Martínez.', '2009-05-07', 2316),
(882, 'Respeto', 'Michael intenta que Stanley cambie de actitud cuando Stanley se enfada con él. Dwight decide comprar el coche de Andy, tras pasar la noche con Jim. Pam debe lidiar con una inconveniencia inesperada.', '2008-05-01', 2316),
(883, 'Traslado de empleada', 'Es Halloween, y Pam es la única que acude disfrazada a la oficina. Holly y Michael sufren un revés en su relación. Dwight atormenta a Andy.', '2008-10-30', 2316),
(884, 'La moqueta', 'Alguien ensucia la moqueta del despacho de Michael y éste piensa que ha sido un acto premeditado y que quizás no todo el mundo en la oficina le tiene tanto aprecio. Debido al mal olor que desprende la mancha, Jim se ve obligado a compartir su mesa con el jefe. Mientras, Pam intenta sobrellevar el aburrido día sin Jim haciéndola reír.\n\n', '2006-01-26', 2316),
(885, 'Chantaje: Andy', '¿Qué trapo sucio descubrió Creed sobre Andy?', '2009-05-14', 2316),
(886, 'Temporada 8', 'Comentarios fuera de lugar, conductas mezquinas y cero productividad… Se puede cambiar de jefe, pero no se puede cambiar la oficina. La octava temporada de esta comedia de éxito promete ser la más interesante, en la que nuestro querido elenco mantiene Dunder Mifflin a flote en un mundo (y un edificio de oficinas) sin Michael Scott.', '2011-09-22', 2316),
(887, 'Navidades a la japonesa', 'Parte 1 de 2. Un conflicto en el comité organizador de la fiesta de Navidad dará como resultado dos fiestas rivales, mientras a Michael le abandonan durante las vacaciones.', '2006-12-14', 2316),
(888, 'La feria de empleo', 'Jim va al campo de golf con Andy y Kevin con la esperanza de conseguir un buen cliente. Michael coloca un stand en una feria del trabajo en la universidad de Pam para contratar a un interno para el verano.', '2008-05-08', 2316),
(889, 'La subida salarial', 'Jim aprende rápido el lado negativo de la gestión de empresas tras informar de que no hay dinero para que todo el personal tenga un aumento.', '2009-10-01', 2316),
(890, 'Chantaje: Kelly', 'Después de chantajear a Oscar Martínez y Andy, Creed decide chantajear a Kelly Kapoor.', '2009-05-21', 2316),
(891, 'Los cuestionarios de los clientes', 'Dwight y Jim se quedan aturdidos cuando ven que los resultados de las encuestas no son buenos. Pam y Jim descubren una forma de estar siempre juntos.', '2008-11-06', 2316),
(892, 'Chicos y chicas', 'Jan celebra un seminario titulado La mujer en el lugar de trabajo para las empleadas de Dunder-Mifflin. Michael, que se siente bastante discriminado con este asunto, decide llevar a cabo su propio seminario y traslada a todos los hombres al almacén.\n\n', '2006-02-02', 2316),
(893, 'Nepotismo', 'La incompetencia de un nuevo asistente tiene el personal de Dunder Mifflin en pie de guerra, pero Michael se niega a despedirlo porque es su sobrino.', '2010-09-23', 2316),
(894, 'Temporada 9', 'En la novena temporada de la serie, Andy Bernard, el presumido vendedor y acérrimo antiguo alumno de Cornell, cuyo infinito y singular talento musical mantiene entretenida a la oficina, se convierte en el nuevo gerente de la sede de Scranton de Dunder Mifflin.', '2012-09-20', 2316),
(895, 'La vuelta de las vacaciones', 'Michael vuelve de sus vacaciones en Jamaica completamente relajado, pero todo cambia cuando una fotografía empieza a circular entre los empleados.', '2007-01-04', 2316),
(896, 'Adiós, Toby', 'Toby deja Dunder Mifflin y Michael quiere organizar una fiesta de despedida para celebrar su partida. Angela se niega a ayudarlo y Michael le pide ayuda a Phyllis. Ni Dwight ni Meredith están satisfechos con la llegada de Holly, el reemplazo de Toby.', '2008-05-15', 2316),
(897, 'Chantaje: La venganza', 'Los empleados de Dunder Mifflin están hartos de los chantajes de Creed. Como resultado, le muestran datos interesantes sobre Creed.', '2009-05-28', 2316),
(898, 'Niágara', 'Todos los empleados de Dunder Mifflin viajan hasta las cataratas del Niágara para asistir a la boda de Jim y Pam. Y al novio se le escapa un secreto.', '2009-10-08', 2316),
(899, 'El viaje de negocios', 'Michael va por viaje de negocios a Canadá y Oscar y Andy le acompañan. Mientras, Jim cuenta los días para que Pam acabe de estudiar Bellas artes.', '2008-11-13', 2316),
(900, 'La terapia', 'Michael se somete a terapia con Toby. Dwight va en busca de venganza tras sufrir un desaire. Y por otro lado, Pam quiere un puesto de trabajo nuevo.\n\n', '2010-09-30', 2316),
(901, 'El Día de San Valentín', 'Los empleados de Dunder-Mifflin se juntan como escolares para celebrar San Valentín mientras Michael está en Nueva York, en una conferencia con los responsables de la empresa. Después de realizar un recorrido por su ciudad favorita con los encargados del documental, Michael comenta delante de los otros ejecutivos que Jan y él se enrollaron. La situación empeora cuando se da cuenta de que Jan y el nuevo gerente financiero también han escuchado su comentario. En Scranton, Pam se enfada al no recibir ningún regalo de Roy y Dwight trata de encontrar un detalle para Kelly.', '2006-02-09', 2316),
(902, 'La lista', 'Una lista dejada por Robert incluye a los trabajadores en dos columnas que no han sido nombradas por lo que tendrán que averiguar que significa.\n\n', '2011-09-22', 2316),
(903, 'Carrera de vendedores', 'Los empleados se agrupan en parejas para las tareas de venta telefónica. Dwight trata de cubrir a Angela cuando ésta olvida una fecha importante.', '2007-01-11', 2316),
(904, 'Incriminar a Toby', 'Cuando Michael descubre que han vuelto a contratar a Toby para sustituir a Holly, intentará que le despidan. Jim compra la casa de los padres de Pam.', '2008-11-20', 2316),
(905, 'Mafia', 'Dwight y Andy creen que un vendedor de seguros que visita Michael es un mafioso. Kevin arruina sin saberlo la luna de miel de Pam y Jim.', '2009-10-15', 2316),
(906, 'Carrete de tomas falsas de la temporada 5', 'Carrete de tomas falsas de la temporada 5', '2009-09-08', 2316),
(907, 'La obra de Andy', 'Andy invita a toda la oficina a la producción de Sweeney Todd en la que participa con su compañía de teatro local, pretendiendo impresionar a Erin.\n\n', '2010-10-07', 2316),
(908, 'El discurso de Dwight', 'Dwight debe enfrentarse a su miedo a hablar en público cuando es nombrado vendedor del año. Antes de la gran convención en la que tendrá que decir unas palabras, Dwight le pide a Michael que le ayude a vencer su temor. Mientras, Pam está muy ocupada con los preparativos de su boda y Jim quiere huir de la ciudad por un tiempo para no tener que presenciar el enlace.\n\n', '2006-03-02', 2316),
(909, 'El incentivo', 'Robert reta a la oficina a doblar sus ventas.\n\n', '2011-09-29', 2316),
(910, 'Nuevos compañeros', 'En el inicio de la novena temporada, dos nuevos jóvenes empleados llegan a la empresa y rápidamente son nombrados como los nuevos Jim y Dwight. Además, Andy regresa de su formación y busca vengarse de Nellie.', '2012-09-20', 2316),
(911, 'El superávit', 'Michael debe gastarse un gran superávit, pero no sabe si hacerlo en sillas o en una nueva fotocopiadora. Andy y Angela comienzan a preparar su boda.', '2008-12-04', 2316),
(912, 'El regreso', 'Oscar vuelve de vacaciones y se plantea su futuro en la compañía. Andy aprovecha la situación para tratar de convertirse en el número dos de Michael.', '2007-01-18', 2316),
(913, 'Sexualidad Sutil: Diferencias creativas', 'Kelly y Erin trabajan con Ryan para crear una nueva banda llamada \"Sexualidad Sutil\".', '2009-10-29', 2316),
(914, 'La novia', 'Jim y Pam se quedan aturdidos al descubrir que Michael sale con la madre de ésta. Dwight fastidia el despacho de Jim con el pretexto de un regalo.', '2009-10-22', 2316),
(915, 'La lotería', 'Los trabajadores de del almacén dejan el trabajo después de haber ganado la lotería.', '2011-10-06', 2316),
(916, 'El día de las hijas en la oficina', 'La rutina diaria de Dunder Mifflin cambia cuando varias niñas acuden al día de las hijas en la oficina. Michael se lleva una sorpresa al entablar Amistad con la hija de 5 años de su mayor enemigo, Toby. Pam está desesperada por llevarse bien con las hijas de sus compañeros mientras un malentendido pone a Ryan en una difícil situación con Stanley.', '2006-03-16', 2316),
(917, 'Educación sexual', 'Un herpes labial lleva a Michael a ponerse en contacto con todas sus exnovias. Andy organiza un foro de educación sexual para el personal.', '2010-10-14', 2316),
(918, 'Navidades marroquíes', 'Phyllis decide que la fiesta para empleados será de temática marroquí. Los problemas comienzan cuando Meredith se emborracha y su pelo se quema.', '2008-12-11', 2316),
(919, 'La boda de Roy', 'Jim y Pam se sorprenden al recibir una invitación a la boda de Roy y así descubren lo mucho que ha cambiado la expareja de Pam. Por su parte, Andy y Erin preparan una audición para Dwight Junior pero alguien trata de interferir.', '2012-09-27', 2316),
(920, 'Benjamin Franklin', 'Para celebrar la despedida de soltera de Phyllis, Michael contrata a dos strippers fuera de lo común', '2007-02-01', 2316),
(921, 'Sexualidad Sutil: El reemplazo', 'Cuando Ryan abandona el grupo de música, las chicas buscan un nuevo miembro.', '2009-10-29', 2316),
(922, 'Fiesta campestre', 'Andy es el anfitrión de una fiesta en las granjas Schrute, intentado impresionar a Robert.', '2011-10-13', 2316),
(923, 'El estanque de las carpas', 'Michael se cae en un estanque koi durante una visita de negocios convirtiéndose en el hazmerreír. Pam y Andy son confundidos como pareja.', '2009-10-29', 2316),
(924, 'El duelo', 'Antes de irse a Nueva York por una reunión, Michael le cuenta a Andy que Angela y Dwight están juntos. Dwight y Andy se encargarán del asunto.', '2009-01-15', 2316),
(925, 'El golpe', 'Michael, Jim y Dwight preparan una estafa para averiguar porque un vendedor de la competencia tiene tanto éxito.', '2010-10-21', 2316),
(926, 'Los antepasados de Andy', 'Andy presume de su genealogía cuando descubre que está relacionado con Michelle Obama. Por su parte, Daryl se esfuerza en su nuevo puesto de trabajo, mientras que Dwight enseña a Erin un nuevo lenguaje para impresionar a la familia de su novio.', '2012-10-04', 2316),
(927, 'La boda de Phyllis', 'Phillys se arrepiente de haber dado tanto protagonismo a Michael en su boda. Pam descubre que la boda se le hace demasiada conocida', '2007-02-08', 2316),
(928, 'Sexualidad Sutil: El videoclip', 'El producto terminado se revela cuando Erin y Kelly ven su nuevo videoclip.', '2009-10-29', 2316),
(929, 'El cumpleaños de Michael', 'Mientras Kevin y el resto de compañeros esperan con preocupación los resultados médicos que revelen si tiene cáncer de piel, Michael se enfada al ver que nadie parece estar disfrutando en la fiesta de cumpleaños que él mismo ha organizado. Más tarde, el jefe decide llevar a todos a patinar para hacerles olvidar el momento tan tenso que están viviendo.\n\n', '2006-03-30', 2316),
(930, 'El miedo', 'Erin intenta desesperadamente organizar la fiesta de Halloween perfecta.', '2011-10-27', 2316),
(931, 'Dobles parejas', 'Jim y Pam organizan una doble cita con la madre de Pam y Michael. Dwight comienza a ser agradable para ganarse el favor de todos sus compañeros.', '2009-11-05', 2316),
(932, 'El papel de la familia Prince', 'Andy y Dwight espían a una compañía de la competencia. El resto de la oficina se encarga de debatir si Hilary Swank es guapa o no.', '2009-01-22', 2316),
(933, 'El concurso de disfraces', 'El personal de la empresa organiza un concurso para elegir el mejor disfraz de Halloween.\n\n', '2010-10-28', 2316),
(934, 'El bus oficina', 'Los empleados salen a la carretera en un autobús alquilado cuando el edificio es declarado inseguro. Mientras tanto, Nellie se muestra más cercana con Andy para que le ayude en la adopción de un bebé, mientras que Jim utiliza una tarta para alegrar a Pam.', '2012-10-18', 2316),
(935, 'La prueba de drogas', 'Dwight juega el papel de sheriff voluntario cuando encuentra un porro en el parking de Dunder Mifflin. El tema se vuelve una obsesión para él, que lleva a cabo una investigación en toda regla para hallar al culpable. Mientras, Pam reta a Jim a mantenerse callado hasta que le de a su compañera una lata de coca cola.\n\n', '2006-04-27', 2316),
(936, 'Escuela de negocios', 'Ryan invita a Michael a que dé una charla en la escuela de negocios. Mientras, Pam organiza su primera exposición artística.', '2007-02-15', 2316),
(937, 'La Mentora: La alumna', 'Erin considera convertirse en contable y Angela la toma bajo su tutela.', '2010-03-04', 2316),
(938, 'El cataclismo', 'Dwight activa un mecanismo del día del juicio final que cuenta los fallos de los trabajadores.', '2011-11-03', 2316),
(939, 'Asesinato', 'A Michael se le ocurre una idea para distraer al personal de los rumores de que Dunder Mifflin está en bancarrota. Andy aprovecha para ligar con Erin.', '2009-11-12', 2316),
(940, 'Liberación de tensiones', 'Stanley sufre un infarto por un simulacro de incendio demasiado realista causado por Dwight. Michael decide que la oficina necesita aliviar el estrés.', '2009-02-01', 2316),
(941, 'Bautizo', 'Al bautizo de Cecilia asiste demasiada gente porque Michael ha invitado a todo el personal de la oficina.\n\n', '2010-11-04', 2316),
(942, 'Los agudos', 'Para la fiesta de Halloween, Andy invita a su grupo de canto a capela y acaba enfrentándose a un viejo enemigo. Además, Dwight encuentra pistas de que un loco anda suelto en la oficina y tratará de encontrarlo, mientras que Pam discute con Jim por su nuevo empleo.', '2012-10-25', 2316),
(943, 'Solución de conflicto', 'Michael se hace cargo de una disputa entre Angela y Oscar que intentaba resolver el jefe de Recursos Humanos. Al tratar el tema en persona, el jefe de la oficina destapa la existencia de una caja que contiene todas las quejas que han realizado los empleados de sus compañeros. Michael lee en alto y sin reparos el contenido de cada una de ellas, lo que ocasiona el caos entre los trabajadores.\n\n', '2006-05-04', 2316),
(944, 'La Mentora: Reembolsos', 'Mientras Erin continúa probando suerte con la contabilidad, lucha por transmitir autoridad.', '2010-03-04', 2316),
(945, 'La sustituta de Pam', 'Pam quiere que Dwight ayude a Jim a admitir que su sustituta por baja por maternidad es guapa.', '2011-11-10', 2316),
(946, 'La junta de accionistas', 'Michael se lleva a Dwight, Andy y Oscar a la reunión de accionistas de Dunder Mifflin en Nueva York, donde va a ser reconocido como el mejor director.', '2009-11-19', 2316),
(947, 'Quedada televisiva', 'Para que Michael y Gabe se lleven mejor, Erin organiza una pequeña fiesta para ver el último episodio de Glee en casa de Gabe.\n\n', '2010-11-11', 2316),
(948, 'Serie de charlas (1ª parte)', 'Michael es enviado con Pam a otras sucursales de Dunder Mifflin para explicar el éxito de Scranton. Dwight y Jim olvidan el cumpleaños de Kelly.', '2009-02-05', 2316),
(949, 'Cócteles', 'Durante un evento de la empresa Jim y Pam deciden hacer público su romance secreto.', '2007-02-22', 2316),
(950, 'La Mentora: Hora de la comida', 'Tomándose el trabajo de contabilidad en serio, Erin renuncia a la comida para quedarse con Angela.', '2010-03-04', 2316),
(951, 'El barco', 'La familia de Andy se ve perjudicada por graves problemas económicos. Además, Dwight asiste a un programa de radio local, por lo que sus compañeros le acosarán con bromas telefónicas, mientras que Kevin descubre un secreto sobre Oscar.', '2012-11-08', 2316),
(952, 'Gettysburg', 'Andy espera motivar al personal llevándoles a una excursión a Gettysburg.', '2011-11-17', 2316),
(953, 'Noche de casino', 'Los encargados de Dunder-Mifflin organizan una noche de casino en el almacén con el propósito de recaudar fondos para fines benéficos. Mientras, Michael intenta arreglárselas para que ninguna de sus dos citas se entere de la existencia de la otra y Jim no tiene otra salida que afrontar la realidad y lo que significará para su relación con Pam su traslado a la sucursal de Stamford.\n\n', '2006-05-11', 2316),
(954, 'Los chavales de Scott', 'Michael se encuentra con que debe cumplir una vieja promesa. Jim quiere subir el ánimo de la oficina, ante los rumores de despidos en Dunder Mifflin.', '2009-12-03', 2316),
(955, 'Serie de charlas (2ª parte)', 'Michael y Pam viajan a Nashua y descubren que Holly tiene un nuevo novio. En la oficina, Dwight y Jim intentan organizar una fiesta a Kelly.', '2009-02-12', 2316),
(956, 'La negociación', 'Michael y Darryl deciden ir a las oficinas centrales de Dunder Mifflin para tartar de conseguir un aumento de sueldo.', '2007-04-05', 2316),
(957, 'La Mentora: ¿MAPS?', 'Cuando Kelly y Ryan le muestran a Erin que son mejores amigas, Angela se enfada lo que hace que Kevin haga una oferta.', '2010-03-04', 2316),
(958, 'WUPHF.com', 'Michael ayuda a Ryan a generar capital para su servicio de Wuphf.', '2010-11-18', 2316),
(959, 'La ballena', 'Dwight se enfrenta a su talón de aquiles: vender un producto a una mujer. Por ello, sus compañeras le dan algunos consejos para tener éxito con una cliente importante. Mientras tanto, Angela y Oscar sospechan que el senador Lipton les engaña.', '2012-11-15', 2316),
(960, 'La señora de California', 'Andy se encuentra en una situación poco cómoda cunado se entera de que Robert no va a contratar a su mujer.', '2011-12-01', 2316),
(961, 'Amigo invisible', 'La idea de Andy para los regalos de Navidad le hace a Erin más mal que bien. Dwight y Jim intentan contagiar a todos el espíritu de estas fechas.', '2009-12-10', 2316),
(962, 'Prevención de riesgos laborales', 'Andy vuelve a la oficina tras varias semanas de cursos con la idea de realizar mejoras entre sus compañeros.', '2007-04-12', 2316),
(963, 'Carrete de tomas falsas de la temporada 6', 'Carrete de tomas falsas de la temporada 6', '2010-09-07', 2316),
(964, 'Donación de sangre', 'Michael se fija en una misteriosa mujer durante la campaña de donación de sangre. Dwight y Kevin encuentran pareja en una fiesta para solteros.', '2009-03-05', 2316),
(965, 'China', 'El hecho de que China se esté convirtiendo en una superpotencia mundial hace que Michael piense como mantener el ritmo de crecimiento de América.\n\n', '2010-12-02', 2316),
(966, 'El objetivo', 'Angela descubre la verdad sobre la aventura de su marido con Oscar, así que recurre a Dwight para que la ayude. Mientras tanto, Jim pide un favor a Stanley y a Phyllis, Pam empieza a pintar un mural en el almacén y Pete construye una torre hecha de cartas.', '2012-11-29', 2316),
(967, 'El banquero', 'Cuando un futuro comprador de Dunder Mifflin envía a un banquero a la oficina de Scranton se recuerdan varios acontecimientos del pasado.\n\n', '2010-01-21', 2316),
(968, 'Deseos navideños', 'Andy trata de hacer que la Navidad de este año, sea la mejor de la historia mediante la concesión de deseos de vacaciones de cada persona. Mientras tanto, Robert intenta ahogar sus penas en la fiesta de la oficina.', '2011-12-08', 2316),
(969, 'La retirada del producto', 'Una crisis de grandes proporciones asola Dunder Mifflin cuando se descubre que se ha enviado una gran cantidad de papel con dibujos obscenos.', '2007-04-26', 2316),
(970, 'Episodio 35', '', '2010-09-08', 2316),
(971, 'El cupón dorado', 'La idea de Michael de utilizar vales dorados en los descuentos para clientes, al más puro estilo de Willy Wonka, se vuelve contraproducente.', '2009-03-12', 2316),
(972, 'La Navidad de Dwight', 'Ha llegado el día de la fiesta de Navidad en la empresa, pero nadie ha preparado nada. Por ello, Dwight les enseña como su familia celebra estas fiestas en Alemania. Además, Darryl sospecha que Jim se ha olvidado de incluirlo en la nueva oportunidad de empleo.', '2012-12-06', 2316),
(973, 'Navidades con clase', 'Holly vuelve a la oficina para sustituir a Toby mientras este asiste a un juicio como Jurado', '2010-12-09', 2316),
(974, 'El concurso de preguntas y respuestas', 'Andy anima a la oficina a recaudar dinero para llegar al objetivo de ventas trimestral.', '2012-01-12', 2316);
INSERT INTO `media` (`id`, `title`, `description`, `release_date`, `tmdb_id`) VALUES
(975, 'Sabre', 'Michael tiene problemas con la adquisición de Dunder Mifflin por una compañía de llamada Sabre. Jim y Pam intentan conseguir una buena guardería.\n\n', '2010-02-04', 2316),
(976, 'El 3er Piso: Adelante', 'Kelley y Erin encuentran una nueva forma de hacerse famosos.', '2010-10-28', 2316),
(977, 'El nuevo jefe', 'Michael quiere celebrar sus 15 años en Dunder Mifflin con una fiesta. Pero el nuevo vicepresidente se cruza en su camino interfiriendo en su idea.', '2009-03-19', 2316),
(978, 'Respeto a las mujeres', 'Phyllis es asaltada por un exhibicionista. La oficina se revoluciona y Dwight y Andy deciden tratar de atraparlo.', '2007-05-03', 2316),
(979, 'Piojos', 'Pam trae piojos a la oficina y se los pasa a Meredith, mientras que Dwight se compromete a acabar con ellos. Por su parte, Jim pasa un gran día en Filadelfia conociendo a un cliente potencial. Además, Phyllis, Kevin y Nellie se inmiscuyen en la vida amorosa de Darryl.', '2013-01-10', 2316),
(980, 'Ultimátum', 'Michael aguarda noticias de Holly ya que le ha pedido matrimonio a A.J.\n\n', '2011-01-20', 2316),
(981, 'La fiesta de la piscina', 'Antes de vender su mansión, Robert organiza una fiesta.', '2012-01-19', 2316),
(982, 'Director y vendedor', 'El director de Sabre llega de visita y le dice a Michael y a Jim que uno de los dos debe dedicarse a las ventas. Kelly piensa que le interesa a Andy.\n\n', '2010-02-11', 2316),
(983, 'Dos semanas', 'Cuanto más es observado por su nuevo jefe, la conducta de Michael se vuelve más descuidada. Pam se las tendrá que ver con una fotocopiadora.', '2009-03-26', 2316),
(984, 'El 3er Piso: ¡Luces, cámara, acción!', 'Comienza el rodaje de la película de terror de Ryan.', '2010-10-28', 2316),
(985, 'Juegos de playa', 'Michael decide organizar una excursión con los empleados de la oficina a la playa donde propondrá juegos de supervivencia.', '2007-05-10', 2316),
(986, 'La sastrería', 'Clark lleva a la oficina una máquina de café nueva y causa un gran revuelo entre sus compañeros. Además, él y Dwight se harán pasar por padre e hijo en una venta. Por su parte, Darryl tiene una entrevista de trabajo en la compañía de Jim.', '2013-01-17', 2316),
(987, 'El seminario', 'Andy espera incrementar las ventas organizando un seminario económico.\n\n', '2011-01-27', 2316),
(988, 'Miembro del jurado', 'Dwight presiona a Jim para que le proporcione información sobre el juicio del que es jurado.', '2012-02-02', 2316),
(989, 'El equipo campeón', 'Michael busca entre los empleados a un dream team para su nueva compañía. Jim se arrepiente de haberle dicho a Charles que juega al fútbol.', '2009-04-09', 2316),
(990, 'El parto', 'Jim y Pam quieren retrasar su llegada al hospital hasta después de la medianoche, y todos se esfuerzan en distraerla tras las primeras contracciones.', '2010-03-04', 2316),
(991, 'El 3er Piso: El resultado final', 'Eso es todo. Mira el avance completo de \"El 3er Piso\", si te atreves.', '2010-10-28', 2316),
(992, 'La lealtad del cliente', 'Dwight trata de convencer a Darryl para que no se vaya a trabajar a la nueva empresa de Jim. Mientras tanto, Jim se pierde el primer recital de su hija y provoca que Pam se enfade. Además, entra en escena una de las personas que está detrás de las cámaras.', '2013-01-24', 2316),
(993, 'El trabajo', 'Una oferta de trabajo en las oficinas centrales de Nueva York hace que Michael, Jim y Karen se enfrenten entre ellos para cubrir el puesto', '2007-05-17', 2316),
(994, 'La búsqueda', 'Una emergencia obliga a Jim a dejar a Michael en una gasolinera sin dinero ni teléfono.\n\n', '2011-02-03', 2316),
(995, 'La empresa de papel de Michael Scott', 'Ryan, Michael y Pam inauguran su nueva oficina, situada en el mismo edificio que Dunder Mifflin. El espacio es tan pequeño que los dos empleados discuten continuamente, y Michael debe improvisar ideas para evitar que esto ocurra. Mientras, en la antigua oficina, Andy y Dwight tratan de no competir por la atención de la nueva recepcionista, Kelly.', '2009-04-09', 2316),
(996, 'El proyecto especial', 'Dwight es elegido para realizar una tarea en Tallahassee y debe elegir a alguien de la oficina para que le acompañe.', '2012-02-09', 2316),
(997, 'Día de San Patricio', 'Michael se queda desconcertado por la reacción de Jo ante las ideas de Darryl. Dwight se pone nervioso cuando Jim vuelve de su baja de paternidad.', '2010-03-11', 2316),
(998, 'El Podcast: El podcast de Gabe', 'Gabe está celoso por la atención hacia el blog de Oscar.', '2011-01-20', 2316),
(999, 'Auxiliar de ventas', 'A Dwight le encargan contratar a un vendedor a tiempo parcial que sustituya a Jim. Para ello, organiza una entrevista de trabajo con algunos de sus amigos, entre los que se encuentra su primo Mose. Además, Pam tiene curiosidad por saber quien será su nuevo compañero.', '2013-01-31', 2316),
(1000, 'Dura competencia', 'La lealtad de Dwight a Michael se pone a prueba cuando ve un heroe en Charles. Mientras tanto, Andy intenta proveer a Jim de sus necesidades emocionales.', '2009-04-16', 2316),
(1001, 'DPA', 'El personal del a oficina comienza a sentirse incómodo antes las muestras públicas de afecto de Michael y Holly.', '2011-02-10', 2316),
(1002, 'Tallahassee', 'Andy sustituye a Erin en las tareas de la recepción.', '2012-02-16', 2316),
(1003, 'Nuevos clientes', 'Michael continúa adaptándose a la política de Sabre, ideando nuevas estrategias que darán lugar a un complicado exceso de ego en Dunder Mifflin.\n\n', '2010-03-18', 2316),
(1004, 'El Podcast: La primera entrada', 'Los compañeros de trabajo de Gabe aceptan estar en su podcast.', '2011-01-20', 2316),
(1005, 'Nivel de amenaza: Medianoche', 'Finalmente Michael puede visionar Nivel de amenaza: medianoche terminada.', '2011-02-17', 2316),
(1006, 'Por la noche', 'Andy obliga al equipo que queda en Scranton a trabajar horas extra para cubrir el resto de personal que está en Tallahassee.', '2012-02-23', 2316),
(1007, 'Vandalismo', 'Alguien ha causado desperfectos en el mural de Pam, por lo que Dwight y Nellie buscan al culpable. Además, Darryl se siente incómodo al ver el desorden que hay en el apartamento que comparte con Jim, mientras que Angela organiza la fiesta de cumpleaños de su hijo.', '2013-01-31', 2316),
(1008, 'La hora feliz', 'En la hora feliz de Dunder Mifflin, que Oscar promueve, Michael intenta impresionar a un amigo de Jim y Pam. Andy quiere ocultar su relación con Erin.\n\n', '2010-03-25', 2316),
(1009, 'Todd Packer', 'Todd está cansado de ser un vendedor ambulante y quiere conseguir una mesa en Scranton.\n\n', '2011-02-24', 2316),
(1010, 'El Podcast: El debut', 'Gabe y sus compañeros de trabajo intentan crear su primer podcast.', '2011-01-20', 2316),
(1011, 'Arruinado', 'La nueva compañía de Michael tiene problemas para sus entregas matutinas mientras la oficina trabaja contra reloj para terminar los informes de gastos a tiempo.', '2009-04-23', 2316),
(1012, 'Pruebas en la tienda', 'Dwight pretende impresionar a Nellie con una pretenciosa inauguración de la filial de Sabre.', '2012-03-01', 2316),
(1013, 'Descuento para parejas', 'Los empleados se hacen pasar por parejas para aprovechar un descuento del día de San Valentín en el centro comercial. Además, Erin está decidida a romper con Andy, pero Pete no confía en que lo haga. Mientras tanto, Jim y Pam se citan con Brian, el técnico de sonido.', '2013-02-07', 2316),
(1014, 'Venta de objetos usados', 'La oficina alberga un mercadillo en el garaje y Dwight se ha propuesto vender todo lo que pueda, empezando por una chincheta\n\n', '2011-03-24', 2316),
(1015, 'El día de la secretaria', 'Andy intenta dar a Erin el perfecto Día de la Secretaria, pero se ve empañado porque Michael revela su pasado con Angela.', '2010-04-22', 2316),
(1016, 'Nivel de amenaza: Medianoche: La Película', 'Después de que el agente secreto Michael Scarn se vea obligado a retirarse debido a la muerte de su esposa Catherine Zeta-Scarn, el presidente de los Estados Unidos de América solicita que evite que Goldenface haga explotar el Juego de Estrellas de la NHL y matar a varios rehenes.', '2011-02-18', 2316),
(1017, 'Viernes informales', 'Michael debe mediar en la disputa de su nuevo equipo de ventas. Mientras tanto, los problemas no cesan en la oficina cuando varios empleados se toman el \"Viernes campechano\" muy a pecho', '2009-04-30', 2316),
(1018, 'Hay que superarlo', 'Pam acude a una entrevista de trabajo en Filadelfia, pero su posible futuro jefe le recuerda demasiado a Michael Scott. Además, Angela ayuda a Dwight a cuidar a su tía Shirley, mientras que Andy trata que Pete y Erin se sientan incómodos.', '2013-02-14', 2316),
(1019, 'El último día en Florida', 'Andy descubre que Erin no volverá a Scranton.', '2012-03-08', 2316),
(1020, 'El nuevo jefe', 'La llegada del nuevo jefe sustituto de Michael revoluciona a todo el personal que intenta ganarse un trato de favor.\n\n', '2011-04-14', 2316),
(1021, 'Lenguaje corporal', 'Donna podría está coqueteando con Michael para conseguir un buen trato. Dwight le dice a Kelly que debe inscribirse en un programa de formación\n\n', '2010-04-29', 2316),
(1022, 'Café disco', 'Michael decide abrir una discoteca-cafeteria en su antigua oficina. Pam y Jim planean un viaje secreto.', '2009-05-07', 2316),
(1023, 'La Chica de al Lado: La historia de Sexualidad Sutil', 'Kelly Kapoor y Erin Hannon revelan los detalles detrás de la realización de su videoclip, \"La Chica de al Lado\".', '2011-05-04', 2316),
(1024, 'La granja', 'Óscar asiste al funeral de la tía de Dwight en la granja Schrute. Allí descubren que Shirley ha estipulado en su testamento que tan solo podrán heredar la granja si Dwight y sus hermanos viven y trabajan en ella. Por otra parte, Todd Packer regresa para disculparse.', '2013-03-14', 2316),
(1025, 'A por la chica', 'Andy toma una decisión que cambia el juego y toma una odisea de viaje por carretera en el nombre del romance. En otros lugares, Nellie llega a la sucursal de Scranton y se dispone a tomar la posición de gerente.', '2012-03-15', 2316),
(1026, 'Los últimos Dundies de Michael', 'Michael pasa el relevo a Deangelo para que lleve a cabo su primera tarea oficial: la organización de los Premios Dundie. Will Ferrell aparece como artista invitado.', '2011-04-21', 2316),
(1027, 'Picnic de la empresa', 'Final de temporada – La oficina de Scranton participa en el picnic de la empresa. Con la participación de Amy Ryan («Adiós, pequeña adiós»), candidata al Óscar, e Idris Elba («The Wire») como artistas invitados.', '2009-05-14', 2316),
(1028, 'La Chica de al Lado: La Chica de al Lado', 'Videoclip que cuenta la historia de un deportista de instituto que se pregunta si tomó la decisión equivocada al elegir a la chica popular sobre la chica empollona.', '2011-05-04', 2316),
(1029, 'Tráileres', 'Todos en la oficina se muestran exultantes cuando aparecen las primeras imágenes del documental grabado durante años. Sin embargo, tienen miedo de que sus secretos salgan a la luz. Además, Pam reflexiona sobre lo mucho que ha cambiado su relación con Jim.', '2013-04-04', 2316),
(1030, 'El encubrimiento', 'Michael tira de Dwight cuando piensa que Donna le puede estar engañando. Andy no logra que alguien de la oficina le ayude con la queja de un cliente.\n\n', '2010-05-06', 2316),
(1031, 'Adiós, Michael', 'Michael espera tener un día tranquilo en su despedida de la oficina.', '2011-04-28', 2316),
(1032, 'Fiesta de bienvenida', 'Robert fuerza a la filial de Scranton a preparar una fiesta de bienvenida para Nellie.', '2012-04-12', 2316),
(1033, 'Carrete de tomas falsas de la temporada 7', 'Carrete de tomas falsas de la temporada 7', '2011-09-06', 2316),
(1034, 'Escalerarmagedón', 'Los trabajadores se ven obligados a utilizar las escaleras porque el ascensor está fuera de servicio. Además, Dwight trata de convencer a Stanley para que haga una llamada a un cliente importante, mientras que Nellie y Toby dan consejo matrimonial a Pam y Jim.', '2013-04-11', 2316),
(1035, 'El otro', 'Todos se sorprenden de que Michael continúe con Donna tras averiguar que está casada. El bebé no deja dormir a Jim y Pam, que están exhaustos.\n\n', '2010-05-13', 2316),
(1036, 'Andy se enfada', 'Andy vuelve a la oficina de Scranton y descubre que su puesto ha sido usurpado por Nellie.', '2012-04-19', 2316),
(1037, 'El grupito', 'Michael espera tener un día tranquilo en su despedida de la oficina.', '2011-05-05', 2316),
(1038, 'Carrete de tomas falsas de la temporada 8', 'Carrete de tomas falsas de la temporada 8', '2012-09-04', 2316),
(1039, 'Aviones de papel', 'En la oficina se lleva a cabo una competición de aviones de papel. Mientras tanto, Andy consigue su primer papel como actor en un filme corporativo y Jim y Pam tratan de utilizar las habilidades matrimoniales que han aprendido.', '2013-04-25', 2316),
(1040, 'El delator', 'La prensa se entera de lo que ha ocurrido con las impresoras de Sabre y la directora llega a Scranton buscando al que ha filtrado la información.\n\n', '2010-05-20', 2316),
(1041, 'La cena benéfica', 'Andy comete un grave e error cuando se presenta a la subasta benéfica organizada por Robert Lipton.', '2012-04-26', 2316),
(1042, 'Dwight. K. Schrute interino', 'Dangelo crea un círculo con sus empleados favoritos, y parece que las mujeres han quedado fuera.', '2011-05-12', 2316),
(1043, 'Episodio 47', '', '2013-05-16', 2316),
(1044, 'Un sueño hecho realidad', 'Andy decide intentar hacer realidad su sueño.', '2013-05-02', 2316),
(1045, 'Lucha territorial', 'Ante el cierre de la sucursal de Dunder Mifflin, Dwight y Jim se unen para conseguir su cartera de clientes.', '2012-05-03', 2316),
(1046, 'Comisión de búsqueda', 'Jim, Toby y Gabe forman una comisión de búsqueda para encontrar nuevo gerente de la filial de Scranton.', '2011-05-19', 2316),
(1047, 'Carrete de tomas falsas de la temporada 9', 'Carrete de tomas falsas de la temporada 9', '2013-09-03', 2316),
(1048, 'A.A.D.R.', 'Jim organiza pruebas para el puesto de ayudante del ayudante del director regional.', '2013-05-09', 2316),
(1049, 'Retrato de familia gratis', 'Dwight proporciona a los trabajadores de Scranton retratos de sus familias gratuitos.', '2012-05-10', 2316),
(1050, 'Episodio 49', '', '2021-01-01', 2316),
(1051, 'Final', 'Último episodio de \"The Office\" en el que los trabajadores de la oficina responden a las preguntas sobre el documental. Además, todos ellos acuden a la boda de Dwight y Angela en la granja Schrute.', '2013-05-16', 2316),
(1052, 'Episodio 50', '', '2005-01-01', 2316),
(1053, 'Episodio 51', '', '2005-01-06', 2316),
(1054, 'Episodio 53', '', '2006-09-08', 2316),
(1055, 'Episodio 54', '', '2006-09-14', 2316),
(1056, 'Episodio 55', '', '2006-09-19', 2316),
(1057, 'Episodio 56', '', '2006-09-21', 2316),
(1058, 'Episodio 57', '', '2006-12-14', 2316),
(1059, 'Episodio 58', '', '2007-05-17', 2316),
(1060, 'Episodio 59', '', '2007-09-03', 2316),
(1061, 'Episodio 60', '', '2007-09-06', 2316),
(1062, 'Episodio 61', '', '2008-09-03', 2316),
(1063, 'Episodio 62', '', '2008-09-09', 2316),
(1064, 'Episodio 63', '', '2008-09-11', 2316),
(1065, 'Episodio 64', '', '2008-09-16', 2316),
(1066, 'Episodio 65', '', '2009-09-18', 2316),
(1067, 'Episodio 66', '', '2009-09-24', 2316),
(1068, 'Episodio 67', '', '2009-09-29', 2316),
(1069, 'Episodio 68', '', '2009-10-01', 2316),
(1070, 'Episodio 69', '', '2009-10-06', 2316),
(1071, 'Episodio 70', '', '2010-09-01', 2316),
(1072, 'Episodio 71', '', '2010-09-07', 2316),
(1073, 'Episodio 72', '', '2010-09-09', 2316),
(1074, 'Episodio 73', '', '2010-09-14', 2316),
(1075, 'Episodio 74', '', '2010-09-16', 2316),
(1076, 'Episodio 75', '', '2011-09-07', 2316),
(1077, 'Episodio 76', '', '2011-09-13', 2316),
(1078, 'Episodio 77', '', '2011-09-15', 2316),
(1079, 'Episodio 78', '', '2011-09-20', 2316),
(1080, 'Episodio 79', '', '2011-09-22', 2316),
(1081, 'Episodio 80', '', '2012-09-27', 2316),
(1082, 'Episodio 81', '', '2012-10-02', 2316),
(1083, 'Episodio 82', '', '2012-10-04', 2316),
(1084, 'Episodio 83', '', '2012-10-09', 2316),
(1085, 'Episodio 84', '', '2012-10-11', 2316),
(1086, 'Episodio 85', '', '2013-09-10', 2316),
(1087, 'Episodio 86', '', '2013-09-12', 2316),
(1088, 'Episodio 87', '', '2013-09-17', 2316),
(1089, 'Episodio 88', '', '2013-09-19', 2316),
(1090, 'Episodio 89', '', '2013-09-24', 2316),
(1091, 'Episodio 90', '', '2013-09-26', 2316),
(1092, 'Episodio 91', '', '2007-05-20', 2316),
(1093, 'Episodio 92', '', '2007-05-24', 2316),
(1094, 'Episodio 93', '', '2013-09-03', 2316),
(1095, 'Episodio 94', '', '2013-09-05', 2316),
(1096, 'Episodio 95', '', '2007-03-02', 2316),
(1097, 'Episodio 96', '', '2006-12-14', 2316),
(1098, 'Episodio 97', '', '2006-12-14', 2316),
(1099, 'Episodio 98', '', '2007-05-17', 2316),
(1100, 'Episodio 99', '', '2007-05-17', 2316),
(1101, 'Episodio 100', '', '2007-09-27', 2316),
(1102, 'Episodio 101', '', '2007-09-27', 2316),
(1103, 'Episodio 102', '', '2007-10-04', 2316),
(1104, 'Episodio 103', '', '2007-10-04', 2316),
(1105, 'Episodio 104', '', '2007-10-11', 2316),
(1106, 'Episodio 105', '', '2007-10-11', 2316),
(1107, 'Episodio 106', '', '2007-10-18', 2316),
(1108, 'Episodio 107', '', '2007-10-11', 2316),
(1109, 'Episodio 108', '', '2008-05-15', 2316),
(1110, 'Episodio 109', '', '2008-05-15', 2316),
(1111, 'Episodio 110', '', '2008-09-25', 2316),
(1112, 'Episodio 111', '', '2008-09-25', 2316),
(1113, 'Episodio 112', '', '2009-02-01', 2316),
(1114, 'Episodio 113', '', '2009-02-01', 2316),
(1115, 'Episodio 114', '', '2009-10-08', 2316),
(1116, 'Episodio 115', '', '2009-10-08', 2316),
(1117, 'Episodio 116', '', '2010-03-04', 2316),
(1118, 'Episodio 117', '', '2010-03-04', 2316),
(1119, 'Episodio 118', '', '2010-12-09', 2316),
(1120, 'Episodio 119', '', '2010-12-14', 2316),
(1121, 'Episodio 120', '', '2011-04-28', 2316),
(1122, 'Episodio 121', '', '2011-04-28', 2316),
(1123, 'Episodio 122', '', '2011-05-19', 2316),
(1124, 'Episodio 123', '', '2011-05-19', 2316),
(1125, 'Episodio 124', '', '2013-02-14', 2316),
(1126, 'Episodio 125', '', '2013-02-14', 2316),
(1127, 'Episodio 126', '', '2013-05-02', 2316),
(1128, 'Episodio 127', '', '2013-05-02', 2316),
(1129, 'Episodio 128', '', '2013-05-09', 2316),
(1130, 'Episodio 129', '', '2013-05-09', 2316),
(1131, 'Episodio 130', '', '2013-05-16', 2316),
(1132, 'Episodio 131', '', '2013-05-16', 2316),
(1133, 'Friends', 'Las aventuras de seis jóvenes neoyorquinos unidos por una divertida amistad. Entre el amor, el trabajo y la familia, comparten sus alegrías y preocupaciones en el Central Perk, su café favorito.', '1994-09-22', 1668),
(1134, 'Narcos', 'La verdadera historia de los poderosos y violentos cárteles colombianos sirve de hilo conductor en esta serie dramática de mafiosos de gran realismo.', '2015-08-28', 63351),
(1135, 'Peaky Blinders', 'Una familia de pandilleros asentada en Birmingham, Reino Unido, tras la Primera Guerra Mundial (1914-1918), dirige un local de apuestas hípicas. Las actividades del ambicioso jefe de la banda llaman la atención del Inspector jefe Chester Campbell, un detective de la Real Policía Irlandesa que es enviado desde Belfast para limpiar la ciudad y acabar con la banda.', '2013-09-12', 60574),
(1136, 'Vikingos', 'Sigue las aventuras de Ragnar Lothbrok, el héroe más grande de su época. La serie narra las sagas de la banda de hermanos vikingos de Ragnar y su familia, cuando él se levanta para convertirse en el rey de las tribus vikingas. Además de ser un guerrero valiente, Ragnar encarna las tradiciones nórdicas de la devoción a los dioses, la leyenda dice que él era un descendiente directo de Odín, el dios de la guerra y los guerreros.', '2013-03-03', 44217),
(1137, 'Lucifer\'s Kingdom', 'In a local Egyptian neighborhood, the death of the headman Fathy Eblis gives way to a series of vengeful acts and unleashes chaos upon the people.', '2020-01-31', 107285),
(1138, 'The Walking Dead', '\"The Walking Dead\" está ambientada en un futuro apocalíptico con la Tierra devastada por el efecto de un cataclismo, que ha provocado la mutación en zombies de la mayor parte de los habitantes del planeta. La serie, explora las dificultades de los protagonistas para sobrevivir en un mundo poblado por el horror, así como las relaciones personales que se establecen entre ellos, en ocasiones también una amenaza para su supervivencia.', '2010-10-31', 1402),
(1139, 'Sherlock', 'En esta renovada versión de las historias de misterio de Arthur Conan Doyle, el excéntrico detective merodea por las calles del Londres de hoy en día en busca de pistas.', '2010-07-25', 19885),
(1140, 'Black Mirror', 'Las historias más retorcidas pueblan esta alucinante serie antológica que muestra los peores rasgos de la humanidad, sus mayores innovaciones y mucho más.', '2011-12-04', 42009),
(1141, 'Cómo conocí a vuestra madre', 'How I Met Your Mother. Exitosa serie de la CBS que, en su primera temporada, obtuvo excelentes índices de audiencia además de ganar dos premios Emmy: uno a la dirección artística y otro a la fotografía. En el año 2030, Ted (Josh Radnor) relata a sus dos hijos adolescentes cómo conoció a su madre y cómo fue su vida hasta que, por fin, encontró el amor verdadero. Todo empezó cuando Marshall (Jason Segel), su mejor amigo, decidió casarse con Lily (Alyson Hannigan), su novia de toda la vida. Entonces Ted decidió lanzarse a la búsqueda del amor verdadero y formar una familia. Para conseguirlo contó con el apoyo de su amigo Barney (Neil Patrick Harris), un joven algo extravagante y muy hábil para conocer mujeres. Cuando, por fin, Ted conoce a Robin (Cobie Smulders), una impresionante joven canadiense que acaba de mudarse a Nueva York, está completamente seguro de que es amor a primera vista, pero el destino aún puede depararle muchas sorpresas.', '2005-09-19', 1100),
(1142, 'Arrow', 'Después de un violento naufragio y tras haber desaparecido y creído muerto durante cinco años, el multimillonario playboy Oliver Queen es rescatado con vida en una isla del Pacífico. De vuelta en casa en Starling City, es recibido por su madre, su hermana y su mejor amigo, quienes rápidamente notan que la terrible experiencia sufrida lo ha cambiado. Por otra parte, trata de ocultar la verdad acerca de en quién se ha convertido mientras trata de enmendar los errores que cometió en el pasado y de reconciliarse con su ex novia, Laurel Lance. Mientras trata de volver a contactar a las personas de su pasado jugando el papel del mujeriego adinerado, despreocupado y descuidado que solía ser, ayudado por su fiel chofer y guardaespaldas John Diggle, crea en secreto el personaje de un justiciero encapuchado, un vigilante que lucha contra los males de la sociedad tratando de darle a su ciudad la gloria que antes tenía; complicando esta misión.', '2012-10-10', 1412),
(1143, 'The Flash', 'John Wesley Shipp interpreta a Barry Allen, un tecnólogo criminalista, dotado de repentinos talentos tras un imprevisto accidente de laboratorio. Promete utilizar sus poderes para hacer el bien, poderes que incluyen reflejos de ultravelocidad y la capacidad para hacer vibrar sus moléculas tan rápido que puede atravesar muros. Amanda Pays es la investigadora médica Tina McGee, que sigue el metabolistmo acelerado de Allen y oculta su identidad secreta. El embaucador, el Capitán Frío, el Fantasma, inventores locos: Central City está plagada de criminales. Ahora hay un héroe que les sigue el ritmo: Se llama Flash.', '1990-09-20', 236),
(1144, 'Sobrenatural', 'Cuando eran niños, Sam y Dean Winchester, perdieron a su madre debido a una misteriosa y demoníaca fuerza supernatural. Posteriormente, su padre los crió para que fueran soldados. Él les enseño sobre el mal que vive en los rincones obscuros y en las carreteras secundarias de América... y también les enseñó como matarlo. Ahora los hermanos Winchester recorren el país en su Chevy Impala del \'67, luchando contra todo tipo de amenaza sobrenatural que encuentran en el camino.', '2005-09-13', 1622),
(1145, 'Fargo', 'Un vendedor ve cómo su mundo cambia por completo con la llegada de un misterioso y salvaje desconocido. Serie basada en la película del mismo título de los hermanos Coen, que sin embargo presenta personajes diferentes y se ambienta en 2006.', '2014-04-15', 60622),
(1146, 'The Boys', 'La serie tiene lugar en un mundo en el que los superhéroes representan el lado oscuro de la celebridad y la fama. Un grupo de vigilantes que se hacen llamar \"The Boys\" decide hacer todo lo posible por frenar a los superhéroes que están perjudicando a la sociedad, independientemente de los riesgos que ello conlleva.', '2019-07-25', 76479),
(1147, 'Westworld', 'Westworld está ambientada en un parque de atracciones futurista dirigido por el Doctor Robert Ford. Las instalaciones cuentan con androides cuya apariencia física es humana, y gracias a ellos los visitantes pueden introducirse en cualquier tipo de fantasía, por muy oscura que sea...', '2016-10-02', 63247),
(1148, 'Better Call Saul', 'Esta precuela de \"Breaking Bad\" nominada al Emmy narra la vida del picapleitos Jimmy McGill y su transformación en Saul Goodman, el abogado de moral laxa.', '2015-02-08', 60059),
(1149, 'The Umbrella Academy', 'Un grupo disuelto de superhéroes se reúne después de que su padre adoptivo, quien los entrenó para salvar el mundo, muere.', '2019-02-15', 75006),
(1150, 'Ataque a los Titanes', 'Tras un siglo de aparente paz, un titán colosal rompe las murallas que protegían a la humanidad, desatando una nueva masacre. Eren Jaeger y el Cuerpo de Exploradores lucharán para recuperar su mundo y enfrentar la amenaza titán.', '2013-04-07', 1429),
(1151, 'King Kong', 'La suerte de Ann Darrow cambia cuando conoce a Carl Denham, un empresario que lucha para abrirse camino en el mundo del espectáculo. A ellos se une Jack Driscoll, un autor de teatro neoyorquino. Los tres emprenden un viaje que los llevará hasta una remota isla, donde Denham tiene previsto dirigir una película. Allí descubren un ser increíble, un gorila gigante, King Kong, que habita en una frondosa selva, donde criaturas prehistóricas han vivido ocultas durante millones de años. Denham, con un apetito insaciable de grandeza, enseguida ve la fama que puede reportarle la captura del gorila y su exhibición en Nueva York.', '2005-12-12', 254),
(1152, 'El padrino', 'Don Vito Corleone, conocido dentro de los círculos del hampa como \'El Padrino\', es el patriarca de una de las cinco familias que ejercen el mando de la Cosa Nostra en Nueva York en los años cuarenta. Don Corleone tiene cuatro hijos: una chica, Connie, y tres varones; Sonny, Michael y Fredo. Cuando el Padrino reclina intervenir en el negocio de estupefacientes, empieza una cruenta lucha de violentos episodios entre las distintas familias del crimen organizado.', '1972-03-14', 238),
(1153, 'Jurassic Park (Parque Jurásico)', 'El multimillonario John Hammond tiene una idea para un espectacular parque temático: una isla retirada donde los visitantes puedan observar dinosaurios reales. Con la última tecnología en el desarrollo de ADN, los científicos pueden clonar braquiosaurios, triceratops, velociraptors y un tiranosaurio rex, utilizando para ello la sangre fosilizada en ámbar contenida en insectos que los mordieron hace millones de años. Los paleontólogos Alan Grant, Ellie Sattler y Ian Malcolm visitan el parque y quedan muy sorprendidos con los resultados obtenidos. Pero cuando un problemático empleado manipula el sofisticado sistema de seguridad los dinosaurios escapan, obligando a los visitantes a luchar por su supervivencia.', '1993-06-11', 329),
(1154, 'Avatar: El sentido del agua', 'Más de una década después de los acontecimientos de \'Avatar\', los Na\'vi Jake Sully, Neytiri y sus hijos viven en paz en los bosques de Pandora hasta que regresan los hombres del cielo. Entonces comienzan los problemas que persiguen sin descanso a la familia Sully, que decide hacer un gran sacrificio para mantener a su pueblo a salvo y seguir ellos con vida.', '2022-12-14', 76600),
(1155, 'Titanic', 'Durante las labores de recuperación de los restos del famoso Titanic, una anciana norteamericana se pone en contacto con la expedición para acudir a una plataforma flotante instalada en el Mar del Norte y asistir \'in situ\' a la recuperación de sus recuerdos. A través de su memoria reviviremos los acontecimientos que marcaron el siniestro más famoso del siglo XX: el hundimiento del trasatlántico más lujoso del mundo, la máquina más sofisticada de su tiempo, considerada «insumergible», que sucumbió a las heladas aguas del Atlántico en abril de 1912, llevándose consigo la vida de mil quinientas personas, más de la mitad del pasaje. En los recueros de la anciana hay cabida para algo más que la tragedia, la historia de amor que vivió con un joven pasajero de tercera clase, un pintor aficionado que había ganado su pasaje en una partida las cartas en una taberna de Southampton.', '1997-11-18', 597),
(1156, 'Titanic', 'Durante las labores de recuperación de los restos del famoso Titanic, una anciana norteamericana se pone en contacto con la expedición para acudir a una plataforma flotante instalada en el Mar del Norte y asistir \'in situ\' a la recuperación de sus recuerdos. A través de su memoria reviviremos los acontecimientos que marcaron el siniestro más famoso del siglo XX: el hundimiento del trasatlántico más lujoso del mundo, la máquina más sofisticada de su tiempo, considerada «insumergible», que sucumbió a las heladas aguas del Atlántico en abril de 1912, llevándose consigo la vida de mil quinientas personas, más de la mitad del pasaje. En los recueros de la anciana hay cabida para algo más que la tragedia, la historia de amor que vivió con un joven pasajero de tercera clase, un pintor aficionado que había ganado su pasaje en una partida las cartas en una taberna de Southampton.', '1997-11-18', 597),
(1157, 'La guerra de las galaxias', 'La princesa Leia, líder del movimiento rebelde que desea reinstaurar la República en la galaxia en los tiempos ominosos del Imperio, es capturada por las malévolas Fuerzas Imperiales, capitaneadas por el implacable Darth Vader, el sirviente más fiel del emperador. El intrépido Luke Skywalker, ayudado por Han Solo, capitán de la nave espacial \"El Halcón Milenario\", y los androides, R2D2 y C3PO, serán los encargados de luchar contra el enemigo y rescatar a la princesa para volver a instaurar la justicia en el seno de la Galaxia.', '1977-05-25', 11),
(1158, 'Harry Potter y la piedra filosofal', 'Harry Potter es un huérfano que vive con sus desagradables tíos, los Dursley, y su repelente primo Dudley. Se acerca su undécimo cumpleaños y tiene pocas esperanzas de recibir algún regalo, ya que nunca nadie se acuerda de él. Sin embargo, pocos días antes de su cumpleaños, una serie de misteriosas cartas dirigidas a él y escritas con una estridente tinta verde rompen la monotonía de su vida: Harry es un mago y sus padres también lo eran.', '2001-11-16', 671),
(1159, 'Origen', 'Dom Cobb es un ladrón hábil, el mejor de todos, especializado en el peligroso arte de extracción: el robo de secretos valiosos desde las profundidades del subconsciente durante el estado de sueño cuando la mente está más vulnerable. Esta habilidad excepcional de Cobb le ha hecho un jugador codiciado en el traicionero nuevo mundo de espionaje corporativo, pero al mismo tiempo, le ha convertido en un fugitivo internacional y ha tenido que sacrificar todo que le importaba. Ahora a Cobb se le ofrece una oportunidad para redimirse. Con un último trabajo podría recuperar su vida anterior, pero solamente si logra lo imposible.', '2010-07-15', 27205),
(1160, 'Los Vengadores', 'Cuando un enemigo inesperado surge como una gran amenaza para la seguridad mundial, Nick Fury, director de la Agencia SHIELD, decide reclutar a un equipo para salvar al mundo de un desastre casi seguro.', '2012-04-25', 24428);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movies`
--

INSERT INTO `movies` (`id`, `media_id`) VALUES
(7, 1151),
(8, 1152),
(9, 1153),
(10, 1154),
(11, 1155),
(12, 1156),
(13, 1157),
(14, 1158),
(15, 1159),
(16, 1160);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist_items`
--

CREATE TABLE `playlist_items` (
  `id` int(11) NOT NULL,
  `playlist_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seasons`
--

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `series_id` int(11) DEFAULT NULL,
  `media_id` int(11) NOT NULL,
  `season_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seasons`
--

INSERT INTO `seasons` (`id`, `series_id`, `media_id`, `season_number`) VALUES
(73, 29, 757, 0),
(74, 29, 760, 1),
(75, 29, 764, 2),
(76, 29, 767, 3),
(77, 30, 807, 0),
(78, 30, 809, 1),
(79, 30, 813, 2),
(80, 30, 827, 3),
(81, 30, 831, 4),
(82, 30, 852, 5),
(83, 30, 859, 6),
(84, 30, 879, 7),
(85, 30, 886, 8),
(86, 30, 894, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `series`
--

INSERT INTO `series` (`id`, `media_id`) VALUES
(29, 756),
(30, 806),
(31, 1133),
(32, 1134),
(33, 1135),
(34, 1136),
(35, 1137),
(36, 1138),
(37, 1139),
(38, 1140),
(39, 1141),
(40, 1142),
(41, 1143),
(42, 1144),
(43, 1145),
(44, 1146),
(45, 1147),
(46, 1148),
(47, 1149),
(48, 1150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(24, 'Lotfi', 'latifiyates@gmail.com', '$2y$10$9/RF7Kwgnc0BVPyn/jRuXOTYlW88IA.J0cYpYV0hp6Je..i8Ytccm', '2025-04-10 05:04:25'),
(27, 'latifi', 'latifi@gmail.com', '$2y$10$hvtS72R17Gsw5/BUWmWGieyEBVPH6OaG5vQwcZafJiPc9uIZxI8ai', '2025-04-20 02:06:47'),
(28, 'hola', 'hola@gmail.com', '$2y$10$p/pC3Au7DBySC48vWl2ZB.he43CdYMz2pEUWebVG6sEZl/u0Z4adG', '2025-04-21 02:46:20'),
(29, 'eliminame', 'eliminame@gmail.com', '$2y$10$3nzWvW5YsqC1rjgrRlMUCuTjnMq3BlwF9lPJnRIH89KBDp0tYzeG2', '2025-04-22 04:47:39'),
(30, 'testuser', 'holaa@gmail.com', '$2y$10$ghUxu0WDM.SOpz0/ZO6l5ucxRLQ2qlvGgwDYuC3iY5Tb2ytyxHzKO', '2025-05-12 05:25:29'),
(31, 'testuser', 'holaaa@gmail.com', '$2y$10$jrMI/xKHxi.Plq45DIgG2eOJEY7AebRF4vA8MS/NqL1QSdNmwRoje', '2025-05-12 05:25:55'),
(32, 'testuser', 'holaaaa@gmail.com', '$2y$10$AuHbMQ7Hr4pKgagZH4fu4OtdiXVLQ.6i1UppWN7Cqy/7bQ/woLoGW', '2025-05-12 05:27:16'),
(33, 'Hola', 'Holaaaaaaa@gmail.com', '$2y$10$qNHwoS9Ohp11pgLVbpETveQmY7av.jLbszLT153.NhRmK8OVNaenC', '2025-05-12 06:28:04'),
(34, 'Holaaaa', 'holaoaoa@gmail.com', '$2y$10$KIQND0sW7bO2Jrr6XKGcTOIfp.XJv8j6L.OK/2Ybq6.77JWGTGKtO', '2025-05-12 06:31:11'),
(35, 'Holaaaa', 'holaoaoaa@gmail.com', '$2y$10$J1VyeQOKKvYORAhNUM.d.uAniHfwiSfvBipUyIavrfqAjjLpUkNRy', '2025-05-12 06:32:15'),
(36, 'Holaaaa', 'holaoaoaaa@gmail.com', '$2y$10$hYKDNZLct/p6s7LMsbXMqOqRdltjdZuAGHH/ycLDOvS8RIk1FGOMu', '2025-05-12 06:32:44'),
(37, 'Holaaaa', 'holaoaoaaaa@gmail.com', '$2y$10$oY65UQXU.Ls89CFH8EdvpOMUEI.HNP3oZj9zK3FZRKVCfNFB02j36', '2025-05-12 06:33:17'),
(38, 'Holaaaa', 'holaoaoaaaaa@gmail.com', '$2y$10$C6MKG1CdUcGZbTgmlPxT/ejAZlUWcUAzJ5dFfiYreFbNy60AxSJr2', '2025-05-12 06:35:18'),
(39, 'Holaaaa', 'holaoaoaaaaaa@gmail.com', '$2y$10$AHNqrk1UL96j8OCM8ZTTVea6XoZzffllbmG1nXEbf.80F0qbt5klG', '2025-05-12 06:35:47'),
(40, 'adios', 'adios@gmail.com', '$2y$10$azPlgq3LV0ShFGi8HN02XO/s1o/7V/36RYiUQTCwZNeiW72CnLCQy', '2025-05-12 06:38:48'),
(41, 'testuser', 'pass@gmail.com', '$2y$10$eC01srBEivvKgUP6xM3s1eeEeuJrKwePLceXMnCKnVWTxtDRPy2mm', '2025-05-14 06:03:10'),
(42, 'Prueba', 'prueba@gmail.com', '$2y$10$p3CL7FBSC1o9hJ80BSl68ughBKkjxSS79Y0tiVmn8fCAPWdpw7cIK', '2025-05-17 06:46:44'),
(43, 'pass', 'passs@gmail.com', '$2y$10$.SaNtuoswSRFMl6g09AeTevnWDnRcUvd3oadyElNkQ0UfS4PAj3sq', '2025-05-17 18:09:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `idx_comments_user_id` (`user_id`);

--
-- Indices de la tabla `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `contributors`
--
ALTER TABLE `contributors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_creditos_media` (`mediaID`),
  ADD KEY `fk_creditos_contributor` (`ContributorID`);

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_id` (`media_id`),
  ADD KEY `idx_episodes_season_id` (`season_id`);

--
-- Indices de la tabla `generomedia`
--
ALTER TABLE `generomedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generomedia_ibfk_1` (`media`),
  ADD KEY `generomedia_ibfk_2` (`genero`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_genero` (`nombre_genero`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_id` (`media_id`);

--
-- Indices de la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `playlist_items`
--
ALTER TABLE `playlist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `idx_playlist_items_playlist_id` (`playlist_id`);

--
-- Indices de la tabla `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_id` (`media_id`),
  ADD KEY `idx_seasons_series_id` (`series_id`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_id` (`media_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contributors`
--
ALTER TABLE `contributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=997;

--
-- AUTO_INCREMENT de la tabla `generomedia`
--
ALTER TABLE `generomedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1161;

--
-- AUTO_INCREMENT de la tabla `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `playlist_items`
--
ALTER TABLE `playlist_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Filtros para la tabla `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `comment_replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `comment_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD CONSTRAINT `fk_creditos_contributor` FOREIGN KEY (`ContributorID`) REFERENCES `contributors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_creditos_media` FOREIGN KEY (`mediaID`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`),
  ADD CONSTRAINT `episodes_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `generomedia`
--
ALTER TABLE `generomedia`
  ADD CONSTRAINT `generomedia_ibfk_1` FOREIGN KEY (`media`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generomedia_ibfk_2` FOREIGN KEY (`genero`) REFERENCES `generos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seasons`
--
ALTER TABLE `seasons`
  ADD CONSTRAINT `seasons_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seasons_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`);

--
-- Filtros para la tabla `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

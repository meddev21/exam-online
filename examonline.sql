-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2017 at 11:57 م
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `etudiante`
--

CREATE TABLE `etudiante` (
  `idetd` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idniv` int(11) NOT NULL,
  `num_inscription` int(11) NOT NULL,
  `groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etudiante`
--

INSERT INTO `etudiante` (`idetd`, `iduser`, `idniv`, `num_inscription`, `groupe`) VALUES
(1, 3, 1, 39057112, 1),
(2, 4, 3, 123456789, 1),
(93, 159, 1, 784, 7),
(94, 160, 1, 754, 7),
(95, 161, 1, 7854, 7),
(96, 162, 1, 7549, 7),
(97, 163, 1, 759949, 7),
(98, 164, 1, 7032549, 7),
(99, 165, 1, 75102049, 7);

-- --------------------------------------------------------

--
-- Table structure for table `examen`
--

CREATE TABLE `examen` (
  `idexam` int(11) NOT NULL,
  `idprof` int(11) NOT NULL,
  `idmod` int(11) NOT NULL,
  `dur_exam` time NOT NULL,
  `temp_exam` time NOT NULL,
  `date_exam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examen`
--

INSERT INTO `examen` (`idexam`, `idprof`, `idmod`, `dur_exam`, `temp_exam`, `date_exam`) VALUES
(44, 2, 13, '02:00:00', '20:30:00', '2017-05-22'),
(47, 2, 13, '02:00:00', '13:59:00', '2017-05-16');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `idmod` int(11) NOT NULL,
  `idniv` int(11) NOT NULL,
  `nom_module` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coeff_modul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`idmod`, `idniv`, `nom_module`, `coeff_modul`) VALUES
(1, 1, 'تحليل1', 1),
(2, 1, 'جبر1', 1),
(3, 1, 'مدخل الى الخوارزميات', 1),
(4, 1, 'مصطلحات علمية', 1),
(5, 1, 'اعمال تطبيقية مكتبية', 1),
(6, 1, 'فيزياء1', 1),
(7, 1, 'تشفير', 1),
(8, 1, 'الاقتصاد', 1),
(9, 1, 'الكترونيك', 1),
(10, 1, 'إنجليزية1', 1),
(11, 1, 'تحليل2', 1),
(12, 1, 'جبر2', 1),
(13, 1, 'هندسة الحاسوب', 1),
(14, 1, 'تقنيات المعلومات و ا', 1),
(15, 1, 'الاحصاء', 1),
(16, 1, 'فيزياء2', 1),
(17, 1, 'مدخل للبرمجة الموجهة', 1),
(18, 1, 'البرمجة وتركيب المعطيات', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moduprof`
--

CREATE TABLE `moduprof` (
  `idprof` int(11) NOT NULL,
  `idmod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moduprof`
--

INSERT INTO `moduprof` (`idprof`, `idmod`) VALUES
(2, 7),
(2, 13),
(2, 3),
(2, 18),
(2, 9),
(3, 3),
(3, 1),
(32, 2);

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `idniv` int(11) NOT NULL,
  `nom_niveau` enum('L1','L2','L3','M1','M2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`idniv`, `nom_niveau`) VALUES
(1, 'L1'),
(2, 'L2'),
(3, 'L3'),
(4, 'M1'),
(5, 'M2');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `note` float NOT NULL,
  `idetd` int(11) NOT NULL,
  `idexam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`note`, `idetd`, `idexam`) VALUES
(0, 1, 44),
(0, 1, 47);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `idorders` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` enum('etudiant','professeur') NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `prenom` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `num_inscription_etd` varchar(20) DEFAULT NULL,
  `num_inscription_prof` varchar(20) DEFAULT NULL,
  `group_etd` int(11) DEFAULT NULL,
  `module-prof` varchar(200) DEFAULT NULL,
  `niveau_etd` enum('L1','L2','L3','M1','M2') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `professeur`
--

CREATE TABLE `professeur` (
  `idprof` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `num_inscription_prof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `professeur`
--

INSERT INTO `professeur` (`idprof`, `iduser`, `num_inscription_prof`) VALUES
(2, 5, 14788741),
(3, 2, 5456),
(32, 158, 456465456);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `idques` int(11) NOT NULL,
  `idexam` int(11) NOT NULL,
  `type_ques` enum('seule_choix','multi_choix','vrai_faux') NOT NULL,
  `text_ques` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `note_ques` float NOT NULL,
  `corpns` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `choix` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES
(42, 44, 'seule_choix', 'ماهي اكبر دولة افريقيا من ناحية المساحة  ', 10, 'الجزائر ', 'السودان,الجزائر ,المغرب,ليبيا,تونس'),
(43, 44, 'multi_choix', 'اختر الولايات التي تنتمي للجزائر ', 5, 'الوادي,سوق أهراس,باتنة', 'الوادي,صفاقص,سوق أهراس,طنجة,طرابلس,باتنة'),
(44, 44, 'seule_choix', 'كم تبلغ مساحة الجزائر ', 5, '2381741', '2381841,2381741,2371741,2381780'),
(45, 44, 'vrai_faux', 'هل قسنطينة ولاية ساحلية ؟', 5, 'خطا', 'صحيح,خطا'),
(46, 47, 'seule_choix', 'sdfsdsdfsdf', 5, 'zefsdf', 'zefsdf,sdfsdfsdfsdf'),
(47, 47, 'multi_choix', 'sdfsdfsfsdf', 7, 'sdfsdfsdfsdf', 'sdfsdfsdfsdf,sdfsdsdfsdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` enum('etudiant','professeur','administrator') NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `prenom` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`, `type`, `nom`, `prenom`) VALUES
(1, 'admin', 'admin', 'administrator', 'admin', 'admin'),
(2, 'khalaifa', 'khalaifa', 'professeur', 'aaa', 'ali'),
(3, 'moh', 'mohammed', 'etudiant', 'touati', 'mohmmed'),
(4, 'ali', 'ali', 'etudiant', 'djaber', 'ali'),
(5, 'abass', 'abass', 'professeur', 'abass', 'abass'),
(158, '654564', '654654654', 'professeur', 'sdfsdfsdf', 'sdfsdfsdf'),
(159, 'aaszeezsaaa', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(160, 'aassaazzzana', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(161, 'zzzana', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(162, 'aa', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(163, 'aera', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(164, 'atta', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt'),
(165, 'ayua', 'zzzzzz', 'etudiant', 'ererere', 'rtrtrtrt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etudiante`
--
ALTER TABLE `etudiante`
  ADD PRIMARY KEY (`idetd`),
  ADD UNIQUE KEY `num_inscription` (`num_inscription`),
  ADD KEY `etd_niv` (`idniv`),
  ADD KEY `etd_user` (`iduser`);

--
-- Indexes for table `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`idexam`),
  ADD KEY `exam_prof` (`idprof`),
  ADD KEY `exam_module` (`idmod`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`idmod`),
  ADD UNIQUE KEY `nom_module` (`nom_module`),
  ADD KEY `module_niv` (`idniv`);

--
-- Indexes for table `moduprof`
--
ALTER TABLE `moduprof`
  ADD KEY `pf_mdpf` (`idprof`),
  ADD KEY `md_mdpf` (`idmod`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`idniv`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD KEY `note_etd` (`idetd`),
  ADD KEY `note_exam` (`idexam`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idorders`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `num_inscription_prof` (`num_inscription_prof`),
  ADD UNIQUE KEY `num_inscription_etd` (`num_inscription_etd`);

--
-- Indexes for table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`idprof`),
  ADD UNIQUE KEY `num_inscription_prof` (`num_inscription_prof`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`idques`),
  ADD KEY `exam_quest` (`idexam`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etudiante`
--
ALTER TABLE `etudiante`
  MODIFY `idetd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `examen`
--
ALTER TABLE `examen`
  MODIFY `idexam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `idmod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `idniv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `idorders` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `idprof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `idques` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `etudiante`
--
ALTER TABLE `etudiante`
  ADD CONSTRAINT `etd_niv` FOREIGN KEY (`idniv`) REFERENCES `niveau` (`idniv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etd_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `exam_module` FOREIGN KEY (`idmod`) REFERENCES `module` (`idmod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_prof` FOREIGN KEY (`idprof`) REFERENCES `professeur` (`idprof`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_niv` FOREIGN KEY (`idniv`) REFERENCES `niveau` (`idniv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moduprof`
--
ALTER TABLE `moduprof`
  ADD CONSTRAINT `md_mdpf` FOREIGN KEY (`idmod`) REFERENCES `module` (`idmod`),
  ADD CONSTRAINT `pf_mdpf` FOREIGN KEY (`idprof`) REFERENCES `professeur` (`idprof`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_etd` FOREIGN KEY (`idetd`) REFERENCES `etudiante` (`idetd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_exam` FOREIGN KEY (`idexam`) REFERENCES `examen` (`idexam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `professeur_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `exam_quest` FOREIGN KEY (`idexam`) REFERENCES `examen` (`idexam`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

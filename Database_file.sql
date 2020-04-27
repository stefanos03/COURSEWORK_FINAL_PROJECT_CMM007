

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db1909248_research`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(9) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `title` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `location` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `country` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `aboutme` varchar(2000) NOT NULL,
  `role` varchar(20) NOT NULL,
  `activated` varchar(1) NOT NULL DEFAULT 'y',
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `title`, `lastname`, `firstname`, `location`, `email`, `address`, `country`, `photo`, `aboutme`, `role`, `activated`, `datecreated`) VALUES
(1, 'admin@mail.com', 'admin', '', 'Chatzilefthe', 'Stefan', 'Aberdeen', 'admin@mail.com', '', 'UK', '20200314_14_04_12492.jpg', '', 'admin', 'y', '2020-03-17 16:09:20'),
(68, 'teamleader@mail.com', 'leader', '', 'Kim Cruz', 'Luis', '', 'teamleader@gmail.com', 'Aberdeen', 'United Kingdom', '20200328_18_54_40432.jpg', '', 'teamleader', 'y', '2020-03-17 16:09:20'),
(69, 'student@mail.com', 'student', '', 'Chatzis', 'Elefteria', 'Glasgow', 'student@mail.com', '', '', '20190416_15_24_33915.jpg', '', '', 'y', '2020-03-17 16:09:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

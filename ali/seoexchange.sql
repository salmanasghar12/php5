-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2013 at 12:50 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `seoexchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `subcategory` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategory` (`subcategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `subcategory`) VALUES
(1, 'Computers', 1),
(2, 'Computers', 2),
(4, 'Art History & Humanities', 3),
(5, 'Art History & Humanities', 4),
(6, 'Entertainment', 5),
(7, 'Entertainment', 6),
(8, 'References & Guides', 7),
(9, 'References & Guides', 8),
(10, 'Blogs and Bloging', 9),
(11, 'Blogs and Bloging', 10),
(12, 'Health, Fitness and Medicine', 11),
(13, 'Health, Fitness and Medicine', 12),
(14, 'Science and Technology', 13),
(15, 'Science and Technology', 14),
(16, 'Business/Financial & Economy', 15),
(17, 'Business/Financial & Economy', 16),
(18, 'Home and Garden', 17),
(19, 'Home and Garden', 18),
(20, 'Shopping & Services', 19),
(21, 'Shopping & Services', 20),
(22, 'Internet and Web services', 21),
(23, 'Internet and Web services', 22),
(24, 'Travel & Luggage', 23),
(25, 'Travel & Luggage', 24),
(26, 'Education & Research', 25),
(27, 'Education & Research', 26),
(28, 'People, Society and Culture', 27),
(29, 'People, Society and Culture', 28),
(30, 'Web Directories', 29),
(31, 'Web Directories', 30),
(33, 'News', 38),
(34, 'Others', 39),
(35, 'TV Channels', 40),
(36, 'Social', 41),
(37, 'Computers', 42),
(38, 'Social', 43),
(39, 'TV Channels', 44),
(40, 'Computers', 45),
(41, 'Art History & Humanities', 46),
(42, 'Entertainment', 47),
(43, 'References & Guides', 48);

-- --------------------------------------------------------

--
-- Table structure for table `exchangedlinks`
--

CREATE TABLE IF NOT EXISTS `exchangedlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link1` int(11) DEFAULT NULL,
  `user1` int(11) DEFAULT NULL,
  `link2` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL,
  `isValid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `link1` (`link1`),
  KEY `user1` (`user1`),
  KEY `link2` (`link2`),
  KEY `user2` (`user2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `exchangedlinks`
--

INSERT INTO `exchangedlinks` (`id`, `link1`, `user1`, `link2`, `user2`, `isValid`) VALUES
(10, 4, NULL, 8, 11, 0),
(12, 9, 8, 8, NULL, 0),
(13, 2, 23, 16, 1, 1),
(23, 3, NULL, 16, 1, 0),
(24, 3, NULL, 16, 1, 0),
(25, 3, NULL, 16, 1, 0),
(26, 2, 23, NULL, NULL, 0),
(27, 21, 2, 22, 2, 1),
(28, 46, NULL, 2, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL,
  `category` int(11) NOT NULL,
  `subcatgory` int(11) NOT NULL,
  `discription` text NOT NULL,
  `keywords` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `isFeatured` tinyint(1) NOT NULL,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `subcatgory` (`subcatgory`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `link`, `category`, `subcatgory`, `discription`, `keywords`, `email`, `isFeatured`, `user`) VALUES
(2, 'Google.com', 'www.google.com', 1, 1, 'A Search Engine....kdlsfjklasdhf\nasdfasdjkfhkajsd\nasdfjkhasdjkhaksdjfkjasdhfkjas', 'Google Search google.com Search Engine', 'demo@localhost.com', 1, 23),
(3, 'Welcome to Facebook - Log In, ', 'www.facebook.com', 1, 1, 'Facebook is a social utility that connects people with friends and others who work, study and live around them. People use Facebook to keep up with friends, upload an unlimited number of photos, post links and videos, and learn more about the people they meet.', 'facebook fb.com m.facebook.com Social', 'demo@localhost.com', 1, NULL),
(4, 'W3Schools Online Web Tutorials', 'http://www.w3schools.com', 4, 6, 'HTML CSS JavaScript jQuery AJAX XML ASP.NET SQL Tutorials References Examples', 'HTML,CSS,DOM,JavaScript,jQuery,XML,AJAX,ASP.NET,W3C,tutorials,programming,learning,guide,primer,less', 'demo@localhost.com', 0, NULL),
(6, 'Nettuts+', 'http://net.tutsplus.com', 10, 12, 'Nettuts+ is a blog and community for Web Development tutorials. Learn php, JavaScript, WordPress, HTML5, CSS, Ruby and much more.', 'jquery,tutorials,tutorial,psd,html,php,css,how,to,web,development,xhtml,login,lightbox,shopping,cart', 'demo@localhost.com', 0, NULL),
(8, 'BuildMobile', 'http://buildmobile.com/', 12, 16, 'BuildMobile | Fresh thinking for mobile web development. Learn Android and iPhone development through tutorials. jQuery mobile, HTML5, Sencha and Phonegap are all featured.', 'BuildMobile » For Mobile Web Developers | iPhone and Android Development | Learn jQuery Mobile | Tutorials and moreBuildMobile', 'demo@localhost.com', 1, NULL),
(9, 'PHP Master', 'http://phpmaster.com/', 2, 12, 'PHP Master | Fresh thinking for PHP developers. Learn PHP and MySQL - Tutorials. Master PHP Script, Date, PHP Contact Form and Validation, SOAP and much more', 'PHP Master » For PHP Developers | PHP Tutorials | Learn PHP | PHP Script | Security | PHP Date and Forms', 'demo@localhost.com', 0, NULL),
(10, 'RubySource', 'http://www.rubysource.com/', 17, 16, 'RubySource | Fresh thinking for Ruby on Rails Development. Learn - Ruby Tutorials, Rails Migration, Ruby Gems, Test Driven Development - TDD and much more', 'For Ruby & Rails Developers | Ruby on Rails Tutorials | Learn Ruby | Gems | Strings and MoreRubySource', 'demo@localhost.com', 1, NULL),
(13, 'raza', 'http://www.hp.com', 1, 2, 'kadsfjlasjdfkajdsf', 'hp', 'demo@localhost.com', 0, NULL),
(14, 'Softpedia.com', 'http://www.softpedia.com', 1, 1, 'hello sheraaz', 'mr.47', 'demo@localhost.com', 1, NULL),
(15, 'kat.ph', 'http://kat.ph', 1, 2, 'kljf;aklsjdfaks', 'akldfj;ld', 'demo@localhost.com', 0, 23),
(16, 'Olx.Com.Pk', 'http://www.olx.com.pk', 20, 20, 'Yahan Sub Kuch Bikta hay....', 'computers, laptops, cellphones, used', 'demo@localhost.com', 0, 1),
(17, 'Tayyab', 'http://www.ben10.com', 16, 15, 'Qari Naat Khan Muhammad Tayyab Zaheer-ul-Salam Chisti Khokher', 'Tayyab', 'demo@localhost.com', 1, 23),
(18, 'wifi', 'http://www.wifi.com', 1, 2, 'lkkj;qewr', 'qerjqewrj', 'demo@localhost.com', 0, 23),
(19, 'bluetooth', 'http://www.bluetooth.com', 1, 1, 'af;ajsdf', 'adlfja;lf', 'demo@localhost.com', 1, NULL),
(21, 'Technology News - CNET News', 'http://news.cnet.com', 33, 38, 'CNET is the premier destination for tech product reviews, news, price comparisons, free software downloads, videos, and podcasts.', 'technology, computing, internet, news agency, reporting', 'demo@localhost.com', 1, 2),
(22, 'TechNewsWorld: All Tech - All ', 'http://www.technewsworld.com/', 33, 38, 'The most important technology news, developments and trends with insightful analysis and commentary. Coverage includes hardware, software, networking, wireless computing, personal technology, security and cutting-edge technology from the business world to the consumer world.', 'technology, news, wireless, databases, data storage, mobile, developer, open source, security, network, networking', 'demo@localhost.com', 1, 2),
(23, 'BBC News - Technology', 'http://www.bbc.com/news/technology/', 33, 38, 'Get the latest BBC Technology News: breaking news and analysis on computing, the web, blogs, games, gadgets, social media, broadband and more.', 'Explore the BBC, for latest news, sport and weather, TV & radio schedules and highlights, with nature, food, comedy, children''s programmes and much more', 'demo@localhost.com', 0, 2),
(24, 'The Verge', 'http://www.theverge.com/', 33, 38, 'The Verge was founded in 2011 in partnership with Vox Media, and covers the intersection of technology, science, art, and culture. Its mission is to offer in-depth reporting and long-form feature stories, breaking news coverage, product information, and community content in a unified and cohesive manner. The site is powered by Vox Media&#39;s Chorus platform, a modern media stack built for web-native news in the 21st century.    ', ' BlackBerry Juicers  Hacks / DIY  Linux / Open Source  posts Events posts Apple Android Microsoft Culture Gaming Web & Social Apps & Software Policy & Law Mobile', 'demo@localhost.com', 1, 2),
(25, 'TechCrunch', 'http://techcrunch.com/', 33, 38, 'TechCrunch is a leading technology media property, dedicated to obsessively profiling startups, reviewing new Internet products, and breaking tech news.', 'TechCrunch is a leading technology media property, dedicated to obsessively profiling startups, reviewing new Internet products, and breaking tech news.', 'demo@localhost.com', 1, 2),
(26, 'ZDNet | Technology News, Analy', 'http://www.zdnet.com/', 33, 38, 'ZDNet''s breaking news, analysis, and research keeps business technology professionals in touch with the latest IT trends, issues and events.', 'Technology News Analysis Comments Product Reviews IT Professionals', 'demo@localhost.com', 0, 2),
(27, '.: River Garden Gujrat:.', 'http://www.rivergarden.com', 18, 17, 'Heaven Developers have designed a fully affordable, strategically located, and futuristic re-sourced housing project for the masses.\r\n\r\nThe prime focus is on the provision of the top-of-the-line civic amenities, which makes living beautiful and luxurious experience.\r\n\r\nGuarded entrance gates and vigilant security patrols are there to provide peace of mind to all the property owners of River Garden. The visionary approach of Heaven Developers ensures a secure lifestyle in the society.\r\n\r\nPurified and treated water is life. To guarantee an un-interrupted supply of clean pure water to the residents, a water treatment plant is being installed at River Garden.', 'Heaven Developers have designed a fully affordable, strategically located, and futuristic re-sourced housing project for the masses.  The prime focus is on the provision of the top-of-the-line civic amenities, which makes living beautiful and luxurious experience.  Guarded entrance gates and vigilant security patrols are there to provide peace of mind to all the property owners of River Garden. The visionary approach of Heaven Developers ensures a secure lifestyle in the society.  Purified and treated water is life. To guarantee an un-interrupted supply of clean pure water to the residents, a water treatment plant is being installed at River Garden.', 'demo@localhost.com', 0, NULL),
(28, 'Art of Acting Studio | Los Ang', 'http://www.artofactingstudio.com/', 4, 3, 'Welcome to the Art of Acting Studio in LA', 'acting, school, studio, class, la, los angeles, california, acting class, acting classes, art of acting, acting studio, ron burrus, stella adler', 'demo@localhost.com', 1, 2),
(29, 'Open Culture - The Best Free C', 'http://www.openculture.com/', 4, 3, 'Discover thousands of free online courses, audio books, movies, textbooks, eBooks, language lessons, and more.', 'free audio books, free audiobooks, free education, free learning, free online courses, free courses, free lectures, education, knowledge, free movies online, free films online, free movies, free language lessons, free audiobook downloads, online university, elearning, knowledge, textbooks, free textbooks', 'demo@localhost.com', 0, 2),
(31, 'ABWAG to learn acting', 'http://www.abwag.com', 4, 3, 'abwag, act, acting, actor, tiny ron, don richardson, audience, camera, character, comedians, comedy, dialogue, directing, director, drama, dream, emotion, entertainer, humor, imagination, objective, principles, scene, scene analysis, sense memory, shakespeare, showmanship, staging, story, style, technique, author, ', 'Acting a Better Way with Actors Globally details for the purpose of acting the feel, think, do technique. ABWAG is an alternative to the Method.', 'demo@localhost.com', 0, 2),
(32, 'Powerpoint Templates, Powerpoi', 'http://www.animationfactory.com/en/', 4, 4, 'Animation Factory is your source for Powerpoint Templates, Powerpoint Backgrounds,  Animated Clip Art and Video Backgrounds for use in web, email, presentations and more', 'Powerpoint Templates, Powerpoint Backgrounds, Animated gifs, Animated Clip Art, Power Point Backgrounds, Video Backgrounds, Powerpoint Animation, PowerPoint Clipart', 'demo@localhost.com', 1, 2),
(33, 'Animation Library | Welcome', 'http://www.animationlibrary.com/', 4, 4, ', Over 14,000 Free Animations plus articles, reviews, tutorials, postcard, and everything else related to animated graphics.', 'animation, animated, animated gifs, free, gifs, , graphics, reviews, article, articles, software, freeware, help, tutorial, webmaster, webdesign, archive, collection, clipart, postcard, card, greeting card, icon, www, page dividers, hr, website, webtv, arrow, animal, help, website, flag, world, free, USA, Canada, line, computer, cat, horse, welcome, cool, dog, new, smiley, aviation, email, mailbox, bar, 89, 89a, christmas, xmas, new year, millenium', 'demo@localhost.com', 0, 2),
(34, 'Make a Video.  Amazing Animate', 'http://goanimate.com/', 4, 4, 'Make a video online for free with GoAnimate! Make videos for YouTube and Facebook, create business and educational videos, make animated e-cards and more!', 'Animation, eCard, flash free, web 2.0, cartoon, comics, create animations free, movie, film, video', 'demo@localhost.com', 0, 2),
(35, 'Professional Animination Desig', 'http://www.animfactory.com/', 4, 4, 'We are a leading animation studio producing world class animated web videos. You will enjoy wonderful works creating by our amazingly talented artists and animators at a competitive price in the global market.\r\n\r\nOur animation and post-production studio takes care of even the most complicated ideas.We accept everything including the smallest details and requirements of you and your clients.', 'We are a leading animation studio producing world class animated web videos. You will enjoy wonderful works creating by our amazingly talented artists and animators at a competitive price in the global market.  Our animation and post-production studio takes care of even the most complicated ideas.We accept everything including the smallest details and requirements of you and your clients.', 'demo@localhost.com', 1, 2),
(36, 'Autoblog - We Obsessively Cove', 'http://www.autoblog.com/', 10, 9, 'Get up-to-the-minute automotive news along with reviews, podcasts, high-quality photography and commentary about automobiles and the auto industry.', 'auto news, car news, automotive news', 'demo@localhost.com', 0, 2),
(37, 'Celebrity Cars Blog', 'http://www.celebritycarsblog.com/', 10, 9, 'Celebrity Cars Blog - Find out what your favorite celebrity drives at Celebrity Cars Blog | Celebrity Cars, Celebrity Rides, What Celebrities Drive', 'Celebrity Cars Blog - Find out what your favorite celebrity drives at Celebrity Cars Blog | Celebrity Cars, Celebrity Rides, What Celebrities Drive', 'demo@localhost.com', 0, 2),
(38, 'Carscoop', 'http://carscoop.blogspot.com/', 10, 9, 'An automotive webzine with daily updates on new and future vehicles, motor shows, the tuning industry, classic cars and more', 'cars, autos, automobiles, auto shows, concept cars, new cars, recalls, spy photos, news, gadgets, hybrids, electric vehicles, images, pictures, tuning, accidents, videos', 'demo@localhost.com', 1, 2),
(39, 'Web Hosting Blog at ASO | Host', 'http://blog.asmallorange.com/', 10, 10, 'Find out what''s hot at A Small Orange, get hosting tips for web developers, business owners and anyone who craves a fast secure Web site.', 'web hostingblog, webhosting blog, hostingblog', 'demo@localhost.com', 1, 2),
(40, 'HostGator Web Hosting Blog | G', 'http://blog.hostgator.com/', 10, 10, 'The official HostGator Company blog', 'Comedy,Office Art,Tips and Tricks,Web and Hosting Tips,Features,Random,Advertising,Gator Goodness,Office Shenanigans', 'demo@localhost.com', 0, 2),
(41, 'Avira Free Antivirus 2013 | Do', 'http://www.avira.com', 1, 2, 'Avira offers best free antivirus protection against dangerous viruses, worms, Trojans and spyware- Download Avira Free Antivirus 2013', 'free antivirus,free Avira,download free antivirus,download Avira free', 'demo@localhost.com', 1, 2),
(42, 'AVG Free | Antivirus | Free Vi', 'http://free.avg.com', 1, 2, 'Free antivirus and anti-spyware security software for Windows. Get free antivirus protection now!', 'Free antivirus and anti-spyware security software for Windows. Get free antivirus protection now!', 'demo@localhost.com', 1, 2),
(43, 'avast! Free Antivirus | Downlo', 'http://www.avast.com', 1, 2, 'avast! Free Antivirus is the best virus and spyware protection available. Download the world''s most popular antivirus software completely free.', 'avast! Free Antivirus is the best virus and spyware protection available. Download the world''s most popular antivirus software completely free.', 'demo@localhost.com', 1, 2),
(44, 'Gaana.com', 'http://www.gaana.com', 6, 39, 'Gaana.com', 'Radio', 'demo@localhost.com', 0, NULL),
(45, 'hello', 'http://www.hello.com', 6, 39, 'vsdfg', 'sfg', 'demo@localhost.com', 0, NULL),
(46, 'Skype', 'http://www.skype.com', 1, 42, 'content="Make internet calls for free with Skype. Sign up today and discover a whole new world of staying in touch."', 'content="Make internet calls for free with Skype. Sign up today and discover a whole new world of staying in touch."', 'aliraza3009@live.com', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `Name`) VALUES
(1, 'Algorithms & Calculations'),
(2, 'Antivirus'),
(3, 'Acting'),
(4, 'Animation'),
(5, 'Cartoons & Shows'),
(6, 'Books & Literature'),
(7, 'Acronyms & Abbreviations'),
(8, 'Almanacs'),
(9, 'Automobiles'),
(10, ' Blog web hosting'),
(11, 'Aging'),
(12, 'Addictions'),
(13, 'Academic/Educational Resources'),
(14, 'Aeronautics'),
(15, 'Accounting & Management'),
(16, 'Aerospace & Security'),
(17, 'Apartment Living'),
(18, 'Bath Rooms'),
(19, 'Antiques & Memorabilia'),
(20, 'Auctions'),
(21, 'Chats & Community Forums'),
(22, 'Databases'),
(23, 'Airways'),
(24, 'Business Travel'),
(25, 'Apprenticeships'),
(26, 'Art Classes'),
(27, 'Activism'),
(28, 'Advice & Tips'),
(29, 'Free Directories'),
(30, 'Paid Directories'),
(38, 'Tech News'),
(39, 'Others'),
(40, 'Music Channels'),
(41, 'Photo and Video Sharing'),
(42, 'Softwares'),
(43, 'Messaging'),
(44, 'Drama Channels'),
(45, 'Others'),
(46, 'Others'),
(47, 'Others'),
(48, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'ali', 'ali', 'demo@localhost.com'),
(2, 'admin', 'aliadmin', 'demo@localhost.com'),
(3, 'mjunaid', 'junaid', 'demo@localhost.com'),
(4, 'raza', 'raza', 'demo@localhost.com'),
(6, 'umar', 'umar', 'demo@localhost.com'),
(8, 'irfan', 'irfan', 'demo@localhost.com'),
(9, 'mamu', 'ali', 'demo@localhost.com'),
(10, 'blackberry', 'ali', 'demo@localhost.com'),
(11, 'free', 'free', 'demo@localhost.com'),
(13, 'me', 'ME', 'demo@localhost.com'),
(18, 'haroon', 'ali', 'demo@localhost.com'),
(20, 'link', 'ali', 'demo@localhost.com'),
(23, 'shazabhati47', 'shaza', 'demo@localhost.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`subcategory`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `exchangedlinks`
--
ALTER TABLE `exchangedlinks`
  ADD CONSTRAINT `exchangedlinks_ibfk_1` FOREIGN KEY (`link1`) REFERENCES `links` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `exchangedlinks_ibfk_2` FOREIGN KEY (`link2`) REFERENCES `links` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `exchangedlinks_ibfk_3` FOREIGN KEY (`user1`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `exchangedlinks_ibfk_4` FOREIGN KEY (`user2`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `links_ibfk_2` FOREIGN KEY (`subcatgory`) REFERENCES `category` (`subcategory`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

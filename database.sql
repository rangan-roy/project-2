-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 29, 2020 at 02:58 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id14929845_large22`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `title`, `description`) VALUES
(1, 'About the admin', 'Hi, I\'m Rangan Roy. Currently you are in my demo blog website. I have made this website using PHP (OOP), MySQL and Bootstrap. This website is not for business purpose, it is just for my resume. Thank you.');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(42) NOT NULL,
  `last_name` varchar(42) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `remember` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `image`, `remember`) VALUES
(1, 'Rangan', 'Roy', 'rangan.roy', 'ranganroy567@gmail.com', '$2y$15$xJCT2Pwzgz4IW9rbZ/Qg9.u1cc76k5300IhqGUlKQtKLGM/4q4xsu', '737112209202011263575365.jpg', '753434797229092020024137'),
(3, 'Asir', 'Sadique', 'asir22', 'asir@gmail.com', '$2y$15$oI5eSMnmLI6CR8BKxyg21eJNxFgNum2ysJzH.CNMQsrVeGYP6Zjyq', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(2, 'বাণিজ্য'),
(3, 'মতামত'),
(1, 'রাজনীতি');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `time` char(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `time`, `date`) VALUES
(18, 2, 1, 'This is a test comment.', '8:17:00am', '2020-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `elsewheres`
--

CREATE TABLE `elsewheres` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(42) NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elsewheres`
--

INSERT INTO `elsewheres` (`id`, `name`, `url`) VALUES
(1, 'Facebook', 'https://www.facebook.com/rangan.roy.351'),
(2, 'Twitter', 'https://twitter.com/rangan33'),
(3, 'GitHub', 'https://github.com/rangan-roy'),
(5, 'LinkedIn', 'https://www.linkedin.com'),
(6, 'Instagram', 'https://www.instagram.com');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`) VALUES
(7, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `is_jumbo` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `day` tinyint(4) NOT NULL,
  `month_year` char(7) NOT NULL,
  `image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `category_id`, `author_id`, `is_jumbo`, `description`, `day`, `month_year`, `image`) VALUES
(1, 'জনগণের অধিকার প্রতিষ্ঠায় নতুন পথ তৈরি করতে হবে: মান্না', 1, 1, 0, 'নাগরিক ঐক্যের আহ্বায়ক মাহমুদুর রহমান মান্না বলেছেন, বর্তমান সরকারের সঙ্গে কোনো আপস নেই। আপস করে গণতন্ত্র প্রতিষ্ঠা সম্ভব নয়। গণতান্ত্রিক অধিকার নেই বলেই দুর্নীতি আজ প্রাতিষ্ঠানিক রূপ পেয়েছে। জনগণের অধিকার প্রতিষ্ঠায় নতুন পথ তৈরির কথাও বলেন তিনি।\r\n \r\nরাজধানীর তোপখানায় বাংলাদেশ শিশুকল্যাণ মিলনায়তনে আজ মঙ্গলবার এক আলোচনা সভায় বক্তব্যে মান্না এসব কথা বলেন।\r\n \r\nরাজনৈতিক দল নিবন্ধনপদ্ধতি বাতিলের দাবি পরিষদ এই সভার আয়োজন করে। রাজনৈতিক দল নিবন্ধন আইন প্রসঙ্গে সভায় মান্না বলেন, এই আইন হচ্ছে সংবিধান ও গণতান্ত্রিক অধিকারের পরিপন্থী। জনগণের অধিকার প্রতিষ্ঠায় নতুন পথ তৈরি করতে হবে উল্লেখ করে তিনি বলেন, সাংবিধানিক ও গণতান্ত্রিক অধিকার আদায়ে লড়াইয়ের কোনো বিকল্প নেই। এই  সরকার জনগণের সব অধিকার হরণ করছে। বর্তমান সরকার থাকলে গণতান্ত্রিক অধিকার ফিরে পাওয়ার সম্ভাবনা নেই।\r\n\r\nঅনুষ্ঠানে গণসংহতি আন্দোলনের প্রধান সমন্বয়কারী জোনায়েদ সাকি বলেন, গণতান্ত্রিক অধিকার রক্ষার জন্য প্রয়োজন আন্দোলন। শাসক দলগুলো নিজেদের কর্তৃত্ব বজায় রেখে গণতান্ত্রিক অধিকারের কথা বলে। রাজনৈতিক মর্যাদা প্রতিষ্ঠায় নিবন্ধন আইন বাতিলের দাবিতে সোচ্চার হতে সবার প্রতি আহ্বান জানান তিনি।\r\n\r\nরাজনৈতিক দল নিবন্ধ আইনকে কালো আইন হিসেবে উল্লেখ করেন বিপ্লবী ওয়ার্কার্স পার্টির সাধারণ সম্পাদক সাইফুল হক। তিনি বলেন, অগণতান্ত্রিক এই আইনের মাধ্যমে শাসকগোষ্ঠী রাজনীতি নিয়ন্ত্রণের অপচেষ্টা করছে। সংবিধান প্রদত্ত অধিকার আইনের মাধ্যমে নিয়ন্ত্রণ করার এই চেষ্টা সমাজ ও রাষ্ট্রের জন্য কল্যাণ বয়ে আনতে পারে না।\r\nঅনুষ্ঠানে সভাপতিত্ব করেন রাজনৈতিক দল নিবন্ধনপদ্ধতি বাতিলের দাবি পরিষদের আহ্বায়ক ও সোনার বাংলা পার্টির সাধারণ সম্পাদক সৈয়দ হারুন-অর-রশিদ। অন্যদের মধ্যে বক্তব্য দেন জাসদের একাংশের সাধারণ সম্পাদক নাজমুল হক প্রধান, ন্যাপের মহাসচিব এম গোলাম মোস্তফা ভূঁইয়া, নাগরিক ঐক্যের সমন্বয়কারী শহীদুল্লাহ কায়সার প্রমুখ।', 22, '2020-09', '201892209202017071027825.jpg'),
(2, 'চালের দাম বেড়েছে ৩ দিনে', 2, 1, 1, 'পেঁয়াজের পর এবার চাল ও ভোজ্যতেল চাপে ফেলল সাধারণ মানুষকে। বাজারে সব ধরনের চালের দাম কেজিতে দুই থেকে চার টাকা বেড়েছে। আর খোলা ভোজ্যতেলের দাম বেড়েছে লিটারে পাঁচ টাকার মতো।\r\n\r\nভারত ১৪ সেপ্টেম্বর রপ্তানি বন্ধের পর দেশি পেঁয়াজের দাম প্রতি কেজি ৮০ থেকে ৯০ টাকা ও ভারতীয় পেঁয়াজ ৬০ থেকে ৭০ টাকায় স্থিতিশীল হয়েছে। সরকারি সংস্থা টিসিবির হিসাবে, এক মাস আগের তুলনায় এ দাম দ্বিগুণের বেশি।\r\n\r\nচালের বাজার আগেই চড়া ছিল। বাড়ছিল খোলা সয়াবিন ও পাম তেলের দামও। এখন আবার বাড়ল।\r\n\r\nচালের দাম বেড়েছে তিন দিনে। ঢাকার বাবুবাজার-বাদামতলীর আড়ত ও মোহাম্মদপুর কৃষি মার্কেটের পাইকারি দোকানে মোটা, মাঝারি ও মিনিকেট চালের দাম কেজিতে দুই থেকে চার টাকা বেড়েছে। অন্যদিকে কুষ্টিয়ার চালকলের মালিকেরাও সেখানে চালের দাম কেজিতে দুই থেকে তিন টাকা বাড়ানোর কথা জানান।\r\n\r\nকুষ্টিয়ায় মিল পর্যায়ে গতকাল মঙ্গলবার মোটা চাল ৪২ টাকা, বিআর-২৮ ও কাজললতা চাল ৪৮ এবং সরু মিনিকেট ৫২ টাকায় বিক্রি হয়। ঢাকায় আড়তে মাঝারি বিআর-২৮ চাল মানভেদে ৪৬ থেকে ৪৮ ও সরু মিনিকেট চাল ৫৪ টাকায় উঠেছে। দুই ক্ষেত্রে দাম বাড়তি দুই টাকা করে। বেশি বেড়েছে কাটারি পাইজাম নামের চালের দাম, কেজিপ্রতি ৪ টাকা। পাইকারিতে কাটারি পাইজামের দর ৪৮ টাকা।\r\n\r\nঢাকার খুচরা বাজারে বিআর-২৮ চাল মানভেদে প্রতি কেজি ৫০ থেকে ৫৪ টাকা। আর রশিদ, এরফান, বিশ্বাসসহ বিভিন্ন জনপ্রিয় ব্র্যান্ডের মিনিকেট চাল বস্তা কিনলে প্রতি কেজি ৫৭ টাকা ও কম কিনলে বাজারভেদে ৬০ থেকে ৬২ টাকা দাম পড়ে।\r\n\r\nদেশে ২০১৭ সালে হাওরে ধান নষ্ট হয়ে যাওয়ার পর চালের দাম অস্বাভাবিক বেড়ে গিয়েছিল। তখন মোটা চালের কেজি ৫০ টাকায় উঠেছিল। তারপর এ বছরই চালের দাম এতটা বেশি। এবার উঠেছে ৪৮ টাকা পর্যন্ত।\r\n\r\nদাম বাড়ল কেন, জানতে চাইলে কুষ্টিয়ার দাদা রাইস মিলের অংশীদার ও জেলা চালকল মালিক সমিতির সাধারণ সম্পাদক জয়নাল আবেদিন প্রধান প্রথম আলোকে বলেন, হাটে ধানের দাম প্রতি মণ ১ হাজার ১০০ থেকে ১ হাজার ২০০ টাকা। এ কারণে দাম না বাড়িয়ে উপায় নেই।\r\n\r\nভোজ্যতেলের দাম বাড়ার বিষয়ে পুরান ঢাকার মৌলভীবাজারের পাইকারি ব্যবসায়ী গোলাম মাওলা প্রথম আলোকে বলেন, আন্তর্জাতিক বাজারে ভোজ্যতেলের দাম অসম্ভব বেড়েছে।\r\n\r\nকারওয়ান বাজারে খোলা সয়াবিন তেলের প্রতি লিটারের দাম উঠেছে ৯০-৯২ টাকা। পাম তেল বিক্রি হয় ৮৫ টাকা লিটার। ট্রেডিং করপোরেশন অব বাংলাদেশের (টিসিবি) হিসাবে, এক মাসে সয়াবিন তেলের দাম লিটারে ৬ থেকে ৭ টাকা ও পাম তেলের দাম ৯ টাকা বেড়েছে। গত মাসে বোতলজাত সয়াবিন তেলের দাম লিটারপ্রতি ৪ টাকা বাড়িয়েছে কোম্পানিগুলো।\r\n\r\nবাজারে এখন চাল, তেল, পেঁয়াজ, রসুন, আদা, সবজি, আলু, ডিমসহ বিভিন্ন পণ্যের দাম চড়া। ভোক্তাদের কনজ্যুমারস অ্যাসোসিয়েশন অব বাংলাদেশের (ক্যাব) সভাপতি গোলাম রহমান বলেন, করোনাকালের আগে দেশে দরিদ্র মানুষ ছিল ২০ শতাংশের মতো। এখন সেটা ৩০ শতাংশে উন্নীত হয়েছে। অনেকে কাজ হারিয়েছেন। অনেকের আয় কমেছে। এ সময় পণ্যের মূল্যবৃদ্ধি মানুষকে চাপে ফেলছে।', 23, '2020-09', '791552309202005451983934.jpg'),
(3, 'দূর হোক পেনশনজীবীর দুর্ভোগ', 3, 1, 0, 'কয়েক বছর আগে পর্যন্ত শতভাগ পেনশন সমর্পণ করার সুযোগ ছিল। দেওয়া হতো প্রতি টাকার বিপরীতে এক শ টাকা। অবসরে গিয়েও সাংসারিক দায়দায়িত্ব শেষ হয় না অনেকের। কেউবা নিজের বা পরিবারের নিকটজনের অসুস্থতার জন্য খরচ করে ফেলেন মোটা অঙ্কের টাকা। তাই নগদ টাকাটার দিকেই ছিল ঝোঁক। আরও উল্লেখ্য, সে সময় পেনশন সঞ্চয়পত্রসহ বিভিন্ন সঞ্চয়পত্রে আকর্ষণীয় মুনাফা দেওয়া হতো। আয়কর কাটা হতো অতি সামান্য। তাই সংগতভাবে অনেকে ধারণা করেছিলেন, সঞ্চয়পত্রের মুনাফা দিয়েই প্রাপ্য পেনশন সমর্পণের ক্ষতিটা পুষিয়ে যাবে।\r\n\r\nকিন্তু সবকিছু হয়ে গেল গোলমেলে। কমল সঞ্চয়পত্রের মুনাফা। আবার তার ওপর চাপল উঁচু হারের আয়কর। অন্যদিকে ২০০৯ ও ২০১৫ সালের দুটো বেতন স্কেল আগের স্কেলগুলোর তুলনায় অনেক স্ফীত বেতন-ভাতার সুযোগ রাখে। এ বেতন বৃদ্ধিতে অবসর–সুবিধা আনন্দিত। বেতন কমিশনের সামনেও তাঁদের প্রতিনিধিরা চাকুরেদের বেতন আকর্ষণীয় হারে বৃদ্ধির সুপারিশ রেখেছিলেন। এসব বেতন বৃদ্ধি এবং বর্ধিত বেতনে যাঁরা অবসরে যাচ্ছেন, তাঁদের সঙ্গে আগের অবসরজীবীদের আয়ের পার্থক্য দাঁড়ায় বড় রকম। তদুপরি শতভাগ পেনশন যাঁরা সমর্পণ করেছিলেন, তাঁরা আর্থিকভাবে হয়ে পড়েন পর্যুদস্ত। উল্লেখ করা প্রাসঙ্গিক, সমর্পণ করে তাঁরা পেয়েছিলেন ৮ বছর ৪ মাসের পেনশন। তখনকার বিধি অনুসারে তাঁরা এ বাবদ কোনো সুবিধা পাওয়ার কথা না থাকলেও গোটা বিষয়টি নিয়ে অবসরজীবীদের পুনঃ পুনঃ আবেদন-নিবেদনে সরকার বিষয়টি গুরুত্বের সঙ্গে বিবেচনায় নেয়। সিদ্ধান্ত হয় পেনশন সমর্পণের ১৫ বছর পর আপনা থেকেই স্বয়ংক্রিয়ভাবে আবার পেনশন চালু হয়ে যাবে। সরকারের এ সিদ্ধান্ত অত্যন্ত সাহসী, সময়োচিত ও প্রশংসনীয়। এ সিদ্ধান্ত দরিদ্র শ্রেণির দিকে তলিয়ে যাওয়া কিছু লোকের সামাজিক নিরাপত্তার বলয়কে দৃঢ় করতে সহায়ক হয়েছে। যদিও তাঁরা পেনশন পাচ্ছেন অবসরকালীন বেতন স্কেলে।\r\n\r\nএকটি চমকপ্রদ বিষয় হচ্ছে এসব কল্যাণকর কাজে রাজনীতিবিদেরা সাধারণত তেমন বিঘ্ন সৃষ্টি করেন না। তবে দায়িত্ব নিয়ে নথি তৈরির কাজ যাঁদের হাতে, তাঁদের সবাইকে তেমন স্বতঃস্ফূর্ত দেখা যায় না। দুই বছর আগে এটা চালু করার সময়ে গেল গেল রব উঠেছিল। কিন্তু টাকার অঙ্কে বিষয়টিতে সরকারের সামর্থ্য ও চাকুরেদের জন্য বিভিন্ন ক্ষেত্রে প্রভূত ব্যয় বিবেচনায় সামান্য। জানা গেছে, বর্তমান অর্থবছরের প্রথম তিন মাসে এ খাতে ব্যয়ের পরিমাণ ৭০ কোটি টাকার কিছু ওপরে। অর্থাৎ বছরে ৩০০ কোটির মতো ব্যয় হবে।\r\n\r\nএ ক্ষেত্রে যদি ১৫ বছরের সময়সীমা শিথিল করে ১০ বছর করা হয়, তবে উপকারভোগীর সংখ্যা এবং ব্যয় কিছুটা বাড়বে। তবে খুব বড় কিছু হবে বলে মনে হয় না। ৫৭ বছরে অবসর নেওয়া ব্যক্তিরা ১৫ বছর পর ৭২ বছর বয়সী হবেন। সে পর্যন্ত কজনই বা বেঁচে থাকেন? তবে ২০১৫-এর বেতন স্কেল দেওয়ার সময় শতভাগ পেনশন সমর্পণ প্রথা বন্ধ করে দেওয়া হয়েছে। তাই একটি পর্যায়ের পর পেনশন পুনর্জীবন খাতে ব্যয় আর বাড়বে না। বরং উপকারভোগীদের মৃত্যুর সঙ্গে ক্রমান্বয়ে কমবে। এখানে উল্লেখ করতে হয়, অবসরের পর শারীরিক শক্তির পাশাপাশি প্রভাব–প্রতিপত্তিও হ্রাস পায়। সরকারি কর্মচারীদের একটি ক্ষুদ্র অংশের অনৈতিক ও গণবিরোধী আচরণের ফলে গোটা চাকরিজীবীদের সম্পর্কে একটি বৈরী মনোভাব সমাজে লক্ষণীয়। অথচ হাজার হাজার চাকুরে কোনো দিন দুর্নীতি করেননি এবং অনেকের সে সুযোগও ছিল না। অবসরের পর দ্রুতই ফুরিয়ে যায় সম্পদ। বৃহত্তর পরিবারে উপেক্ষিত হন তাঁরা। অথচ সে সময় তাঁদের চিকিৎসা ব্যয় বাড়তে থাকে। এর সবকিছুর বিহিত সরকার করতে পারবে না। তবে এ ক্ষুদ্র পরিমাণ পেনশনটুকু পুনর্বহাল হলে অনেকের চোখেই আনন্দাশ্রু আসবে।\r\n\r\nএখানে উল্লেখ করতে হয়, ২০১৫ সালে বেতন কমিশন রিপোর্ট পর্যালোচনার জন্য গঠিত সচিব কমিটি আগে অবসরে যাওয়া চাকুরেদের সমস্যাটি তেমন একটা আমলে নেয়নি। তখন যাঁরা কর্মরত বা অবসরে যাচ্ছেন, মূলত তাঁরাই সে কমিটির রিপোর্টে সুফলভোগী। সে সময়েই অবসরে যাওয়াকালীন ছুটির বেতন এক বছরের পরিবর্তে দুই বছর করা হয়। পেনশন মূল বেতনের ৮০ থেকে ৯০-এ হয় উন্নীত। আবার বাধ্যকরী সমর্পণযোগ্য অর্ধেক পেনশনের প্রতি টাকার বিপরীতে ২০০ টাকার স্থলে ২২০ টাকা করে দেওয়া হয়। সবই ভালো উদ্যোগ। তবে এর আগে অবসরে যাওয়া চাকুরেরা পেলেন না কিছুই। বলা হয় বিধিতে নেই। বিধিতে ওপরের সুবিধাদিও ছিল না। সংশোধন করেই অন্তর্ভুক্ত করা হয়েছে। তেমন কিছু করার সুযোগ তাঁরা কাজে লাগাননি। যা-ই হোক অবসরজীবীদের সুবিধাদির জন্য চাকুরেদের দুয়ারেই যেতে হবে। আমরা আশা করব পূর্ণ সমর্পিত পেনশন ১০ বছর অবসরভোগের পর স্বয়ংক্রিয় পুনর্বহালের জন্য একটি উদ্যোগ তাঁরা দ্রুত নেবেন।\r\n\r\nএরপর আলোচনায় আসে যাঁরা পেনশন পাচ্ছেন, তাঁরা কত পান। অবসর নেওয়ার সময়ে যে স্কেলে তিনি কর্মরত ছিলেন, তাকে ভিত্তি ধরে পেনশন নির্ধারণই বরাবরের নিয়ম। এখনো ব্যত্যয় হচ্ছে না। ধার্যকৃত পেনশন প্রতিবছর অনুল্লেখযোগ্য হারে কিছুটা বাড়ে। নতুন বেতন স্কেল দেওয়া হলে পেনশনধারীদের জন্য সে স্কেলের সুবিধাদির কোনো ধার না ধরেই থোকে কিছু টাকা বাড়িয়ে দেওয়া হয়। ফলে ২০০৯ সালের বেতন স্কেল দেওয়ার আগে যাঁরা অবসরে গেছেন, তাঁদের পেনশনের সঙ্গে হালে একই পদ থেকে অবসরপ্রাপ্তদের বৈষম্য হয়ে গেছে বড় রকম। ২৫ বছর আগে অবসরে যাওয়া একজন সরকারি কলেজশিক্ষকের পেনশন হালে প্রাথমিক বিদ্যালয়ের শিক্ষক হিসেবে যাঁরা অবসরে যাচ্ছেন, তাঁদের চেয়ে ক্ষেত্রবিশেষে কম। এ ধরনের বৈষম্য দীর্ঘকালই বিরাজ করছে। কিন্তু বড় ধরনের বেতন বৃদ্ধির ফলে বৈষম্যটা ধারণ করেছে প্রকট আকার।\r\n\r\nএ ধরনের এক নিবন্ধে আমি দেখিয়েছিলাম ৩০ বছর আগে অবসর নেওয়া অষ্টম গ্রেডের একজন কর্মকর্তার পেনশন একই গ্রেড থেকে হালে অবসর নেওয়া তাঁর পুত্রের পেনশনের চেয়ে শোচনীয় হারে কম। এখন যাঁরা চাকরিতে আছেন, তাঁরা চাকরির বেতন ও সুবিধাদি ভোগ করবেন, এটাই স্বাভাবিক। তবে যখন অবসরে যাবেন, এ পদ থেকে তা ১৫-২০ বছর বা তারও আগে যাঁরা অবসরে গেছেন, সবাই তো একই কাতারে পেনশন পাওয়ার দাবি রাখেন। এ নিয়ে ভারতে অবসরপ্রাপ্ত মেজর জেনারেলদের একটি মামলার বিষয়ে আমি আগের নিবন্ধে উল্লেখ করেছি। ভারত সরকার পূর্ণাঙ্গ বাস্তবায়ন না করলেও নীতিগতভাবে বিষয়টি মেনে নিয়েছে। পাশাপাশি বেসামরিক চাকুরেদের জন্যও ক্রমান্বয়ে ‘ওয়ান ব্যাংক ওয়ান পেনশন’ নীতিটি কার্যকরের প্রচেষ্টা চলছে। এ বিষয়ে ২০১৫ সালে সপ্তম বেতন কমিশন সুস্পষ্ট সুপারিশ করেছে। জানা যায়, কেন্দ্রীয় ও সর্বভারতীয় বেশ কিছু চাকুরের মধ্যে নিয়মটি কিছু ক্ষেত্রে চালু হয়েছে। এটা সত্য, বাংলাদেশ এ দাবি মেনে নিলে পেনশন খাতে সরকারের ব্যয় বেড়ে যাবে। তাই রাতারাতি এটা বাস্তবায়ন সম্ভব বা সমীচীন না-ও হতে পারে। এর আর্থিক সংশ্লেষ হিসাব-নিকাশ করে দেখতে হবে। নীতিগত দিক মেনে নিয়ে বাস্তবায়নও ধীরে ধীরে করা যায়। এ লক্ষ্য সামনে রেখে বাস্তবায়ন–প্রক্রিয়া, সরকারের সামর্থ্য ইত্যাদি বিবেচনায় নিতে একটি কমিশন বা কমিটিও গঠন করা যায়।\r\n\r\nআজ দেশের সমৃদ্ধির যে সুফল হালের চাকুরে ও সদ্য অবসরজীবীরা ভোগ করছেন, এর ভিত তিলে তিলে গড়তে অবদান রেখেছেন তাঁদের পূর্বসূরিরা। তাঁদের অনেকেই হতদরিদ্র অবস্থায় আছেন। সবাই বড় চাকরি করতেন না। পিয়ন, করণিক ইত্যাদি নিম্ন বেতনভোগীরাও পেনশন পান। সেটা কত কম একটু ভেবে দেখা দরকার। সামাজিক নিরাপত্তাবলয়কে জোরদারের প্রয়াসে প্রস্তাবিত ব্যবস্থা সময়োচিত। বর্তমান অবস্থার ন্যায়ভিত্তিক অবসানের জন্য কর্মরত চাকুরেরা তৎপর হলে সরকারের নীতিনির্ধারকেরা বড় বাধা হয়ে কখনো দাঁড়ান না।', 28, '2020-09', '255452809202004425970236.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reply` text COLLATE utf8_unicode_ci NOT NULL,
  `time` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `user_id`, `reply`, `time`, `date`) VALUES
(17, 18, 1, 'This is a test reply.', '8:22:20am', '2020-09-29'),
(18, 18, 2, 'Another test reply.', '8:35:16am', '2020-09-29'),
(19, 18, 2, 'Yet another reply.', '8:39:25am', '2020-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(42) NOT NULL,
  `last_name` varchar(42) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `remember` char(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `image`, `remember`) VALUES
(1, 'Salim', 'Reza', 'salim88', 'salim88@yahoo.com', '$2y$15$iIzcuazIAxS6KY1rNBJyYerGca8aVU/RPkgYw9JZwAOVOqpsvV0HK', '148662909202002284531702.jpg', NULL),
(2, 'Mitu', 'Roy', 'mitu99', 'mitu.roy@gmail.com', '$2y$15$wSwUrkv416hH7jatH1IDb.zqyftOppOroGXW/xlx05c3zrX3Evu2K', '369072909202002341422201.jpg', '290920200233547426467445');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD UNIQUE KEY `remember` (`remember`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`,`image`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elsewheres`
--
ALTER TABLE `elsewheres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD UNIQUE KEY `remember` (`remember`),
  ADD UNIQUE KEY `image` (`image`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `elsewheres`
--
ALTER TABLE `elsewheres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2020 at 09:19 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `fmarket`;
USE `fmarket`;

--
-- Database: `fmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE IF NOT EXISTS `apply` (
  `f_username` varchar(200) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `bid` int(11) NOT NULL,
  `cover_letter` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`f_username`, `job_id`, `bid`, `cover_letter`) VALUES
('raj_singh', '1', 245000, 'Dear HealthTech Innovations Team,

I am writing to express my strong interest in the Hospital Management System project. With my experience in building secure, scalable healthcare applications and expertise in HIPAA compliance, I am confident in delivering a robust solution.

Recent Healthcare Projects:
- Built telemedicine platform serving 50+ hospitals
- Implemented HL7 integration for major hospital chain
- Developed pharmacy management system with real-time inventory

Technical Expertise:
- Microservices architecture using Spring Boot
- React for responsive frontend
- HIPAA compliant cloud deployment on AWS
- HL7 integration and healthcare APIs
- Mobile app development with React Native

I can start immediately and have a team ready for this project.

Best regards,
Raj Singh'),
('neha_sharma', '3', 290000, 'Dear TechMinds Solutions,

I am excited to apply for the AI-Powered Supply Chain Management project. My background in machine learning and experience with predictive analytics makes me an ideal candidate.

Relevant Experience:
- Developed ML models for inventory optimization at Amazon
- Created demand forecasting system with 92% accuracy
- Implemented real-time analytics dashboards

Technical Skills:
- Advanced ML/AI using TensorFlow and PyTorch
- Time series analysis and forecasting
- Large-scale data processing
- Full-stack development with Python/Django

I am available to start within two weeks.

Best regards,
Neha Sharma'),
('vikram_joshi', '5', 195000, 'Dear RetailTech Solutions,

I am writing regarding the Smart Retail POS System project. My experience in developing mobile applications with offline capabilities and complex state management makes me well-suited for this role.

Key Projects:
- Developed offline-first POS system for 200+ retail stores
- Created inventory management app with real-time sync
- Implemented multi-store management system

Technical Background:
- Expert in React Native and offline storage
- Experience with retail payment integrations
- Strong background in state management
- Cloud synchronization expertise

Available to start immediately.

Best regards,
Vikram Joshi'),
('anjali_desai', '4', 275000, 'Dear EdTech Pioneers,

I am interested in the Adaptive Learning Platform project. My expertise in scalable backend architecture and experience with educational platforms aligns perfectly with your requirements.

Recent Achievements:
- Built microservices architecture handling 100K concurrent users
- Implemented real-time video streaming platform
- Developed AI-based content recommendation system

Technical Expertise:
- Microservices with Spring Boot
- Real-time data processing
- Scalable cloud architecture
- Educational technology integration

Ready to start in two weeks.

Best regards,
Anjali Desai');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE IF NOT EXISTS `employer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `birthdate` date NOT NULL,
  `company` varchar(200) NOT NULL,
  `profile_sum` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`username`, `password`, `Name`, `email`, `contact_no`, `address`, `gender`, `birthdate`, `company`, `profile_sum`) VALUES
('techminds_india', 'tech@2024', 'TechMinds Solutions', 'hr@techminds.in', '+91 9898989898', 'Whitefield, Bangalore', 'other', '1990-01-01', 'TechMinds Solutions Pvt Ltd', 'Leading software development company specializing in enterprise solutions and digital transformation. ISO 27001 certified.'),
('healthtech_innovations', 'health@2024', 'HealthTech Innovations', 'careers@healthtech.in', '+91 9797979797', 'Cyber City, Gurgaon', 'other', '1992-01-01', 'HealthTech Innovations Pvt Ltd', 'Healthcare technology company building innovative solutions for hospitals and clinics across India. NABH accredited.'),
('fintech_solutions', 'fintech@2024', 'FinTech Solutions', 'hr@fintechsolutions.co.in', '+91 9696969696', 'Lower Parel, Mumbai', 'other', '1995-01-01', 'FinTech Solutions India Ltd', 'Leading fintech company providing payment solutions and financial software. RBI certified payment aggregator.'),
('edtech_pioneers', 'edtech@2024', 'EdTech Pioneers', 'careers@edtechpioneers.in', '+91 9789789789', 'Koramangala, Bangalore', 'other', '1993-01-01', 'EdTech Pioneers India Pvt Ltd', 'Leading educational technology company providing AI-powered learning solutions. NASSCOM awarded for innovation.'),
('retail_tech_solutions', 'retail@2024', 'RetailTech Solutions', 'hr@retailtech.co.in', '+91 9678967896', 'Salt Lake, Kolkata', 'other', '1994-01-01', 'RetailTech Solutions India Pvt Ltd', 'Retail technology company specializing in inventory management and POS solutions. ISO 9001 certified.'),
('agritech_innovators', 'agri@2024', 'AgriTech Innovators', 'info@agritech.co.in', '+91 9567856785', 'Magarpatta, Pune', 'other', '1991-01-01', 'AgriTech Innovators Pvt Ltd', 'Agricultural technology company developing smart farming solutions. Supported by Govt of India SMART initiative.');

-- --------------------------------------------------------

--
-- Table structure for table `e_social`
--

CREATE TABLE IF NOT EXISTS `e_social` (
  `e_username` varchar(200) NOT NULL,
  `social_prof` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `freelancer`
--

CREATE TABLE IF NOT EXISTS `freelancer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `birthdate` date NOT NULL,
  `prof_title` varchar(200) NOT NULL,
  `profile_sum` varchar(1000) NOT NULL,
  `education` varchar(200) NOT NULL,
  `experience` varchar(200) NOT NULL,
  `skills` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`username`, `password`, `Name`, `email`, `contact_no`, `address`, `gender`, `birthdate`, `prof_title`, `profile_sum`, `education`, `experience`, `skills`) VALUES
('aditya_kumar', 'secure@123', 'Aditya Kumar', 'aditya.kumar@gmail.com', '+91 9845672310', 'Indiranagar, Bangalore', 'male', '1994-03-15', 'Senior Full Stack Developer', 'Full stack developer with 6+ years experience in MERN stack and cloud technologies. Led development of multiple successful SaaS products.', 'B.Tech Computer Science, BITS Pilani', 'Senior Developer at Flipkart, Tech Lead at Razorpay', 'React, Node.js, MongoDB, AWS, TypeScript, Redis'),
('priya_mehta', 'priya@2024', 'Priya Mehta', 'priya.mehta@outlook.com', '+91 9876543211', 'Andheri West, Mumbai', 'female', '1995-08-22', 'UX/UI Design Lead', 'Award-winning UX/UI designer with expertise in mobile-first design. Created interfaces for apps with 1M+ users.', 'M.Des., NID Ahmedabad', 'Design Lead at Swiggy, Senior Designer at PhonePe', 'Figma, Adobe XD, Sketch, Prototyping, User Research'),
('raj_singh', 'rajsingh@2024', 'Raj Singh', 'raj.singh@gmail.com', '+91 9934567890', 'Sector 62, Noida', 'male', '1993-11-25', 'DevOps Engineer', 'DevOps engineer specializing in cloud infrastructure and automation. Certified AWS Solutions Architect.', 'B.Tech IT, DTU Delhi', 'DevOps Lead at PayTM, Cloud Architect at Ola', 'AWS, Docker, Kubernetes, Jenkins, Terraform, Python'),
('neha_sharma', 'neha@secure24', 'Neha Sharma', 'neha.sharma@gmail.com', '+91 8876543212', 'HSR Layout, Bangalore', 'female', '1996-07-18', 'Data Scientist', 'Data scientist with focus on ML and AI. Published research on predictive analytics in e-commerce.', 'M.Tech AI, IIT Madras', 'Senior Data Scientist at Amazon, ML Engineer at Myntra', 'Python, TensorFlow, PyTorch, SQL, R, Power BI'),
('vikram_joshi', 'vikram@2024', 'Vikram Joshi', 'vikram.joshi@gmail.com', '+91 9856234170', 'Baner, Pune', 'male', '1992-09-30', 'Mobile App Architect', 'Mobile app architect with expertise in native and cross-platform development. Published multiple apps with 500K+ downloads.', 'B.Tech Computer Science, VIT Vellore', 'Tech Lead at Uber, Senior Developer at Ola', 'React Native, Flutter, iOS, Android, Firebase'),
('anjali_desai', 'anjali@2024', 'Anjali Desai', 'anjali.desai@outlook.com', '+91 9967845321', 'Vastrapur, Ahmedabad', 'female', '1994-12-05', 'Backend Architect', 'Backend specialist with focus on scalable microservices and cloud architecture. Expert in high-performance systems.', 'M.Tech Computer Science, IIT Bombay', 'Senior Backend Engineer at Zomato, System Architect at BigBasket', 'Java, Spring Boot, Microservices, AWS, Kafka');

-- --------------------------------------------------------

--
-- Table structure for table `f_skill`
--

CREATE TABLE IF NOT EXISTS `f_skill` (
  `f_username` varchar(200) NOT NULL,
  `skill` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_social`
--

CREATE TABLE IF NOT EXISTS `f_social` (
  `f_username` varchar(200) NOT NULL,
  `social_prof` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_offer`
--

CREATE TABLE IF NOT EXISTS `job_offer` (
`job_id` bigint(20) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `budget` int(11) NOT NULL,
  `skills` varchar(200) NOT NULL,
  `special_skill` varchar(200) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_offer`
--

INSERT INTO `job_offer` (`job_id`, `title`, `type`, `description`, `budget`, `skills`, `special_skill`, `e_username`, `valid`, `timestamp`) VALUES
(1, 'Enterprise Healthcare Platform', 'Full-time Remote', 'Building a comprehensive healthcare management system with electronic records and telemedicine features.', 250000, 'Java Spring Boot, React, PostgreSQL', 'Healthcare domain expertise', 'healthtech_innovations', 1, '2024-01-25 10:30:00'),
(2, 'Mobile Commerce App', 'Contract', 'Developing a feature-rich mobile shopping app with AR product visualization.', 180000, 'React Native, Node.js, MongoDB', 'AR/VR development', 'retail_solutions', 1, '2024-01-24 11:45:00'),
(3, 'Business Intelligence Dashboard', 'Full-time', 'Creating an advanced analytics platform with predictive modeling capabilities.', 200000, 'Python, D3.js, TensorFlow', 'Data science expertise', 'data_insights', 1, '2024-01-23 09:15:00'),
(4, 'DevOps Automation Project', 'Full-time Remote', 'Implementing CI/CD pipelines and infrastructure automation.', 280000, 'AWS, Docker, Kubernetes', 'DevOps experience', 'tech_cloud', 1, '2024-01-26 11:30:00'),
(5, 'Natural Language Bot', 'Contract', 'Building an AI-powered customer service chatbot with multilingual support.', 150000, 'Python, TensorFlow, NLP', 'NLP expertise', 'ai_solutions', 1, '2024-01-26 14:45:00'),
(6, 'DeFi Trading Platform', 'Full-time', 'Developing a decentralized cryptocurrency trading platform.', 300000, 'Solidity, Web3.js, React', 'Blockchain development', 'fintech_block', 1, '2024-01-27 10:15:00'),
(7, 'Digital Marketing Suite', 'Part-time', 'Building an integrated marketing analytics and automation platform.', 120000, 'Python, React, Google Analytics', 'Marketing automation', 'social_analytics', 1, '2024-01-28 09:00:00'),
(8, 'Smart Home Automation', 'Contract', 'Creating an IoT platform for home device management and energy optimization.', 200000, 'Node.js, MQTT, React Native', 'IoT development', 'smart_home_tech', 1, '2024-01-28 13:20:00'),
(9, 'Media Streaming Service', 'Full-time', 'Developing a high-performance video streaming platform with AI content recommendations.', 250000, 'Node.js, FFmpeg, Redis', 'Video streaming', 'stream_tech', 1, '2024-01-29 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `job_skill`
--

CREATE TABLE IF NOT EXISTS `job_skill` (
  `job_id` varchar(30) NOT NULL,
  `skill` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `sender` varchar(200) NOT NULL,
  `receiver` varchar(200) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`sender`, `receiver`, `msg`, `timestamp`) VALUES
('raj_singh', 'healthtech_innovations', 'I have reviewed your HMS project requirements in detail. I have experience with similar HIPAA-compliant systems and HL7 integration. Would you be available for a technical discussion?', '2024-01-25 14:30:00'),
('healthtech_innovations', 'raj_singh', 'Thanks for your interest. We would like to discuss the HL7 integration approach and your experience with telemedicine features. Are you available tomorrow at 2 PM IST for a technical round?', '2024-01-25 15:00:00'),
('raj_singh', 'healthtech_innovations', 'Yes, 2 PM works perfectly. I will prepare a brief technical presentation about the proposed architecture and integration approach. Looking forward to the discussion.', '2024-01-25 15:15:00'),
('neha_sharma', 'techminds_india', 'Regarding the SCM project, I have experience with similar ML-based demand forecasting systems. I would like to discuss the specific requirements and data sources available.', '2024-01-24 11:30:00'),
('techminds_india', 'neha_sharma', 'We have historical data for the past 3 years and real-time inventory data from multiple warehouses. Can you share your approach to handling seasonal variations in demand prediction?', '2024-01-24 11:45:00'),
('neha_sharma', 'techminds_india', 'I would use a combination of LSTM networks and XGBoost for handling seasonal patterns. I can demonstrate a proof of concept using sample data. Would you like to schedule a detailed technical discussion?', '2024-01-24 12:00:00'),
('vikram_joshi', 'retail_tech_solutions', 'Hello, I have extensive experience in developing offline-first POS systems. Would love to discuss your requirements for the Smart Retail POS project.', '2024-01-26 10:30:00'),
('retail_tech_solutions', 'vikram_joshi', 'Hi Vikram, your experience looks relevant. Can you share more details about your previous POS implementation, particularly regarding offline sync and multi-store management?', '2024-01-26 11:00:00'),
('vikram_joshi', 'retail_tech_solutions', 'Sure! In my previous project, I implemented a robust offline sync mechanism using SQLite and Redux, handling up to 50K SKUs offline. Would you like to schedule a detailed technical discussion?', '2024-01-26 11:30:00'),
('anjali_desai', 'edtech_pioneers', 'Hi, I am interested in your Adaptive Learning Platform project. I have experience building scalable educational platforms with video streaming capabilities.', '2024-01-26 14:00:00'),
('edtech_pioneers', 'anjali_desai', 'Thanks for reaching out. We are particularly interested in your experience with microservices and real-time analytics. Are you available for a technical discussion tomorrow?', '2024-01-26 14:30:00'),
('anjali_desai', 'edtech_pioneers', 'Yes, I am available tomorrow. I can share our approach to handling real-time analytics for 100K+ concurrent users in my previous edtech project.', '2024-01-26 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `selected`
--

CREATE TABLE IF NOT EXISTS `selected` (
  `f_username` varchar(200) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected`
--

INSERT INTO `selected` (`f_username`, `job_id`, `e_username`, `price`, `valid`) VALUES
('raj_singh', '1', 'healthtech_innovations', 245000, 1),
('neha_sharma', '3', 'techminds_india', 290000, 1),
('vikram_joshi', '5', 'retail_tech_solutions', 195000, 1),
('anjali_desai', '4', 'edtech_pioneers', 275000, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employer`
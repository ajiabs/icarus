-- MySQL dump 10.13  Distrib 5.6.36, for Linux (x86_64)
--
-- Host: localhost    Database: icarus
-- ------------------------------------------------------
-- Server version	5.6.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cms_category`
--

DROP TABLE IF EXISTS `cms_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `category_parent_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_alias` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `icon` varchar(255) NOT NULL,
  `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
  `show_homepage` int(1) NOT NULL,
  `homepage_order` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_category`
--

LOCK TABLES `cms_category` WRITE;
/*!40000 ALTER TABLE `cms_category` DISABLE KEYS */;
INSERT INTO `cms_category` VALUES (1,1,0,'About Us','about','','0','Y',0,0),(2,2,0,'Terms of Service','terms-of-service','','0','Y',0,0),(3,3,0,'Privacy policy','privacy-policy','','0','Y',0,0),(4,4,0,'Contact','contact','','0','Y',0,0),(5,5,0,'Project Management','project-management','','0','Y',1,4),(6,5,0,'Development','development','','0','Y',1,3),(7,5,0,'Design','design','','0','Y',1,2),(8,5,0,'Support','support','','0','Y',1,5),(9,5,0,'General Consultancy','general-consultancy','','0','Y',1,1),(10,5,0,'Documentation','documentation','','0','Y',1,6),(11,6,0,'Company Overview','homepage_text','','0','Y',1,0),(12,7,0,'FAQ','faq','','0','Y',0,0),(13,8,0,'Middleware / APIs','middleware-apis','','0','Y',1,1),(14,8,0,'Device Drivers','device-drivers','','0','Y',1,3),(15,8,0,'Hospitality','hospitality','','0','Y',1,2),(16,8,0,'Test Automation','test-automation','','0','Y',1,4);
/*!40000 ALTER TABLE `cms_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_content`
--

DROP TABLE IF EXISTS `cms_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `enabled` enum('Y','N') DEFAULT 'Y',
  `content_alias` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `description` longtext NOT NULL,
  `icon_1` int(11) NOT NULL,
  `content_status` enum('Image','Text','Both') NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_content`
--

LOCK TABLES `cms_content` WRITE;
/*!40000 ALTER TABLE `cms_content` DISABLE KEYS */;
INSERT INTO `cms_content` VALUES (1,1,1,'About','Y','about','About','<div class=\"content_pannel\"><div class=\"inner_contentarea\"><div class=\"staticpage_content\"><p><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis molestie   ultricies faucibus. Integer convallis ullamcorper dolor, at scelerisque   velit volutpat in. Nunc vel nulla nulla. Quisque ornare molestie   imperdiet. Sed adipiscing imperdiet orci, in laoreet erat rhoncus ut.   Proin suscipit vestibulum neque in cursus. Sed volutpat laoreet justo,   ac sagittis massa ornare non. Aliquam elit nunc, luctus varius turpis   non, tempus ornare erat. Nunc luctus dapibus metus, a dapibus tellus.   Maecenas feugiat molestie justo, eu posuere leo hendrerit at.</p>   <p>Vestibulum accumsan metus tempor, rutrum orci ut, euismod felis. Etiam   pretium augue purus, ac tincidunt arcu condimentum feugiat. In blandit   risus eu nulla facilisis euismod. Nam ornare scelerisque neque, vel   volutpat nibh adipiscing eget. Pellentesque at metus ut purus pretium   vestibulum vitae non purus. Nulla sollicitudin lorem nec ligula mattis   iaculis. Aenean eget pharetra arcu. Etiam aliquam neque ac tellus mollis   tempor. Vivamus ullamcorper lobortis laoreet. Duis vitae erat ipsum.   Etiam sit amet erat nibh. Mauris tempor ullamcorper commodo. Morbi vel   tristique tellus. Aliquam vehicula placerat nunc laoreet tempor.</p>   <p>Nulla viverra arcu eget faucibus faucibus. Donec dapibus sit amet tellus   at auctor. Nunc sed feugiat lorem, non rhoncus eros. Sed tempus dolor   nec elit eleifend imperdiet in non elit. Cum sociis natoque penatibus et   magnis dis parturient montes, nascetur ridiculus mus. Etiam rutrum,   purus non porta malesuada, lorem sem mollis turpis, at commodo dolor sem   vestibulum est. Sed accumsan vel dui at aliquet.</p>   <p>Sed blandit at elit in viverra. Morbi commodo sed orci nec vehicula.   Suspendisse varius leo vel purus pharetra sodales. Curabitur varius sed   arcu sed fringilla. Curabitur a blandit orci. Quisque sollicitudin   vulputate venenatis. Vestibulum egestas rhoncus elit, quis condimentum   erat. Pellentesque a eros quis felis laoreet fermentum a vitae elit.   Curabitur vel libero erat.</p>   <p>Donec in quam urna. Proin euismod lorem ante, non volutpat mauris   aliquam ac. Nullam vitae sodales justo. Sed nec porta metus. In eu   imperdiet neque, in ornare est. Nullam feugiat viverra mauris vitae   ullamcorper. Proin pulvinar erat egestas ante tincidunt varius. Vivamus   non lacinia quam. Testing</p><p></p></div></div>   <div class=\"clear\"></div></div>',0,'Text',0,'2018-07-11 12:20:00','2018-10-17 11:30:57',0),(2,2,2,'Terms of Service','Y','terms-of-service','Terms of Service','<div class=\"entry\">\r\n    <h3>Acceptance of the Terms of Uses</h3>\r\n\r\n\r\n<p>We may revise and update these Terms of Use from time to time at our sole discretion. All changes are effective immediately when we post them in the Terms of use section of the Application, and apply to all access to and use of the Application thereafter. Your continued use of the Application following the posting of revised Terms of Use means that you accept and agree to the changes.</p>\r\n\r\n\r\n<h3>Accessing the Application</h3>\r\n\r\n<p>We reserve the right to withdraw or amend the Application, and any service or material we provide on the Application, in our sole discretion without notice. We will not be liable if for any reason all or any part of the Application is unavailable at any time or for any period. From time to time, we may restrict access to some functionality of the Application, or the entire Application.</p>\r\n\r\n<h3>Intellectual Property Rights</h3>\r\n\r\n<p>By uploading a file or other content through the application, or by posting any other information to the application, you represent and warrant to us that (1) doing so does not violate or infringe anyone else\'s rights; and (2) you created the file or other content you are uploading, or otherwise have sufficient intellectual property rights to upload the material consistent with these terms. With regard to any file or content you upload to our Application, you grant us a non-exclusive, royalty-free, perpetual, irrevocable worldwide license (with sublicense and assignment rights) to use, to display online and in any present or future media, to create derivative works of, to allow downloads of, and/or distribute any such file or content. To the extent that you delete any such file or content from the Application, the license you grant us, pursuant to the preceding sentence will automatically terminate, but will not be revoked with respect to any file or content we have already copied and sublicensed or that has been downloaded or copied by other users of the Application in accordance with these Terms of Use. Any content you post to the Application may be used by the public pursuant to the following paragraph even after you delete it.</p>\r\n\r\n<h3>Use of Content</h3>\r\n\r\n<p>By downloading or copying other user-created content from the Application, you agree that you do not claim any rights to it. The following conditions apply: Your use of the user-created content is at your own risk. WE MAKE NO WARRANTIES OF NON-INFRINGEMENT, and you will indemnify and hold us harmless from any copyright infringement claims arising out of your use of the user-created content. You may not copy or use any portions of our Application that are not user-created content except within the limits of fair use.</p></div>',0,'Text',0,'2018-07-11 12:30:00','2018-10-17 10:51:06',0),(3,3,3,'Privacy policy','Y','privacy-policy','Privacy policy','<div class=\"entry\">\r\n    <h3>Introduction</h3>\r\n\r\n<p>\r\nThis policy applies to information we collect from the Application, and \r\nform any e-mail, text and other electronic messages between you and the \r\nCompany. The policy does not apply to information collected by us \r\noffline.<br>Please read this policy carefully to understand our policies\r\n and practices regarding your information and how we will treat it. If \r\nyou do not agree with our policies and practices, your choice is not to \r\nuse the Application. By installing or using the Application, you agree \r\nto this privacy policy. This policy may change from time to time. Your \r\ncontinued use of the Application after we make changes is deemed to be \r\nacceptance of those changes, so please check the policy periodically for\r\n updates in the Privacy Policy section of the Application.</p>\r\n\r\n<h3>Disclosure of Your Information</h3>\r\n\r\n<p>We may disclose user provided and automatically collected Information:</p>\r\n\r\n<ul>\r\n\r\n   <li> As required by law, such as to comply with a subpoena, or similar legal process;</li>\r\n\r\n\r\n <li> When we believe in good faith that disclosure is necessary to \r\nprotect our rights, protect your safety or the safety of others, \r\ninvestigate fraud, or respond to a government request;</li>\r\n\r\n\r\n       <li> With our trusted services providers who work on our behalf, \r\ndo not have an independent use of the information we disclose to them, \r\nand have agreed to adhere to the rules set forth in this privacy \r\nstatement.</li>\r\n\r\n\r\n\r\n<li> If Vusion Technologies LLC is involved in a merger, acquisition, or\r\n sale of all or a portion of its assets (although we will endeavor to \r\nnotify you of any change in ownership or uses of this information, as \r\nwell as any choices you may have regarding this information).</li>\r\n\r\n\r\n<li> To advertisers and third party advertising networks and analytics companies as described in the section below</li>\r\n\r\n</ul>\r\n\r\n\r\n<h3>Third-party Use of Tracking Technologies</h3>\r\n\r\n<p>\r\nWe may work with analytics companies to help us understand how the \r\nApplication is being used, such as the frequency and duration of usage. \r\nWe work with advertisers and third party advertising networks, who need \r\nto know how you interact with advertising provided in the Application \r\nwhich helps us keep the cost of the Application low. Advertisers and \r\nadvertising networks use some of the information collected by the \r\nApplication, including, but not limited to, the unique identification ID\r\n of your mobile device and your mobile telephone number. To protect the \r\nanonymity of this information, we use an encryption technology to help \r\nensure that these third parties canâ€™t identify you personally. These \r\nthird parties may also obtain anonymous information about other \r\napplications youâ€™ve downloaded to your mobile device, the mobile \r\nwebsites you visit, your non-precise location information (e.g., your \r\nzip code), and other non- precise location information in order to help \r\nanalyze and serve anonymous targeted advertising on the Application and \r\nelsewhere. We may also share encrypted versions of information you have \r\nprovided in order to enable our partners to append other available \r\ninformation about you for analysis or advertising related use.&nbsp;</p></div>',0,'Text',0,'2018-07-11 12:33:00','2018-07-11 12:33:48',0),(4,4,4,'Contact','Y','Contact','Send a Message','<p>Amco laboris nisi ut aliquip xea commodo consequt. Duis aute irure dolor reprehenderit voluptate velit esla fugit lore ipsum dolor sit consectetur adipisicing elit sed do eiusmod tempor incididunt bore aliqua ute enim ad mid veniam quis nostrud exercitation ullamco. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod.<br></p>',0,'Text',0,'2018-07-11 12:35:00','2018-07-11 14:16:56',0),(5,5,5,'Project Management','Y','project-management','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p style=\"text-align: center; \"><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; background-color: rgb(243, 243, 246);\"><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span><br></p><p></p>',11,'Text',0,'2018-07-11 13:36:00','2018-10-17 11:33:46',0),(6,5,6,'Development','Y','development','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis \nmolestie   ultricies faucibus. Integer convallis ullamcorper dolor, at \nscelerisque   velit volutpat in. Nunc vel nulla nulla. Quisque ornare \nmolestie   imperdiet. Sed adipiscing imperdiet orci, in laoreet erat \nrhoncus ut.   Proin suscipit vestibulum neque in cursus. Sed volutpat \nlaoreet justo,   ac sagittis massa ornare non. Aliquam elit nunc, luctus\n varius turpis   non, tempus ornare erat. Nunc luctus dapibus metus, a \ndapibus tellus.   Maecenas feugiat molestie justo, eu posuere leo \nhendrerit at.</p><p>Vestibulum accumsan metus tempor, rutrum orci ut,\n euismod felis. Etiam   pretium augue purus, ac tincidunt arcu \ncondimentum feugiat. In blandit   risus eu nulla facilisis euismod. Nam \nornare scelerisque neque, vel   volutpat nibh adipiscing eget. \nPellentesque at metus ut purus pretium   vestibulum vitae non purus. \nNulla sollicitudin lorem nec ligula mattis   iaculis. Aenean eget \npharetra arcu. Etiam aliquam neque ac tellus mollis   tempor. Vivamus \nullamcorper lobortis laoreet. Duis vitae erat ipsum.   Etiam sit amet \nerat nibh. Mauris tempor ullamcorper commodo. Morbi vel   tristique \ntellus. Aliquam vehicula placerat nunc laoreet tempor.</p><p>Nulla \nviverra arcu eget faucibus faucibus. Donec dapibus sit amet tellus   at \nauctor. Nunc sed feugiat lorem, non rhoncus eros. Sed tempus dolor   nec\n elit eleifend imperdiet in non elit. Cum sociis natoque penatibus et   \nmagnis dis parturient montes, nascetur ridiculus mus. Etiam rutrum,   \npurus non porta malesuada, lorem sem mollis turpis, at commodo dolor sem\n   vestibulum est. Sed accumsan vel dui at aliquet.</p><p>Sed blandit\n at elit in viverra. Morbi commodo sed orci nec vehicula.   Suspendisse \nvarius leo vel purus pharetra sodales. Curabitur varius sed   arcu sed \nfringilla. Curabitur a blandit orci. Quisque sollicitudin   vulputate \nvenenatis. Vestibulum egestas rhoncus elit, quis condimentum   erat. \nPellentesque a eros quis felis laoreet fermentum a vitae elit.   \nCurabitur vel libero erat.</p><p>            </p><p>Donec in quam urna. Proin euismod \nlorem ante, non volutpat mauris   aliquam ac. Nullam vitae sodales \njusto. Sed nec porta metus. In eu   imperdiet neque, in ornare est. \nNullam feugiat viverra mauris vitae   ullamcorper. Proin pulvinar erat \negestas ante tincidunt varius. Vivamus   non lacinia quam. Testing</p>',12,'Text',0,'2018-07-11 13:40:00','2018-10-17 11:33:46',0),(7,5,7,'Design','Y','design','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><br></p>',13,'Text',0,'2018-07-11 13:41:00','2018-10-17 11:33:46',0),(8,5,8,'Support','Y','support','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><br></p>',14,'Text',0,'2018-07-11 13:42:00','2018-10-17 11:33:46',0),(9,5,9,'General Consultancy','Y','general-consultancy','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><br></p>',15,'Text',0,'2018-07-11 13:42:00','2018-10-17 11:33:46',0),(10,5,10,'Documentation','Y','documentation','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.','<p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span></p><p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(243, 243, 246); display: inline !important; float: none;\"><br></span><br></p>',16,'Text',0,'2018-07-11 13:43:00','2018-10-17 11:33:46',0),(11,6,11,'Company Overview','Y','homepage_text','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, \neaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit \naspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Sed ut perspiciatis unde omnis iste \nnatus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.','<p><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">Armia - Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Sed ut perspiciatis unde omnis iste<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.</span><br></p>',0,'Text',0,'2018-07-11 14:11:00','2018-10-17 06:52:57',0),(12,7,12,'FAQ','Y','faq','','<h3>How do I make an account?</h3>\r\n\r\n<p>All you need is an email or active Facebook account.\r\n<br><b>With Facebook:</b>\r\n1.Click the â€˜Login with Facebookâ€™ button<br>\r\n2.Log into your Facebook account as prompted<br>\r\n3.Create a unique username &amp; password (required), as well as your first and last name (optional)\r\n<br>\r\n4.You should be able to successfully access the app<br>\r\n<b>With email:</b>\r\n1.Click the â€˜Register hereâ€™ buttonon<br>\r\n2.Create a unique username &amp; password (required), as well as your first and last name (optional). Put in your email address.\r\n<br>\r\n3.A verification email will be sent to the email address you made the account with. Open the email from PlayMe and click â€˜hereâ€™ to verify your account. <br>\r\n4.Go back to the PlayMe app and login with your email and password<br>\r\nIf you make an account via email, make sure to check your spam if you do not receive it in your normal inbox. If there is a lot of traffic on the app when you create an account, it may take a few minutes for the email to reach your inbox or spam.\r\n</p>\r\n\r\n<h3>How do I post something?</h3>\r\n\r\n<p>Click the â€˜+â€™ button in the middle of the bottom nav bar. Then choose the image you want to post and crop it. Then, add a title/caption (optional), choose a category, and add as many #tags as you like.</p>\r\n\r\n<h3>\r\nHow do I challenge a post?</h3>\r\n\r\n<p>Click the blue play button underneath any individual post, or next to any post that is currently in a challenge. You will be prompted to add a post from your current posts on the app, or may upload from your device. A notification will be sent to the player you challenged, and then they can accept or decline to make it active. Whoever has more votes after 24 hours, wins</p>\r\n\r\n<h3>How do I vote for a post?</h3>\r\n\r\n<p>Click the yellow vote button, dingus.</p>\r\n\r\n<h3>\r\nCan I invite someone to challenge a post I made?</h3>\r\n\r\n<p>Yes! After making a post, scroll down where there are two options: â€˜Doneâ€™ or â€˜PlayMeâ€™. If you select â€˜PlayMeâ€™, you may choose any players you are a fan of to send an invite to. You can go back to any post youâ€™ve made in your profile, and click the â€˜PlayMeâ€™ button below the post to send an invite at any time.</p>\r\n\r\n<h3>How do I find people I know on the app?</h3>\r\n\r\n<p>Click the menu tab from the bottom navigation bar. Then, click the â€˜Playersâ€™ option. From there, access the â€˜Facebook Friendsâ€™ tab. If you havenâ€™t already connected your FB account, the app will prompt you to login to your Facebook. Then, it will show your Facebook Friends that use the app (They have to have connected their Facebook account). If they are not on the app, you can send a Facebook invite to download once youâ€™ve connected your Facebook. You can also search people by username, so make sure to ask your friends for theirs!</p>\r\n\r\n<h3>Where do I find all my past activity?</h3>\r\n\r\n<p>All your past posts, challenges, votes, win/loss record, etc. can be accessed in your profile. The profile tab is on the far right on the bottom navigation bar.</p>\r\n\r\n<h3>How do the filters work?</h3>\r\n\r\n<p>On the home screen, you can press the â€˜Voteâ€™ button and it will change to â€˜Playâ€™. Pressing this changes your feed to and from vote mode (challenges) to play mode (singles posts).<br>\r\nYou can then access the filters by pressing the icon in the top right corner of your screen. If you are in vote mode, you can set your default feed to â€˜Popularâ€™, â€˜Fan ofâ€™ (people you follow), &amp; â€˜Recentâ€™. If you are in play mode, you can set the default feed to â€˜Fan ofâ€™ or â€˜Recentâ€™.<br>\r\nYou can also filter by category (e.g. Funny: Memes Encouraged), or by tags. The app shows the trending tags to choose from, or you can type in and apply one.<br>\r\nThe filters work together, so if for example you want to look for popular funny challenges, set the default feed to popular and check the â€˜Funny: Memes Encouragedâ€™ category. <br>\r\nAnother example: You want to look for Donald Trump memes to challenge. Put the home screen to play mode. Then choose â€˜Fan ofâ€™ or â€˜Recentâ€™ (depending on if you want it to be your friends or anyone). Check the â€˜Funny: Memes Encouragedâ€™ category and type in and apply #trump. Your feed should then be hilarious Trump Memes. This will work with anything you might be looking for (food pics, nature pics, awesome pics, etc.)\r\n</p>\r\n<h3>What if I see something inappropriate?</h3>\r\n\r\n<p>You can report any post by clicking on the three gray vertical dots, and then pressing report. All reported posts will be filtered through our software and taken down by our admins if it is deemed to be breaking our community guidelines, which can be accessed from your settings.</p>\r\n\r\n<h3>Can I make my account private?</h3>\r\n\r\n<p>Yes! Go to your settings and click the â€˜Account Privacyâ€™ option. If you turn this on, you have to approve fan requests in order for people to see everything on your profile.</p>\r\n\r\n<h3>What if I find something wrong with the app?</h3>\r\n\r\n<p>You can access the â€˜Report Bugs &amp; Send Feedbackâ€™ option from the menu tab. Please explain in detail what is wrong with the app, or what you would like to see incorporated into the app in the future. We read everything! </p>',0,'Text',0,'2018-07-11 14:12:00','2018-07-11 14:13:07',0),(13,8,13,'Middleware / APIs','Y','middleware-apis','To be ahead of cutting edge technology, reduced time to market and R&D cost.','<p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod \ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim \nveniam.',21,'Text',0,'2018-07-12 14:03:00','2018-10-17 11:33:46',0),(14,8,14,'Device Drivers','Y','device-drivers','Capgeminiâ€™s proven approach provides a compelling value proposition to our clients.','<p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Capgeminiâ€™s proven approach provides a compelling value proposition to our clients.&nbsp;',22,'Text',0,'2018-07-12 14:06:00','2018-10-17 11:33:46',0),(15,8,15,'Hospitality','Y','hospitality','Ours is an integrated approach to service delivery with strong Product Lifecycle.','<p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod \ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim \nveniam.',25,'Text',0,'2018-07-12 14:10:00','2018-10-17 11:33:46',0),(16,8,16,'Test Automation','Y','test-automation','As a one-stop solution provider, we help ISVs from product conceptualization.','<p>This content can be edited from the backend Pagesection > Page Categories > Page Contents .</p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod \ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim \nveniam.',26,'Text',0,'2018-07-12 14:12:00','2018-10-17 11:33:46',0);
/*!40000 ALTER TABLE `cms_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_files`
--

DROP TABLE IF EXISTS `cms_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_files` (
  `cms_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `last_updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_alias` varchar(255) NOT NULL,
  `file_id` int(11) NOT NULL,
  `display_width` int(11) NOT NULL,
  `display_height` int(11) NOT NULL,
  `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`cms_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_files`
--

LOCK TABLES `cms_files` WRITE;
/*!40000 ALTER TABLE `cms_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_groups`
--

DROP TABLE IF EXISTS `cms_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL,
  `position` int(3) DEFAULT '0',
  `published` varchar(1) DEFAULT 'Y',
  `user_privilege` varchar(256) NOT NULL DEFAULT 'all',
  `module` enum('admin','user') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_groups`
--

LOCK TABLES `cms_groups` WRITE;
/*!40000 ALTER TABLE `cms_groups` DISABLE KEYS */;
INSERT INTO `cms_groups` VALUES (1,'General',1,'Y','all','admin'),(2,'Configurations',6,'Y','all','admin'),(8,'SETUP',2,'Y','all','admin'),(9,'Manage Content',4,'Y','all','admin'),(10,'Profile',3,'Y','all','admin'),(11,'My Account',1,'Y','all','user');
/*!40000 ALTER TABLE `cms_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menu_items`
--

DROP TABLE IF EXISTS `cms_menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menu_items` (
  `menu_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) unsigned NOT NULL,
  `menu_parent_id` int(11) unsigned NOT NULL,
  `reference_type` enum('Section','Category','Content') NOT NULL COMMENT '1=Section,2=Category,3=content',
  `reference_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `menu_item_alias` varchar(255) NOT NULL,
  `target_type` enum('_self','_blank','_top') NOT NULL,
  `target_url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`menu_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menu_items`
--

LOCK TABLES `cms_menu_items` WRITE;
/*!40000 ALTER TABLE `cms_menu_items` DISABLE KEYS */;
INSERT INTO `cms_menu_items` VALUES (1,1,0,'Content',0,'Home','index','_self','index','0',1,'Y'),(2,1,0,'Content',1,'About','about','_self','about','0',2,'Y'),(3,1,0,'Section',0,'Services','services','_self','services','0',3,'Y'),(4,1,0,'Section',0,'Products','products','_self','products','0',4,'Y'),(5,1,0,'Content',4,'Contact','contact','_self','contact','0',5,'Y'),(6,2,0,'Content',0,'Home','home','_self','home','0',1,'Y'),(7,2,0,'Content',1,'About','about','_self','about','0',2,'Y'),(8,2,0,'Content',4,'Contact','contact','_self','contact','0',3,'Y'),(9,2,0,'Content',0,'Services','services','_self','services','0',4,'Y'),(10,2,0,'Content',2,'Terms of Service','terms-of-service','_self','terms-of-service','0',5,'Y'),(11,2,0,'Content',3,'Privacy policy','privacy-policy','','privacy-policy','0',6,'Y'),(12,1,3,'Category',10,'Project Management','project-management','_self','project-management','0',2,'Y'),(13,1,3,'Category',6,'Development','development','_self','development','0',1,'Y'),(14,1,3,'Category',7,'Design','design','_self','design','0',3,'Y'),(15,1,3,'Category',8,'Support','support','_self','support','0',4,'Y'),(16,1,3,'Category',9,'General Consultancy','general-consultancy','_self','general-consultancy','0',5,'Y'),(17,1,3,'Category',10,'Documentation','documentation','_self','documentation','0',6,'Y'),(18,1,4,'Category',13,'Middleware / APIs','middleware-apis','_self','middleware-apis','0',1,'Y'),(19,1,4,'Category',14,'Device Drivers','device-drivers','_self','device-drivers','0',2,'Y'),(20,1,4,'Category',15,'Hospitality','hospitality','_self','hospitality','0',3,'Y'),(21,1,4,'Category',16,'Test Automation','test-automation','_self','test-automation','0',4,'Y');
/*!40000 ALTER TABLE `cms_menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menus`
--

DROP TABLE IF EXISTS `cms_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menus` (
  `menus_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `menu_type` enum('Image','Text','Both') NOT NULL,
  `menu_class` varchar(255) NOT NULL,
  `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`menus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menus`
--

LOCK TABLES `cms_menus` WRITE;
/*!40000 ALTER TABLE `cms_menus` DISABLE KEYS */;
INSERT INTO `cms_menus` VALUES (1,'Top Main Menu','','Text','nav navbar-nav navbar-right','Y'),(2,'Footer Menu','','Text','','Y');
/*!40000 ALTER TABLE `cms_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_page_sections`
--

DROP TABLE IF EXISTS `cms_page_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_page_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `section_alias` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `icon` varchar(255) NOT NULL,
  `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `viewtype` enum('grid','list') NOT NULL DEFAULT 'grid',
  `show_homepage` int(1) DEFAULT '0',
  `homepage_viewformat` enum('slider','block','nil') NOT NULL DEFAULT 'nil',
  `homepage_order` int(11) DEFAULT '1',
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_page_sections`
--

LOCK TABLES `cms_page_sections` WRITE;
/*!40000 ALTER TABLE `cms_page_sections` DISABLE KEYS */;
INSERT INTO `cms_page_sections` VALUES (1,'About Us','about','','','N',0,'2018-07-11 12:18:00','grid',0,'nil',0),(2,'Terms of Service','terms-of-service','','','Y',0,'2018-07-11 12:30:00','grid',0,'nil',0),(3,'Privacy policy','privacy-policy','','','Y',0,'2018-07-11 12:32:00','grid',0,'nil',0),(4,'Contact','contact','','','Y',0,'2018-07-11 12:34:00','grid',0,'nil',0),(5,'Services','services','We understand the importance of approaching each work integrally and believe in the power of simple and easy communication.','','Y',0,'2018-07-11 13:28:00','grid',1,'block',1),(6,'Company Overview','homepage_text','','','Y',0,'2018-07-11 14:09:00','grid',0,'nil',0),(7,'FAQ','faq','','','Y',0,'2018-07-11 14:12:00','grid',0,'nil',0),(8,'Products','products','','','Y',0,'2018-07-12 14:01:00','list',1,'slider',1);
/*!40000 ALTER TABLE `cms_page_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_privileges`
--

DROP TABLE IF EXISTS `cms_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_privileges` (
  `privilege_id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` enum('group','section') NOT NULL,
  `entity_id` int(11) NOT NULL,
  `view_role_id` int(11) NOT NULL,
  `add_role_id` int(11) NOT NULL,
  `edit_role_id` int(11) NOT NULL,
  `delete_role_id` int(11) NOT NULL,
  `publish_role_id` int(11) NOT NULL,
  PRIMARY KEY (`privilege_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_privileges`
--

LOCK TABLES `cms_privileges` WRITE;
/*!40000 ALTER TABLE `cms_privileges` DISABLE KEYS */;
INSERT INTO `cms_privileges` VALUES (20,'section',2,1,1,1,1,1),(24,'group',2,1,1,1,1,1);
/*!40000 ALTER TABLE `cms_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_roles`
--

DROP TABLE IF EXISTS `cms_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(256) NOT NULL,
  `parent_role_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_roles`
--

LOCK TABLES `cms_roles` WRITE;
/*!40000 ALTER TABLE `cms_roles` DISABLE KEYS */;
INSERT INTO `cms_roles` VALUES (1,'admin',0);
/*!40000 ALTER TABLE `cms_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_sections`
--

DROP TABLE IF EXISTS `cms_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_sections` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `group_id` int(8) DEFAULT NULL,
  `section_name` varchar(200) DEFAULT NULL,
  `section_alias` varchar(200) DEFAULT NULL,
  `table_name` varchar(100) DEFAULT NULL,
  `section_config` text,
  `visibilty` enum('0','1') NOT NULL,
  `display_order` int(11) NOT NULL,
  `user_privilege` varchar(256) NOT NULL DEFAULT 'all',
  `module` enum('admin','user') NOT NULL DEFAULT 'admin',
  `db_type` enum('main','client') NOT NULL DEFAULT 'main',
  `smb_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_sections`
--

LOCK TABLES `cms_sections` WRITE;
/*!40000 ALTER TABLE `cms_sections` DISABLE KEYS */;
INSERT INTO `cms_sections` VALUES (1,2,'Manage Groups','groups','cms_groups','{\n	\"keyColumn\": \"id\",\n	\"orderBy\": {\n		\"id\": \"DESC\"\n	},\n	\"detailHeaderColumnPrefix\": \"Group\",\n	\"listColumns\": [\"id\", \"group_name\", \"position\"],\n	\"showColumns\": [\"id\", \"group_name\", \"position\"],\n	\"detailColumns\": [\"id\", \"group_name\", \"position\"],\n	\"detailHeaderColumns\": [\"group_name\"],\n	\"columns\": {\n		\"id\": {\n			\"name\": \"ID\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"group_name\": {\n			\"name\": \"Group Name\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Group Name\",\n				\"class\": \"textbox\",\n				\"hint\": \"Name of the group\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"position\": {\n			\"name\": \"Display Order\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Display Order\",\n				\"class\": \"textbox\",\n				\"hint\": \"Display order of the group\",\n				\"validations\": [\n					\"required\", \"number\"\n				]\n			}\n		}\n	},\n	\"customActions\": {\n		\"beforeAddRecord\": \"Cmshelper::validateForUniqueGroupName\",\n		\"beforeEditRecord\": \"Cmshelper::validateForUniqueGroupName\",\n		\"beforeDeleteRecord\": \"Cmshelper::checkIfMenuItemsExistsUnderGroup\"\n	},\n	\"opertations\": [\"add\", \"edit\", \"delete\", \"view\"]\n}','1',3,'','admin','main',0),(2,2,'Manage Sections','sections','cms_sections','{\n	\"keyColumn\": \"id\",\n	\"detailHeaderColumnPrefix\": \"Section\",\n	\"orderBy\": {\n		\"id\": \"DESC\"\n	},\n	\"listColumns\": [\"group_id\", \"section_name\", \"section_alias\", \"visibilty\", \"display_order\"],\n	\"showColumns\": [\"id\", \"group_id\", \"section_name\", \"section_alias\", \"table_name\", \"section_config\", \"visibilty\", \"display_order\", \"module\", \"db_type\", \"smb_id\"],\n	\"detailColumns\": [\"id\", \"group_id\", \"section_name\", \"section_alias\", \"table_name\", \"section_config\", \"visibilty\", \"display_order\", \"module\", \"db_type\", \"smb_id\"],\n	\"detailHeaderColumns\": [\"section_name\"],\n	\"columns\": {\n		\"id\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"smb_id\": {\n			\"name\": \"Client Account ID\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"group_id\": {\n			\"name\": \"Group ID\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"select\",\n				\"source\": \"Cms::getAllGroups\",\n				\"source_type\": \"function\",\n				\"label\": \"Group Name\",\n				\"class\": \"select\"\n			},\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"cms_groups\",\n				\"externalColumn\": \"id\",\n				\"externalShowColumn\": \"group_name\"\n			}\n		},\n		\"section_name\": {\n			\"name\": \"Section Name\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"textbox\",\n				\"label\": \"Section Name\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"section_alias\": {\n			\"name\": \"Section Alias\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"textbox\",\n				\"label\": \"Section Alias\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"table_name\": {\n			\"name\": \"Table Name\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"textbox\",\n				\"label\": \"Table Name\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"section_config\": {\n			\"name\": \"Section Config\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"textarea\",\n				\"label\": \"Section Config\",\n				\"class\": \"textarea\"\n			}\n		},\n		\"visibilty\": {\n			\"name\": \"Visibility\",\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeCmsSectionStatus\",\n				\"enumvalues\": {\n					\"1\": \"Published\",\n					\"0\": \"Unpublished\"\n				},\n				\"buttonColors\": {\n					\"1\": \"green\",\n					\"0\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"1\": \"Published\",\n					\"0\": \"Unpublished\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"Visibility\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"1\": \"Published\",\n					\"0\": \"Unpublished\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"display_order\": {\n			\"name\": \"Display Order\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Display Order\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"module\": {\n			\"name\": \"Module\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"select\",\n				\"source\": {\n					\"admin\": \"Admin\",\n					\"user\": \"User\"\n				},\n				\"source_type\": \"array\",\n				\"label\": \"Module\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"admin\": \"Admin\",\n					\"user\": \"User\"\n				}\n			}\n		},\n		\"db_type\": {\n			\"name\": \"DB Type\",\n			\"editoptions\": {\n				\"validations\": [\"required\"],\n				\"type\": \"select\",\n				\"source\": {\n					\"main\": \"Main DB\",\n					\"client\": \"Client DB\"\n				},\n				\"source_type\": \"array\",\n				\"label\": \"DB Type\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"main\": \"Main DB\",\n					\"client\": \"Client DB\"\n				}\n			}\n		}\n	},\n	\"opertations\": [\"add\", \"edit\", \"delete\", \"view\"]\n}','1',4,'','admin','main',NULL),(3,2,'Manage Settings','manage_settings','tbl_cms_settings','{\r\n\"keyColumn\":\"id\",\n\"detailHeaderColumnPrefix\": \"Settings\",\r\n\"listColumns\":[\"cms_set_name\",\"cms_set_value\"],\r\n\"showColumns\":[\"cms_set_name\",\"cms_set_value\"],\r\n\"detailColumns\":[\"id\",\"cms_set_name\",\"cms_set_value\"],\r\n\"detailHeaderColumns\":[\"cms_set_name\"],\r\n\"columns\":{\r\n    \"id\":{\"name\":\"ID\",\"sortable\":\"true\",\"editoptions\":{\"type\":\"hidden\"}},\r\n    \"cms_set_name\":{\"name\":\"Name\",\"sortable\":\"true\",\"searchable\":\"searchable\",\"editoptions\":{\"type\":\"disabled\",\"label\":\"Name\"}},\r\n    \"cms_set_value\":{\"name\":\"Value\",\"sortable\":\"true\",\"searchable\":\"searchable\",\"editoptions\":{\"type\":\"textbox\",\"label\":\"Value\",\"class\":\"textbox\"}}\r\n},\r\n\"opertations\":[\"edit\",\"view\"]\r\n}','1',2,'','admin','main',NULL),(53,9,'Homepage CMS','static_content','tbl_contents','{\n	\"keyColumn\": \"cnt_id\",\n	\"detailHeaderColumnPrefix\": \"Homepage CMS\",\n	\"detailHeaderColumns\": [\n		\"cnt_title\"\n	],\n	\"orderBy\": {\n		\"cnt_id\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"cnt_title\",\n		\"cnt_alias\",\n		\"cnt_order\",\n		\"cnt_status\"\n	],\n	\"showColumns\": [\n		\"cnt_title\",\n		\"cnt_alias\",\n		\"cnt_summary\",\n		\"cnt_content\",\n		\"cnt_button_text\",\n		\"cnt_order\",\n		\"cnt_status\"\n	],\n	\"detailColumns\": [\n		\"cnt_title\",\n		\"cnt_alias\",\n		\"cnt_button_text\",\n		\"cnt_summary\",\n		\"cnt_content\",\n		\"cnt_id\",\n		\"cnt_order\",\n		\"cnt_status\"\n	],\n	\"columns\": {\n		\"cnt_id\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"cnt_title\": {\n			\"name\": \"Title\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Title\",\n				\"class\": \"textbox\",\n				\"hint\": \"Title of the CMS content\"\n			}\n		},\n		\"cnt_alias\": {\n			\"name\": \"Alias\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Alias\",\n				\"class\": \"textbox\",\n				\"hint\": \"Alias of the CMS content\"\n			}\n		},\n		\"cnt_summary\": {\n			\"name\": \"Summary\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"htmlEditor\",\n				\"label\": \"Summary\",\n				\"class\": \"textarea\",\n				\"hint\": \"Summary of CMS data (If copy-paste the data, then copy the contents from notepad before paste into the editor)\"\n			}\n		},\n		\"cnt_content\": {\n			\"name\": \"Content\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"htmlEditor\",\n				\"label\": \"Content\",\n				\"class\": \"textarea\",\n				\"hint\": \"Content of CMS data (If copy-paste the data, then copy the contents from notepad before paste into the editor)\"\n			}\n		},\n		\"cnt_button_text\": {\n			\"name\": \"Button Text\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Button Text\",\n				\"class\": \"textbox\",\n				\"hint\": \"Button text if needed\"\n			}\n		},\n		\"cnt_order\": {\n			\"name\": \"Display Order\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Display Order\",\n				\"class\": \"textbox\",\n				\"hint\": \"Display order of the CMS content\",\n				\"validations\": [\n					\"required\", \"number\"\n				]\n			}\n		},\n		\"cnt_status\": {\n			\"name\": \"Status\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeHomepageCmsStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n				\"hint\": \"Status of the CMS content\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				}\n\n			}\n		}\n	},\n	\"opertations\": [\n		\"add\",\n		\"edit\",\n		\"view\",\n		\"delete\"\n	]\n}','1',1,'all','admin','main',NULL),(54,1,'Users','users','tbl_users','{\r\n	\"keyColumn\": \"user_id\",\r\n	\"detailHeaderColumnPrefix\": \"User\",\r\n	\"detailHeaderColumns\": [\r\n		\"user_fname\"\r\n	],\r\n	\"orderBy\": {\r\n		\"user_id\": \"DESC\"\r\n	},\r\n	\"includeJsFiles\": [\r\n		\"cmsvalidations.js\"\r\n	],\r\n\r\n\r\n	\"listColumns\": [\r\n		\"user_fname\",\r\n		\"user_name\",\r\n		\"user_email\",\r\n		\"user_photo1_id\"\r\n	],\r\n	\"showColumns\": [\r\n		\"user_fname\",\r\n		\"user_name\",\r\n		\"user_email\",\r\n		\"user_photo1_id\"\r\n	],\r\n	\"detailColumns\": [\r\n		\"user_fname\",\r\n		\"user_name\",\r\n		\"user_email\",\r\n		\"user_photo1_id\"\r\n	],\r\n	\"columns\": {\r\n		\"user_id\": {\r\n			\"name\": \"ID\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"hidden\"\r\n			}\r\n		},\r\n		\"user_fname\": {\r\n			\"name\": \"First Name\",\r\n			\"searchable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"textbox\",\r\n				\"label\": \"First Name\",\r\n				\"class\": \"textbox\",\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		},\r\n\r\n		\r\n		\"user_name\": {\r\n			\"name\": \"User Name\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"hidden\",\r\n				\"label\": \"User Name\",\r\n				\"class\": \"textbox\",\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		},\r\n		\"user_email\": {\r\n			\"name\": \"Email\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Email\",\r\n				\"class\": \"textbox\",\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		},\r\n\r\n		\"user_photo1_id\": {\r\n			\"name\": \"User Image\",\r\n			\"external\": \"true\",\r\n			\"externalOptions\": {\r\n				\"externalTable\": \"tbl_files\",\r\n				\"externalColumn\": \"file_id\",\r\n				\"externalShowColumn\": \"file_id\"\r\n			},\r\n			\"editoptions\": {\r\n				\"type\": \"file\",\r\n				\"label\": \"User Image\",\r\n				\"class\": \"file\"\r\n			}\r\n		}\r\n\r\n	},\r\n\r\n\r\n	\"opertations\": [\r\n		\"edit\",\r\n		\"delete\",\r\n		\"view\"\r\n\r\n	],\r\n	\"report\": {\r\n		\"reportTitle\": \"Users\",\r\n		\"columns\": [\r\n			\"user_fname\",\r\n			\"user_lname\",\r\n			\"user_email\",\r\n			\"user_joinedon\",\r\n			\"user_phone\",\r\n			\"set_private\"\r\n		],\r\n		\"dateColumn\": \"user_joinedon\"\r\n	}\r\n}','0',7,'all','admin','main',NULL),(70,10,'Change Password','change_password','cms_users','{\r\n    \"customCmsAction\": \"true\",\r\n    \"controller\": \"cms\",\r\n    \"method\": \"change_pwd\",\r\n    \"module\": \"cms\"\r\n}','1',1,'all','admin','main',NULL),(71,8,'Settings','settings','tbl_lookup','{\r\n    \"siteSettings\": \"true\",\r\n    \"settingStyle\": \"tab\",\r\n    \"beforeEditRecord\": \"Cmshelper::changeSettings\",\r\n    \"fieldList\":[\"nLookUp_Id\",\"vLookUp_Name\",\"vLookUp_Value\",\"settinglabel\",\"groupLabel\",\"helptext\",\"type\",\"parent_settingfield\",\"display_order\"],\r\n    \"fieldAssignment\":{\r\n        \"settingfield\":\"vLookUp_Name\",\r\n        \"value\":\"vLookUp_Value\"\r\n    },\r\n    \"hints\": {        \r\n        \"admin_email\": \"Email where all site notifications, alerts and notifications are sent\",\r\n        \"sitelogo\": \"This is where you can change the logo of your site.\"\r\n	}\r\n}','1',1,'all','admin','main',NULL),(58,8,'Settings_custom','settings','tbl_lookup','{\"customAction\":\"true\",\"controller\":\"cmshelper\",\"method\":\"settingsdisplay\",\"module\":\"default\"}\r\n','0',1,'all','admin','main',NULL),(59,1,'Dashboard','dashboard','tbl_lookup','{\n	\"dashboardPanel\": \"true\",\n	\"listingPanel\": \"true\",	\n	\"listingPanel1\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \"Recent Feedbacks\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getFeedbackLink\",\n			\"fetchValue\": \"Cmshelper::fetchRecentFeedback\",\n			\"listcolumns\": {\n				\"firstName\": {\n					\"name\": \"First Name\"\n				},\n				\"lastName\": {\n					\"name\": \"Last Name\"\n				},\n				\"emailId\": {\n					\"name\": \"Email\"\n				},\n				\"phone\": {\n					\"name\": \"Phone\"\n				},\n				\"city\": {\n					\"name\": \"City\"\n				},\n				\"subject\": {\n					\"name\": \"Subject\"\n				},\n				\"feedback_date\": {\n					\"name\": \"Feedback On\"\n				}\n			}\n		}\n	},\n        \"listingPanel2\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \"Recent Subscribers\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getSubscribersLink\",\n			\"fetchValue\": \"Cmshelper::fetchRecentSubscribers\",\n			\"listcolumns\": {				\n				\"vEmail\": {\n					\"name\": \"Email\"\n				},				\n				\"vJoinedOn\": {\n					\"name\": \"Subscribed On\"\n				}\n			}\n		}\n	},\n	\"graphPanel\": \"true\",\n	\"graphpanelRow\": \"1\",\n	\"graphPanel1\": {\n		\"columns\": \"2\",\n		\"graph1\": {\n			\"type\": \"MSColumn3D\",\n			\"caption\": \"Last One Week Newsletter Subscribers\",\n			\"xAxisName\": \"Last Week\",\n			\"yAxisName\": \"Subscribers Count\",\n			\"width\": \"480\",\n			\"height\": \"300\",\n			\"dataSetsCount\": \"1\",\n			\"dataSets\": {\n				\"dataset1\": {\n					\"name\": \"\",\n					\"color\": \"#d90d64\",\n					\"fetchValue\": \"Cmshelper::getEmailSubscribersCount\"\n				}\n			}\n		},\n		\"graph2\": {\n			\"type\": \"MSLine\",\n			\"caption\": \"Last One Week Feedback Count\",\n			\"xAxisName\": \"Last Week\",\n			\"yAxisName\": \"Feedback Count\",\n			\"width\": \"480\",\n			\"height\": \"300\",\n			\"dataSetsCount\": \"1\",\n			\"dataSets\": {\n				\"dataset1\": {\n					\"name\": \"\",\n					\"color\": \"#D3AC4F\",\n					\"fetchValue\": \"Cmshelper::getFeedbackCount\"\n				}\n			}\n		}\n	},\n	\"aggregatePanel\": \"true\",\n	\"aggregatePanelRow\": \"4\",\n	\"aggregatePanel1\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \" Newsletter Subscribers\",\n			\"titleicon\": \"users\",\n			\"boxcolor\": \"green\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getSubscribersLink\",\n			\"fetchValue\": \"Cmshelper::getTotalEmailSubscribers\"\n		}\n	},\n	\"aggregatePanel2\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \"Testimonials\",\n			\"titleicon\": \"file-text-o\",\n			\"boxcolor\": \"red\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getTestimonialsLink\",\n			\"fetchValue\": \"Cmshelper::getTotalTestimonials\"\n		}\n\n	},\n	\"aggregatePanel3\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \"Banners\",\n			\"titleicon\": \"file-picture-o\",\n			\"boxcolor\": \"blue\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getBannersLink\",\n			\"fetchValue\": \"Cmshelper::getTotalBanners\"\n		}\n	},\n	\"aggregatePanel4\": {\n		\"columns\": \"1\",\n		\"column1\": {\n			\"title\": \"Feedback\",\n			\"titleicon\": \"pencil-square-o\",\n			\"boxcolor\": \"gray\",\n			\"titlelink\": \"View All\",\n			\"titlelinkSection\": \"Cmshelper::getFeedbackLink\",\n			\"fetchValue\": \"Cmshelper::getTotalFeedbacks\"\n		}\n	}\n}','1',1,'all','admin','main',0),(105,1,'Banners','banners','tbl_banners','{\n	\"keyColumn\": \"banner_id\",\n	\"wildsearch\": \"true\",\n	\"handleFile\": \"true\",                 \"detailHeaderColumnPrefix\": \"Banner\",\n	\"detailHeaderColumns\": [\n		\"banner_name\"\n	],\n	\"orderBy\": {\n		\"banner_id\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"banner_id\",\n		\"banner_name\",\n		\"banner_title\",\n		\"banner_image_id1\",\n		\"banner_status\"\n\n	],\n	\"showColumns\": [\n		\"banner_id\",\n		\"banner_name\",\n		\"banner_title\",\n		\"banner_content\",\n		\"banner_image_id1\",\n		\"banner_status\"\n\n	],\n	\"detailColumns\": [\n		\"banner_id\",\n		\"banner_name\",\n		\"banner_title\",\n		\"banner_content\",\n		\"banner_image_id1\",\n		\"banner_status\"\n	],\n	\"columns\": {\n		\"banner_id\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"banner_name\": {\n			\"name\": \"Name\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Name\",\n				\"class\": \"textbox\",\n                                \"hint\": \"Name of the banner\"\n			}\n		},\n		\"banner_title\": {\n			\"name\": \"Banner Title\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Banner Title\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"banner_content\": {\n			\"name\": \"Banner Content\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textarea\",\n				\"label\": \"Banner Content\",\n				\"class\": \"textarea\"\n			}\n		},\n                \"banner_status\": {\n            \"name\": \"Status\",            \n            \"sortable\": \"true\",\n\"searchable\": \"searchable\",\n            \"listoptions\": {\n                \"type\": \"button\",\n                \"customaction\": \"Cmshelper::changeBannerStatus\",\n                \"enumvalues\": {\n                    \"Y\": \"Enabled\",\n                    \"N\": \"Disabled\"\n                },\n                \"buttonColors\": {\n                    \"Y\": \"green\",\n                    \"N\": \"red\"\n                }\n            },\n            \"editoptions\": {\n                \"type\": \"select\",\n                \"source\": {\n                    \"Y\": \"Enabled\",\n                    \"N\": \"Disabled\"\n                },\n                 \"default\":\"Y\",\n                \"source_type\": \"array\",\n                \"label\": \"status\",\n                \"class\": \"select\",\n                \"enumvalues\": {\n                    \"Y\": \"Enabled\",\n                    \"N\": \"Disabled\"\n                },\n                \"validations\": [\n                \"required\"\n                ]\n            }\n        },\n		\"banner_image_id1\": {\n			\"name\": \"Banner Image\",\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"tbl_files\",\n				\"externalColumn\": \"file_id\",\n				\"externalShowColumn\": \"file_id\"\n			},\n			\"editoptions\": {\n				\"type\": \"file\",\n				\"label\": \"Banner Image\",\n				\"class\": \"file\",\n				\"hint\": \"Upload file with 1350px X 550px or more\",\n                \"file_types\":\"gif,png,jpg,jpeg,bmp\",\n				\"validations\": [\n					\"required\", \"file_type\"\n				]\n			}\n		}\n	},\n	\"opertations\": [\n		\"add\",\n		\"edit\",\n		\"view\",\n		\"delete\"\n	]   \n}','1',3,'all','admin','main',NULL),(63,8,'Application Settings','appsettings','apptbl_settings','{\"customAction\":\"true\",\"controller\":\"cmshelper\",\"method\":\"appsettingsdisplay\",\"module\":\"default\"}\r\n','0',4,'all','admin','main',NULL),(66,1,'Manage Content','manage_content','tbl_user_profile','{\r\n    \"keyColumn\": \"profile_id\",\r\n    \"detailHeaderColumnPrefix\": \"User Profiles: \",\r\n    \"detailHeaderColumns\": [\r\n        \"user_email\"\r\n    ],\r\n    \"orderBy\": {\r\n        \"profile_id\": \"DESC\"\r\n    },\r\n    \"listColumns\": [\r\n	\"profile_id\",\r\n        \"user_id\",\r\n        \"user_email\",\r\n        \"user_phone\",\r\n        \"user_phone_extension\"        \r\n    ],\r\n    \"showColumns\": [\r\n        \"profile_id\",\r\n        \"user_id\",\r\n        \"user_email\",\r\n        \"user_phone\",\r\n        \"user_phone_extension\"\r\n        \r\n    ],\r\n    \"detailColumns\": [\r\n	\"profile_id\",\r\n        \"user_id\",\r\n        \"user_email\",\r\n        \"user_phone\",\r\n        \"user_phone_extension\"      \r\n    ],\r\n    \"columns\": {\r\n        \"profile_id\": {\r\n            \"name\": \"Profile ID\",\r\n            \"sortable\": \"true\",\r\n            \"searchable\": \"true\",\r\n            \"editoptions\": {\r\n                \"type\": \"hidden\"\r\n            }\r\n        },\r\n        \"user_email\": {\r\n            \"name\": \"User Email\",\r\n            \"sortable\": \"true\"           \r\n        },\r\n        \"user_id\": {\r\n            \"name\": \"User Name\",\r\n            \"sortable\": \"true\",\r\n            \"external\": \"true\",\r\n            \"externalOptions\": {\r\n                \"externalTable\": \"tbl_users\",\r\n                \"externalColumn\": \"user_id\",\r\n                \"externalShowColumn\":\"user_lname\"\r\n            }           \r\n        },\r\n        \"user_phone\": {\r\n            \"name\": \"Phone\",\r\n            \"searchable\": \"true\",\r\n            \"sortable\": \"true\",\r\n            \"editoptions\": {\r\n                \"type\": \"textbox\",\r\n                \"label\": \"Phone Number\",\r\n                \"class\": \"textbox\",\r\n                \"validations\": [\r\n                    \"required\"\r\n                ]\r\n            }\r\n        },\r\n        \"user_phone_extension\": {\r\n            \"name\": \"Phone Extension\",\r\n            \"searchable\": \"true\",\r\n            \"sortable\": \"true\",\r\n            \"editoptions\": {\r\n                \"type\": \"textbox\",\r\n                \"label\": \"Phone Extension\",\r\n                \"class\": \"textbox\",\r\n                \"validations\": [\r\n                    \"required\"\r\n                ]\r\n            }\r\n        },\r\n        \r\n       \r\n	 \r\n    \"opertations\": [\r\n	\"add\",\r\n        \"view\",\r\n        \"edit\",\r\n        \"delete\"\r\n    ],\r\n	\"report\": {\r\n        \"reportTitle\": \"User Profiles\",\r\n        \"columns\": [\r\n                    \"profile_id\",\r\n                    \"user_email\",\r\n                    \"user_phone\",\r\n                    \"user_phone_extension\",\r\n                    \"User Name\"\r\n                ]\r\n    }\r\n}\r\n}\r\n','0',1,'all','user','main',NULL),(67,2,'Manage Roles','manage_roles','cms_roles','{\"customCmsAction\":\"true\",\"controller\":\"cms\",\"method\":\"manageroles\",\"module\":\"cms\"}','1',1,'all','admin','main',NULL),(68,2,'Manage Privileges ','cms_privileges','cms_privileges','{\"customCmsAction\":\"true\",\"controller\":\"cms\",\"method\":\"manageprivilege\",\"module\":\"cms\"}','1',1,'all','admin','main',NULL),(69,2,'CMS users','cms_users','cms_users','{\"customCmsAction\":\"true\",\"controller\":\"cms\",\"method\":\"manageusers\",\"module\":\"cms\"}','1',1,'all','admin','main',NULL),(7,9,'Menus','menu','cms_menus','{\r\n    \"keyColumn\": \"menus_id\",\r\n    \"wildsearch\": \"true\",    \"detailHeaderColumnPrefix\": \"Menus: \",\r\n    \"detailHeaderColumns\": [\r\n        \"title\"\r\n    ],\r\n    \"breadCrumbColumn\": \"title\",\r\n    \"orderBy\": {\r\n        \"menus_id\": \"DESC\"\r\n    },\r\n    \"listColumns\": [\r\n  \"menus_id\",\r\n        \"title\",\r\n        \"position\",\r\n        \"menu_type\",       \r\n        \"enabled\"\r\n    ],\r\n    \"showColumns\": [\r\n        \"title\",\r\n        \"position\",\r\n        \"menu_type\",\r\n        \"menu_class\",\r\n        \"enabled\"\r\n    ],\r\n    \"detailColumns\": [        \r\n        \"menus_id\",\r\n        \"title\",\r\n        \"position\",\r\n        \"menu_type\",\r\n        \"menu_class\",\r\n        \"enabled\"\r\n    ],\r\n    \"columns\": {\r\n            \"menus_id\": {\r\n                \"name\": \"ID\",\r\n                \"editoptions\": {\r\n                    \"type\": \"hidden\"\r\n                }\r\n            },\r\n            \"title\": {\r\n            \"name\": \"Title\",\r\n            \"searchable\": \"true\",\r\n            \"sortable\": \"true\",\r\n            \"editoptions\": {\r\n                \"type\": \"textbox\",\r\n                \"label\": \"Title\",\r\n                \"class\": \"textbox\",\r\n                \"hint\": \"Title of the menu\",\r\n                \"validations\": [\r\n                    \"required\"\r\n                ]\r\n                }\r\n            },\r\n            \"position\": {\r\n                \"name\": \"Position\",\r\n                \"searchable\": \"true\",\r\n                \"sortable\": \"true\",\r\n                \"editoptions\": {\r\n                    \"type\": \"textbox\",\r\n                    \"label\": \"Position\",\r\n                    \"class\": \"textbox\"\r\n                }\r\n            },\r\n            \"menu_type\": {\r\n                \"name\": \"Menu Type\",\r\n                \"searchable\": \"true\",\r\n                \"sortable\": \"true\",\r\n                \"editoptions\": {\r\n                    \"type\": \"select\",\r\n                     \"default\":\"Text\",\r\n                    \"source\": {\r\n                        \"Image\": \"Image\",\r\n                        \"Text\": \"Text\",\r\n                        \"Both\": \"Both\"\r\n                    },\r\n                    \"source_type\": \"array\",\r\n                    \"label\": \"Menu Type\",\r\n                    \"class\": \"select\",\r\n                    \"enumvalues\": {\r\n                        \"Image\": \"Image\",\r\n                        \"Text\": \"Text\",\r\n                        \"Both\": \"Both\"\r\n                    },  \"validations\": [\r\n                    \"required\"\r\n                ]\r\n                }\r\n            },\r\n            \"menu_class\": {\r\n                \"name\": \"Menu Class\",\r\n                \"searchable\": \"true\",\r\n                \"sortable\": \"true\",\r\n                \"editoptions\": {\r\n                    \"type\": \"textbox\",\r\n                    \"label\": \"Menu Class\",\r\n                    \"class\": \"textbox\",\r\n                    \"hint\": \"css class of the menu element\"\r\n                }\r\n            },\r\n            \"enabled\": {\r\n                \"name\": \"Status\",              \r\n                \"sortable\": \"true\",\r\n                \"listoptions\": {\r\n                    \"type\": \"button\",\r\n                    \"customaction\": \"Cmshelper::changeMenuStatus\",\r\n                    \"enumvalues\": {\r\n                        \"Y\": \"Enabled\",\r\n                        \"N\": \"Disabled\"\r\n                    },\r\n                    \"buttonColors\": {\r\n                        \"Y\": \"green\",\r\n                        \"N\": \"red\"\r\n                    }\r\n                },\r\n                \"editoptions\": {\r\n                    \"type\": \"select\",\r\n                    \"source\": {\r\n                        \"Y\": \"Enabled\",\r\n                        \"N\": \"Disabled\"\r\n                    },\r\n                   \"default\":\"Y\",\r\n                    \"source_type\": \"array\",\r\n                    \"label\": \"status\",\r\n                    \"class\": \"select\",\r\n                    \"enumvalues\": {\r\n                        \"Y\": \"Enabled\",\r\n                        \"N\": \"Disabled\"\r\n                    },\r\n  \"validations\": [\r\n                    \"required\"\r\n                ]\r\n                }\r\n            }\r\n    },\r\n    \"relations\": {\r\n        \"Menu Items\": {\r\n            \"name\": \"Menu Items\",\r\n            \"section\": \"menu_items\",\r\n            \"child_table\": \"cms_menu_items\",\r\n            \"parent_join_column\": \"menus_id\",\r\n            \"child_join_column\": \"menus_id\"\r\n        }\r\n     },\r\n        \"opertations\": [            \r\n            \"view\",\r\n            \"edit\"            \r\n        ],\r\n\"operationLabel\": {\r\n           \"addLabel\": \"Add Menu\",\r\n           \"editTitle\": \"Edit Menu\",\r\n            \"viewTitle\": \"View Menu Details\",\r\n             \"deleteTitle\": \"Delete Menu\"\r\n              }\r\n    }\r\n    \r\n    ','1',1,'all','admin','main',NULL),(8,9,'Page Section','pageSection','cms_page_sections','{\r\n	\"keyColumn\": \"section_id\",\r\n	\"wildsearch\": \"true\",\r\n	\"detailHeaderColumnPrefix\": \"Page Sections: \",\r\n	\"handleFile\": \"true\",\r\n	\"detailHeaderColumns\": [\r\n		\"title\"\r\n	],\r\n	\"breadCrumbColumn\": \"title\",\r\n	\"orderBy\": {\r\n		\"section_id\": \"DESC\"\r\n	},\r\n	\"listColumns\": [\r\n		\"section_id\",\r\n		\"title\",\r\n		\"section_alias\",\r\n		\"enabled\"\r\n	],\r\n	\"showColumns\": [\r\n		\"title\",\r\n		\"section_alias\",		\r\n		\"enabled\",\r\n		\"created_by\",\r\n		\"created_on\",\r\n		\"viewtype\",\r\n		\"show_homepage\",\r\n		\"homepage_viewformat\",\r\n		\"homepage_order\"\r\n	],\r\n	\"detailColumns\": [\r\n		\"section_id\",\r\n		\"title\",\r\n		\"section_alias\",		\r\n		\"enabled\",\r\n		\"created_by\",\r\n		\"created_on\",\r\n		\"viewtype\",\r\n		\"show_homepage\",\r\n		\"homepage_viewformat\",\r\n		\"homepage_order\"\r\n	],\r\n	\"columns\": {\r\n		\"section_id\": {\r\n			\"name\": \"ID\",\r\n			\"editoptions\": {\r\n				\"type\": \"hidden\"\r\n			}\r\n		},\r\n		\"title\": {\r\n			\"name\": \"Title\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Title\",\r\n				\"class\": \"textbox\",\r\n				\"hint\": \"Title of the page section\",\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		},\r\n		\"section_alias\": {\r\n			\"name\": \"Alias\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Alias\",\r\n				\"class\": \"textbox\",\r\n                                \"hint\": \"Alias of the page section (Do not use space between alias wording)\",\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		},			\r\n		\"show_homepage\": {\r\n			\"name\": \"Show On Homepage\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"select\",\r\n				\"default\": \"Text\",\r\n				\"source\": {\r\n					\"0\": \"No\",\r\n					\"1\": \"Yes\"\r\n				},\r\n				\"source_type\": \"array\",\r\n				\"label\": \"Show On Homepage\",\r\n\"hint\": \"Whether the page section should display on the homepage\",\r\n				\"class\": \"select\",\r\n				\"enumvalues\": {\r\n					\"0\": \"No\",\r\n					\"1\": \"Yes\"\r\n				}\r\n			}\r\n		},\r\n		\"homepage_viewformat\": {\r\n			\"name\": \"Homepage display Format\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"select\",\r\n				\"default\": \"Text\",\r\n				\"source\": {\r\n					\"slider\": \"Slider type display\",\r\n					\"block\": \"Grid type display\",\r\n					\"nil\": \"N/A\"\r\n				},\r\n				\"source_type\": \"array\",\r\n				\"label\": \"Homepage display Format\",\r\n\"hint\": \"Display format for the page section on the homepage\",\r\n				\"class\": \"select\",\r\n				\"enumvalues\": {\r\n					\"slider\": \"Slider type display\",\r\n					\"block\": \"Grid type display\",\r\n					\"nil\": \"N/A\"\r\n				}\r\n			}\r\n		},\r\n                \"homepage_order\": {\r\n			\"name\": \"Homepage display order\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Homepage display order\",\r\n\"hint\": \"Homepage display order for the page section\",\r\n				\"class\": \"textbox\"				\r\n			}\r\n		},\r\n		\"viewtype\": {\r\n			\"name\": \"List page display format\",\r\n			\"searchable\": \"true\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"select\",\r\n				\"default\": \"grid\",\r\n				\"source\": {\r\n					\"grid\": \"Grid type display\",\r\n					\"list\": \"List type display\"\r\n				},\r\n				\"source_type\": \"array\",\r\n				\"label\": \"List page display format\",\r\n\"hint\": \"Display format of the list pages for the page section\",\r\n				\"class\": \"select\",\r\n				\"enumvalues\": {\r\n					\"grid\": \"Grid type display\",\r\n					\"list\": \"List type display\"\r\n				}\r\n			}\r\n		},                \r\n		\"created_by\": {\r\n			\"name\": \"Created By\"\r\n		},\r\n		\"created_on\": {\r\n			\"name\": \"Created On\"\r\n		},\r\n		\"enabled\": {\r\n			\"name\": \"Status\",			\r\n			\"sortable\": \"true\",\r\n			\"listoptions\": {\r\n				\"type\": \"button\",\r\n				\"customaction\": \"Cmshelper::changePageSectionStatus\",\r\n				\"enumvalues\": {\r\n					\"Y\": \"Enabled\",\r\n					\"N\": \"Disabled\"\r\n				},\r\n				\"buttonColors\": {\r\n					\"Y\": \"green\",\r\n					\"N\": \"red\"\r\n				}\r\n			},\r\n			\"editoptions\": {\r\n				\"type\": \"select\",\r\n				\"source\": {\r\n					\"Y\": \"Enabled\",\r\n					\"N\": \"Disabled\"\r\n				},\r\n				\"default\": \"Y\",\r\n				\"source_type\": \"array\",\r\n				\"label\": \"status\",\r\n				\"class\": \"select\",\r\n				\"enumvalues\": {\r\n					\"Y\": \"Enabled\",\r\n					\"N\": \"Disabled\"\r\n				},\r\n				\"validations\": [\r\n					\"required\"\r\n				]\r\n			}\r\n		}\r\n	},\r\n	\"customActions\": {\r\n		\"beforeAddRecord\": \"Cmshelper::createdInfo\",\r\n		\"beforeEditRecord\": \"Cmshelper::updateInfo\"\r\n	},\r\n	\"relations\": {\r\n		\"Categories\": {\r\n			\"name\": \"Categories\",\r\n			\"section\": \"pageCategories\",\r\n			\"child_table\": \"cms_category\",\r\n			\"parent_join_column\": \"section_id\",\r\n			\"child_join_column\": \"section_id\"\r\n		}\r\n	},\r\n	\"opertations\": [\r\n		\"add\",\r\n		\"view\",\r\n		\"edit\",\r\n		\"delete\"\r\n	]\r\n}','1',3,'all','admin','main',NULL),(91,2,'Settings','cms_settings','tbl_lookup_cms','{\r\n	\"siteSettings\": \"true\",\r\n	\"settingStyle\": \"tab\",\r\n	\"beforeEditRecord\": \"Cmshelper::changeSettings\",\r\n	\"fieldList\": [\"nLookUp_Id\", \"settingfield\", \"value\", \"settinglabel\", \"groupLabel\", \"type\", \"parent_settingfield\", \"display_order\"],\r\n	\"fieldAssignment\": {\r\n		\"settingfield\": \"settingfield\",\r\n		\"value\": \"value\"\r\n	},\r\n	\"hints\": {\r\n		\"admin_email\": \"Email where all site notifications, alerts and notifications are sent\",\r\n		\"sitelogo\": \"This is where you can change the logo of your site.\"\r\n	}\r\n}','0',1,'all','admin','main',NULL),(72,8,'report','report','tbl_lookup_cms','{\r\n    \"reportPanel\": \"true\",\r\n    \"reportTitle\": \"Report \",\r\n     \"defaultDateRange\": \"weekly\",\r\n    \"dateRange\": [\r\n        \"weekly\",\r\n        \"monthly\",\r\n        \"custom\",\r\n        \"all\"\r\n    ],\r\n    \"dateField\": \"last_updated_on\",\r\n    \"dataSource\": {\r\n        \"queryFunction\": \"Cmshelper::getReportQuery\",\r\n        \"orderBy\": {\r\n            \"client_id\": \"ASC\"\r\n        },\r\n        \"groupBy\": [\r\n            \"client_id\"\r\n        ]\r\n    },\r\n    \"export\": \"true\",\r\n    \"keyColumn\": \"id\",\r\n    \"listColumns\": [\r\n        \"vorganization\",\r\n        \"ticket_count\",\r\n        \"chat_count\",\r\n        \"other_count\",\r\n        \"reply_count\",\r\n        \"resolution_time\",\r\n        \"initial_responsetime\",\r\n        \"resolved_in_first_response\"\r\n    ],\r\n \"exportColumns\": [\r\n        \"vorganization\",\r\n        \"ticket_count\",\r\n        \"chat_count\",\r\n        \"other_count\",\r\n        \"reply_count\",\r\n        \"resolution_time\",\r\n        \"initial_responsetime\",\r\n        \"resolved_in_first_response\"\r\n    ],\r\n    \"detailColumns\": [\r\n        \"vorganization\",\r\n        \"ticket_count\",\r\n        \"chat_count\",\r\n        \"other_count\",\r\n        \"reply_count\",\r\n        \"resolution_time\",\r\n        \"initial_responsetime\",\r\n        \"resolved_in_first_response\"\r\n    ],\r\n    \"columns\": {\r\n        \"vorganization\": {\r\n            \"name\": \"Client\",\r\n            \"type\": \"text\",\r\n            \"sortable\": \"true\",\r\n            \"searchable\": \"searchable\"\r\n        },\r\n        \"ticket_count\": {\r\n            \"name\": \"Total Tickets\",\r\n            \"type\": \"text\"\r\n        },\r\n        \"chat_count\": {\r\n            \"name\": \"Total Chat \",\r\n            \"type\": \"text\"\r\n        },\r\n        \"other_count\": {\r\n            \"name\": \"Total Others \",\r\n            \"type\": \"text\"\r\n        },\r\n        \"reply_count\": {\r\n            \"name\": \"Average Replies Per Ticket \",\r\n            \"type\": \"text\"\r\n        },\r\n        \"resolution_time\": {\r\n            \"name\": \"Average Ticket Resolution Time\",\r\n            \"type\": \"text\",\r\n            \"postfix\": \" minutes\"\r\n        },\r\n        \"initial_responsetime\": {\r\n            \"name\": \"Average Initial Response Time\",\r\n            \"type\": \"text\",\r\n            \"postfix\": \" minutes\"\r\n        },\r\n        \"resolved_in_first_response\": {\r\n            \"name\": \"Tickets Resolved In First Response\",\r\n            \"type\": \"text\"\r\n        },\r\n        \"last_updated_on\": {\r\n            \"name\": \"Updated On\",\r\n            \"type\": \"datetime\",\r\n            \"dbFormat\": \"datetime\",\r\n            \"displayFormat\": \"m/d/Y H:i a\",\r\n            \"sortable\": \"true\"\r\n        }\r\n    }\r\n}','0',100,'all','admin','main',NULL),(74,11,'Change Password','change_password','cms_users','{\r\n    \"customCmsAction\": \"true\",\r\n    \"controller\": \"cms\",\r\n    \"method\": \"change_pwd\",\r\n    \"module\": \"cms\"\r\n}','1',1,'all','user','main',NULL),(106,1,'Testimonials','testimonials','tbl_testimonials','{\n	\"keyColumn\": \"testi_id\",\n	\"wildsearch\": \"true\",\n	\"handleFile\": \"true\",\n	\"detailHeaderColumnPrefix\": \"Testimonial\",\n	\"detailHeaderColumns\": [\n		\"testi_name\"\n	],\n	\"orderBy\": {\n		\"testi_id\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"testi_name\",\n		\"testi_location\",\n		\"testi_image_1\",\n		\"status\"\n	],\n	\"showColumns\": [\n		\"testi_id\",\n		\"testi_name\",\n		\"testi_desc\",\n		\"testi_location\",\n		\"testi_image_1\",\n		\"status\"\n	],\n	\"detailColumns\": [\n		\"testi_id\",\n		\"testi_name\",\n		\"testi_desc\",\n		\"testi_location\",\n		\"testi_image_1\",\n		\"status\"\n	],\n	\"columns\": {\n		\"testi_id\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"testi_name\": {\n			\"name\": \"Title\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Title\",\n				\"class\": \"textbox\",\n				\"hint\": \"Testimonial name\"\n			}\n		},\n		\"testi_location\": {\n			\"name\": \"Location\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Location\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"testi_desc\": {\n			\"name\": \"Description\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textarea\",\n				\"label\": \"Description\",\n				\"class\": \"textarea\"\n			}\n		},\n		\"testi_image_1\": {\n			\"name\": \"Testimonial Image\",\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"tbl_files\",\n				\"externalColumn\": \"file_id\",\n				\"externalShowColumn\": \"file_id\"\n			},\n			\"editoptions\": {\n				\"type\": \"file\",\n				\"label\": \"Testimonial Image\",\n				\"class\": \"file\",\n				\"hint\": \"Upload file with 250px X 250px or more\",\n				\"file_types\": \"gif,png,jpg,jpeg,bmp\"\n			}\n		},\n		\"status\": {\n			\"name\": \"Status\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeTestimonialStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		}\n	},\n	\"opertations\": [\n		\"add\",\n		\"edit\",\n		\"view\",\n		\"delete\"\n	]\n}','1',4,'all','admin','main',NULL),(107,1,'Meta Tags','metatags','tbl_metatags','{\n	\"keyColumn\": \"mid\",\n	\"detailHeaderColumnPrefix\": \"Meta Tag\",\n	\"detailHeaderColumns\": [\"pagename\"],\n	\"orderBy\": {\n		\"mid\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"title\",\n		\"description\",\n		\"pagename\",\n		\"pageurl\"\n	],\n	\"showColumns\": [\n		\"title\",\n		\"description\",\n		\"pagename\",\n		\"pageurl\"\n	],\n	\"detailColumns\": [\n		\"title\",\n		\"description\",\n		\"pagename\",\n		\"pageurl\"\n	],\n	\"columns\": {\n		\"mid\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"title\": {\n			\"name\": \"Meta Title\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Title\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"description\": {\n			\"name\": \"Description\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textarea\",\n				\"label\": \"Description\",\n				\"class\": \"textarea\"\n			}\n		},\n		\"pagename\": {\n			\"name\": \"Page Name\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Page Name\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"pageurl\": {\n			\"name\": \"Page Url\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"validations\": [\n					\"required\"\n				],\n				\"type\": \"textbox\",\n				\"label\": \"Page Url\",\n				\"class\": \"textbox\"\n			}\n		}\n	},\n	\"opertations\": [\n		\"add\",\n		\"edit\", \n                \"delete\",\n		\"view\"\n	]\n}','1',2,'all','admin','main',NULL),(115,9,'Newsletter','newsletter','tbl_newsletters','{\n	\"keyColumn\": \"vNewsletterId\",\n	\"wildsearch\": \"true\",\n	\"detailHeaderColumnPrefix\": \"Newsletter\",\n	\"handleFile\": \"true\",\n	\"detailHeaderColumns\": [\n		\"vSubject\"\n	],\n	\"breadCrumbColumn\": \"vSubject\",\n	\"orderBy\": {\n		\"vNewsletterId\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"vNewsletterId\",\n		\"vSubject\",\n		\"vSendDate\",\n		\"vSendStatus\",\n		\"vStatus\",\n		\"vCreatedOn\"\n	],\n	\"showColumns\": [\n		\"vNewsletterId\",\n		\"vSubject\",\n		\"vContent\",\n		\"vSendDate\",\n		\"vSendStatus\",\n		\"vStatus\",\n		\"vCreatedOn\",\n		\"vLastUpdatedOn\"\n	],\n	\"detailColumns\": [\n		\"vNewsletterId\",\n		\"vSubject\",\n		\"vContent\",\n		\"vSendDate\",\n		\"vSendStatus\",\n		\"vStatus\",\n		\"vCreatedOn\",\n		\"vLastUpdatedOn\"\n	],\n	\"columns\": {\n		\"vNewsletterId\": {\n			\"name\": \"ID\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"vSubject\": {\n			\"name\": \"Subject\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Subject\",\n				\"class\": \"textbox\",\n				\"hint\": \"Subject of the newsletter\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"vContent\": {\n			\"name\": \"Content\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"htmlEditor\",\n				\"label\": \"Content\",\n				\"class\": \"textarea\",\n				\"hint\": \"Content for the newsletter\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"vSendDate\": {\n			\"name\": \"Send date\",\n			\"dbFormat\": \"date\",\n			\"displayFormat\": \"m/d/Y\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"datepicker\",\n				\"dbFormat\": \"date\",\n				\"label\": \"Send date\",\n				\"class\": \"textbox\",\n				\"hint\": \"Newsletter sending date using cronjob\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"vSendStatus\": {\n			\"name\": \"Sent status\",\n			\"editoptions\": {\n				\"type\": \"hidden\",\n				\"label\": \"Sent status\",\n				\"class\": \"textbox\"\n			}\n\n		},\n		\"vStatus\": {\n			\"name\": \"Status\",			\n			\"sortable\": \"true\", \n                        \"searchable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeNewsletterStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n				\"hint\": \"Status of the newsletter\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"vCreatedOn\": {\n			\"name\": \"Created On\",\n			\"dbFormat\": \"date\",\n			\"displayFormat\": \"m/d/Y\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"vLastUpdatedOn\": {\n			\"name\": \"Last Updated On\",\n			\"dbFormat\": \"date\",\n			\"displayFormat\": \"m/d/Y\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		}\n	},\n	\"customActions\": {\n		\"afterAddRecord\": \"Cmshelper::newsletterCreatedInfo\",\n		\"afterEditRecord\": \"Cmshelper::newsletterUpdatedInfo\",\n		\"beforeAddRecord\": \"Cmshelper::checkIfNewsletterExistForDayByAdd\",\n		\"beforeEditRecord\": \"Cmshelper::checkIfNewsletterExistForDayByEdit\"\n	},\n	\"opertations\": [\n		\"add\",\n		\"view\",\n		\"edit\",\n		\"delete\"\n	]\n}','1',6,'all','admin','main',NULL),(108,1,'Email Subscribers','email_subscribers','tbl_newsletter_subscribers','{\n	\"keyColumn\": \"vSubscriberId\",\n	\"detailHeaderColumnPrefix\": \"Email Subscriber\",\n	\"orderBy\": {\n		\"vSubscriberId\": \"DESC\"\n	},\n	\"listColumns\": [\"vSubscriberId\", \"vEmail\", \"vJoinedOn\", \"vStatus\"],\n	\"showColumns\": [\"vSubscriberId\", \"vEmail\", \"vJoinedOn\", \"vStatus\"],\n	\"detailColumns\": [\"vSubscriberId\", \"vEmail\", \"vJoinedOn\", \"vStatus\"],\n	\"detailHeaderColumns\": [\"vEmail\"],\n	\"columns\": {\n		\"vSubscriberId\": {\n			\"name\": \"ID\",\n			\"sortable\": \"true\",			\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"vEmail\": {\n			\"name\": \"Email ID\",\n			\"sortable\": \"true\",\n			\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Email ID\",\n				\"class\": \"textbox\"\n			}\n		},\n		\"vJoinedOn\": {\n			\"name\": \"Subscribed On\",\n			\"dbFormat\": \"date\",\n			\"displayFormat\": \"m/d/Y\",\n\"searchable\": \"searchable\",\n			\"editoptions\": {\n				\"type\": \"datepicker\",\n				\"label\": \"Subscribed On\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"vStatus\": {\n			\"name\": \"Status\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeSubscriptionStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		}\n	},\n	\"customActions\": {\n		\"beforeAddRecord\": \"Cmshelper::checkIfEmailSubscribedByAdd\",\n		\"beforeEditRecord\": \"Cmshelper::checkIfEmailSubscribedByEdit\"\n	},\n	\"opertations\": [\"delete\", \"view\"]\n}','1',6,'all','admin','main',NULL),(109,1,'Feedback','feedback','tbl_feedbacks','{\r\n	\"keyColumn\": \"feedback_id\",\r\n	\"wildsearch\": \"true\",\r\n	\"handleFile\": \"true\",\n       \"detailHeaderColumnPrefix\": \"Feedback\",\r\n	\"detailHeaderColumns\": [\r\n		\"firstName\"\r\n	],\r\n	\"orderBy\": {\r\n		\"feedback_id\": \"DESC\"\r\n	},\r\n	\"listColumns\": [\r\n		\"firstName\",\r\n		\"lastName\",\r\n		\"emailId\",\r\n		\"phone\",\r\n		\"city\",\r\n		\"subject\",		\r\n		\"feedback_date\"\r\n	],\r\n	\"showColumns\": [\r\n		\"firstName\",\r\n		\"lastName\",\r\n		\"address\",\r\n		\"emailId\",\r\n		\"phone\",\r\n		\"country\",\r\n		\"city\",\r\n		\"subject\",\r\n		\"message\",\r\n		\"feedback_date\"\r\n	],\r\n	\"detailColumns\": [\r\n		\"firstName\",\r\n		\"lastName\",\r\n		\"address\",\r\n		\"emailId\",\r\n		\"phone\",\r\n		\"country\",\r\n		\"city\",\r\n		\"subject\",\r\n		\"message\",\r\n		\"feedback_date\"\r\n	],\r\n	\"columns\": {\r\n		\"feedback_id\": {\r\n			\"name\": \"ID\",\r\n			\"sortable\": \"true\",\r\n			\"editoptions\": {\r\n				\"type\": \"hidden\"\r\n			}\r\n		},\r\n		\"firstName\": {\r\n			\"name\": \"First Name\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Name\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"lastName\": {\r\n			\"name\": \"Last Name\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"editoptions\": {\r\n				\"validations\": [],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Last Name\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"address\": {\r\n			\"name\": \"Address\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textarea\",\r\n				\"label\": \"Address\",\r\n				\"class\": \"textarea\"\r\n			}\r\n		},\r\n		\"subject\": {\r\n			\"name\": \"Subject\",\r\n			\"label\": \"Subject\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Subject\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"city\": {\r\n			\"name\": \"City\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"City\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"country\": {\r\n			\"name\": \"Country\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Country\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"phone\": {\r\n			\"name\": \"Phone\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Phone\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"emailId\": {\r\n			\"name\": \"Email\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n					\"required\"\r\n				],\r\n				\"type\": \"textbox\",\r\n				\"label\": \"Email\",\r\n				\"class\": \"textbox\"\r\n			}\r\n		},\r\n		\"message\": {\r\n			\"name\": \"Feedback\",\r\n			\"editoptions\": {\r\n				\"validations\": [\r\n\r\n				],\r\n				\"type\": \"textarea\",\r\n				\"label\": \"Feedback\",\r\n				\"class\": \"textarea\"\r\n			}\r\n		},\r\n		\"feedback_date\": {\r\n			\"name\": \"Added On\",\r\n			\"sortable\": \"true\",\r\n			\"searchable\": \"searchable\",\r\n			\"dbFormat\": \"date\",\r\n			\"displayFormat\": \"m/d/Y\",\r\n			\"editoptions\": {\r\n				\"dbFormat\": \"date\",\r\n				\"displayFormat\": \"m/d/Y\",\r\n				\"type\": \"datepicker\",\r\n				\"label\": \"Added On\",\r\n				\"class\": \"\",\r\n				\"hint\": \"Added On\",\r\n				\"validations\": [\r\n\r\n				]\r\n			}\r\n		}\r\n	},\r\n	\"opertations\": [\r\n		\"view\"\r\n	]\r\n}','1',5,'all','admin','main',0),(110,9,'Page Categories','pageCategories','cms_category','   {\r\n   	\"keyColumn\": \"category_id\",\r\n   	\"wildsearch\": \"true\",\r\n   	\"reference\": {\r\n   		\"referenceTable\": \" cms_page_sections\",\r\n   		\"referenceColumn\": \"section_id\",\r\n   		\"referenceTableForiegnKey\": \"section_id\"\r\n   	},\r\n   	\"detailHeaderColumnPrefix\": \"Categories: \",\r\n   	\"handleFile\": \"true\",\r\n   	\"detailHeaderColumns\": [\r\n   		\"title\"\r\n   	],\r\n   	\"breadCrumbColumn\": \"title\",\r\n   	\"orderBy\": {\r\n   		\"category_id\": \"DESC\"\r\n   	},\r\n   	\"listColumns\": [\r\n   		\"category_id\",\r\n   		\"title\",\r\n   		\"category_alias\",\r\n   		\"enabled\"\r\n   	],\r\n   	\"showColumns\": [\r\n   		\"category_id\",\r\n   		\"section_id\",\r\n   		\"title\",\r\n   		\"category_alias\",\r\n   		\"show_homepage\",\r\n   		\"homepage_order\",\r\n   		\"enabled\"\r\n   	],\r\n   	\"detailColumns\": [\r\n   		\"category_id\",\r\n   		\"section_id\",\r\n   		\"title\",\r\n   		\"category_alias\",\r\n   		\"show_homepage\",\r\n   		\"homepage_order\",\r\n   		\"enabled\"\r\n   	],\r\n   	\"columns\": {\r\n   		\"category_id\": {\r\n   			\"name\": \"ID\",\r\n   			\"editoptions\": {\r\n   				\"type\": \"hidden\"\r\n   			}\r\n   		},\r\n   		\"section_id\": {\r\n   			\"name\": \"Section\",\r\n   			\"sortable\": \"true\",\r\n   			\"searchable\": \"true\",\r\n   			\"external\": \"true\",\r\n   			\"externalOptions\": {\r\n   				\"externalTable\": \"cms_page_sections\",\r\n   				\"externalColumn\": \"section_id\",\r\n   				\"externalShowColumn\": \"title\"\r\n   			},\r\n   			\"editoptions\": {\r\n   				\"type\": \"hidden\"\r\n   			}\r\n   		},\r\n   		\"title\": {\r\n   			\"name\": \"Title\",\r\n   			\"searchable\": \"true\",\r\n   			\"sortable\": \"true\",\r\n   			\"editoptions\": {\r\n   				\"type\": \"textbox\",\r\n   				\"label\": \"Title\",\r\n   				\"class\": \"textbox\",\r\n   				\"hint\": \"Title of the page category\",\r\n   				\"validations\": [\r\n   					\"required\"\r\n   				]\r\n   			}\r\n   		},\r\n   		\"category_alias\": {\r\n   			\"name\": \"Alias\",\r\n   			\"searchable\": \"true\",\r\n   			\"sortable\": \"true\",\r\n   			\"editoptions\": {\r\n   				\"type\": \"textbox\",\r\n   				\"label\": \"Alias\",\r\n   				\"class\": \"textbox\",\r\n   				\"hint\": \"Alias of the page category  (Do not use space between the alias wording)\",\r\n   				\"validations\": [\r\n   					\"required\"\r\n   				]\r\n   			}\r\n   		},\r\n   		\"show_homepage\": {\r\n   			\"name\": \"Show On Homepage\",\r\n   			\"searchable\": \"true\",\r\n   			\"sortable\": \"true\",\r\n   			\"editoptions\": {\r\n   				\"type\": \"select\",\r\n   				\"default\": \"No\",\r\n   				\"source\": {\r\n   					\"0\": \"No\",\r\n   					\"1\": \"Yes\"\r\n   				},\r\n   				\"source_type\": \"array\",\r\n   				\"label\": \"Show On Homepage\",\r\n   				\"class\": \"select\",\r\n   				\"hint\": \"Whether the catehory should display on the homepage\",\r\n   				\"enumvalues\": {\r\n   					\"0\": \"No\",\r\n   					\"1\": \"Yes\"\r\n   				}\r\n\r\n   			}\r\n   		},\r\n   		\"homepage_order\": {\r\n   			\"name\": \"Display Order\",\r\n   			\"searchable\": \"true\",\r\n   			\"sortable\": \"true\",\r\n   			\"editoptions\": {\r\n   				\"type\": \"textbox\",\r\n   				\"label\": \"Display Order\",\r\n   				\"class\": \"textbox\",\r\n   				\"hint\": \"Category display order on homepage\"\r\n   			}\r\n   		},\r\n   		\"enabled\": {\r\n   			\"name\": \"Status\",   			\r\n   			\"sortable\": \"true\",\r\n   			\"listoptions\": {\r\n   				\"type\": \"button\",\r\n   				\"customaction\": \"Cmshelper::changePageCategoryStatus\",\r\n   				\"enumvalues\": {\r\n   					\"Y\": \"Enabled\",\r\n   					\"N\": \"Disabled\"\r\n   				},\r\n   				\"buttonColors\": {\r\n   					\"Y\": \"green\",\r\n   					\"N\": \"red\"\r\n   				}\r\n   			},\r\n   			\"editoptions\": {\r\n   				\"type\": \"select\",\r\n   				\"source\": {\r\n   					\"Y\": \"Enabled\",\r\n   					\"N\": \"Disabled\"\r\n   				},\r\n   				\"default\": \"Y\",\r\n   				\"source_type\": \"array\",\r\n   				\"label\": \"status\",\r\n   				\"class\": \"select\",\r\n   				\"enumvalues\": {\r\n   					\"Y\": \"Enabled\",\r\n   					\"N\": \"Disabled\"\r\n   				},\r\n   				\"validations\": [\r\n   					\"required\"\r\n   				]\r\n   			}\r\n   		}\r\n   	},\r\n   	\"relations\": {\r\n   		\"Contents\": {\r\n   			\"name\": \"Contents\",\r\n   			\"section\": \"pageContent\",\r\n   			\"child_table\": \"cms_content\",\r\n   			\"parent_join_column\": \"category_id\",\r\n   			\"child_join_column\": \"category_id\"\r\n   		}\r\n   	},\r\n   	\"opertations\": [\r\n   		\"add\",\r\n   		\"view\",\r\n   		\"edit\",\r\n   		\"delete\"\r\n   	]\r\n   }','0',4,'all','admin','main',NULL),(111,9,'Page Contents','pageContent','cms_content','{\n	\"keyColumn\": \"content_id\",\n	\"wildsearch\": \"true\",\n	\"detailHeaderColumnPrefix\": \"Content\",\n	\"reference\": {\n		\"referenceTable\": \" cms_category\",\n		\"referenceColumn\": \"category_id\",\n		\"referenceTableForiegnKey\": \"category_id\"\n	},\n	\"handleFile\": \"true\",\n	\"detailHeaderColumns\": [\n		\"title\"\n	],\n	\"breadCrumbColumn\": \"title\",\n	\"orderBy\": {\n		\"content_id\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"content_id\",\n		\"title\",\n		\"content_alias\",\n		\"summary\",\n		\"content_status\",\n		\"icon_1\",\n		\"enabled\"\n	],\n	\"showColumns\": [\n		\"content_id\",\n		\"section_id\",\n		\"category_id\",\n		\"title\",\n		\"content_alias\",\n		\"summary\",\n		\"description\",\n		\"content_status\",\n		\"icon_1\",\n		\"enabled\",\n		\"created_by\",\n		\"created_on\",\n		\"last_updated_by\"\n	],\n	\"detailColumns\": [\n		\"content_id\",\n		\"section_id\",\n		\"category_id\",\n		\"title\",\n		\"content_alias\",\n		\"summary\",\n		\"description\",\n		\"content_status\",\n		\"icon_1\",\n		\"enabled\",\n		\"created_by\",\n		\"created_on\",\n		\"last_updated_by\"\n	],\n\n	\"columns\": {\n		\"content_id\": {\n			\"name\": \"ID\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"category_id\": {\n			\"name\": \"Category\",\n			\"external\": \"true\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			},\n			\"externalOptions\": {\n				\"externalTable\": \"cms_category\",\n				\"externalColumn\": \"category_id\",\n				\"externalShowColumn\": \"title\"\n			}\n		},\n		\"section_id\": {\n			\"name\": \"Section\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"cms_page_sections\",\n				\"externalColumn\": \"section_id\",\n				\"externalShowColumn\": \"title\"\n			},\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"created_by\": {\n			\"name\": \"Created\"\n		},\n		\"created_on\": {\n			\"name\": \"Created Time\"\n		},\n		\"last_updated_by\": {\n			\"name\": \"Last Updated By\"\n		},\n		\"content_status\": {\n			\"name\": \"Content Type\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"default\": \"Text\",\n				\"source\": {\n					\"Text\": \"Text\"\n				},\n				\"source_type\": \"array\",\n				\"label\": \"Content Type\",\n				\"class\": \"select\",\n                                \"hint\": \"Type of the page content\",\n				\"enumvalues\": {\n					\"Text\": \"Text\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"title\": {\n			\"name\": \"Title\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Title\",\n				\"class\": \"textbox\",\n				\"hint\": \"Title of the page content\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"content_alias\": {\n			\"name\": \"Alias\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Alias\",\n				\"class\": \"textbox\",\n                                \"hint\": \"Alias of the page content (Do not use space between the alias wording)\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"summary\": {\n			\"name\": \"Summary\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textarea\",\n				\"label\": \"Summary\",\n				\"class\": \"textarea\",                                \n				\"hint\": \"Short Summary for the content\"\n			}\n		},\n		\"description\": {\n			\"name\": \"Description\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"htmlEditor\",\n				\"label\": \"Description\",\n				\"class\": \"textarea\",\n				\"hint\": \"Description for the content\"\n			}\n		},\n		\"icon_1\": {\n			\"name\": \"Image\",\n			\"editoptions\": {\n				\"type\": \"file\",\n				\"label\": \"Icon\",\n				\"class\": \"file\",\n				\"hint\": \"Upload image for the section\"\n			},\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"tbl_files\",\n				\"externalColumn\": \"file_id\",\n				\"externalShowColumn\": \"file_id\"\n			}\n		},\n		\"enabled\": {\n			\"name\": \"Status\",			\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeContentStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n                                \"hint\": \"Status of the content\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		}\n	},\n	\"customActions\": {\n		\"afterAddRecord\": \"Cmshelper::updateContentSection\",\n		\"afterEditRecord\": \"Cmshelper::updateContentSection\",\n		\"beforeAddRecord\": \"Cmshelper::createdInfo\",\n		\"beforeEditRecord\": \"Cmshelper::updateInfo\"\n	},\n	\"opertations\": [\n		\"add\",\n		\"view\",\n		\"edit\",\n		\"delete\"\n	]\n}','0',5,'all','admin','main',NULL),(112,9,'Menu Items','menu_items','cms_menu_items','{\n	\"keyColumn\": \"menu_item_id\",\n	\"wildsearch\": \"true\",\n	\"handleFile\": \"true\",\n	\"reference\": {\n		\"referenceTable\": \"cms_menus\",\n		\"referenceColumn\": \"menus_id\",\n		\"referenceTableForiegnKey\": \"menus_id\"\n	},\n	\"detailHeaderColumnPrefix\": \"Menu Item\",\n	\"detailHeaderColumns\": [\n		\"title\"\n	],\n	\"orderBy\": {\n		\"menu_item_id\": \"DESC\"\n	},\n	\"listColumns\": [\n		\"menu_item_id\",\n		\"title\",\n		\"menu_parent_id\",\n		\"menu_item_alias\",\n		\"reference_type\",\n		\"reference_id\",\n		\"target_type\",\n		\"target_url\",\n		\"display_order\",\n		\"enabled\"\n	],\n	\"showColumns\": [\n		\"menu_item_id\",\n		\"title\",\n		\"menu_parent_id\",\n		\"menus_id\",\n		\"menu_item_alias\",\n		\"reference_type\",\n		\"reference_id\",\n		\"target_type\",\n		\"target_url\",\n		\"display_order\",\n		\"enabled\"\n	],\n	\"detailColumns\": [\n		\"menu_item_id\",\n		\"menus_id\",\n		\"menu_parent_id\",\n		\"title\",\n		\"menu_item_alias\",\n		\"reference_type\",\n		\"reference_id\",\n		\"target_type\",\n		\"target_url\",\n		\"display_order\",\n		\"enabled\"\n	],\n	\"columns\": {\n		\"menu_item_id\": {\n			\"name\": \"ID\",\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"menus_id\": {\n			\"name\": \"Menu\",\n			\"sortable\": \"true\",\n			\"searchable\": \"true\",\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"cms_menus\",\n				\"externalColumn\": \"menus_id\",\n				\"externalShowColumn\": \"title\"\n			},\n			\"editoptions\": {\n				\"type\": \"hidden\"\n			}\n		},\n		\"menu_parent_id\": {\n			\"name\": \"Parent\",\n			\"sortable\": \"true\",\n			\"searchable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": \"Cmshelper::getAllMenuItems\",\n				\"source_type\": \"function\",\n				\"label\": \"Parent\",\n				\"class\": \"select\",\n				\"hint\": \"Parent of the menu item\"\n			},\n			\"external\": \"true\",\n			\"externalOptions\": {\n				\"externalTable\": \"cms_menu_items\",\n				\"externalColumn\": \"menu_item_id\",\n				\"externalShowColumn\": \"title\"\n			}\n		},\n		\"reference_type\": {\n			\"name\": \"Association Type\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Section\": \"Section\",\n					\"Category\": \"Category\",\n					\"Content\": \"Content\"\n				},\n				\"hint\": \"Choose \'Section\' if the menu is for category contained parent module, \'Category\' if it for the module categories, \'Content\' if it for CMS data\",\n				\"source_type\": \"array\",\n				\"label\": \"Association Type\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"Section\": \"Section\",\n					\"Category\": \"Category\",\n					\"Content\": \"Content\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"reference_id\": {\n			\"name\": \"Associated CMS Content Id\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Associated CMS Content Id\",\n				\"class\": \"textbox\",\n				\"hint\": \"The related page category or content item ID, Set the value to 0 if the association type is \'Section\'\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"title\": {\n			\"name\": \"Title\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Title\",\n				\"class\": \"textbox\",\n				\"hint\": \"Title of the menu item\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"menu_item_alias\": {\n			\"name\": \"Alias\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Alias\",\n				\"class\": \"textbox\",\n				\"hint\": \"Alias name of the related page section/ page category/ page content\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"target_type\": {\n			\"name\": \"Target Type\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"_self\": \"_self\",\n					\"_blank\": \"_blank\",\n					\"_top\": \"_top\"\n\n				},\n				\"source_type\": \"array\",\n				\"label\": \"Target Type\",\n				\"class\": \"select\",\n				\"enumvalues\": {\n					\"new\": \"new\",\n					\"_blank\": \"_blank\"\n				}\n			}\n		},\n		\"target_url\": {\n			\"name\": \"Target Url\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Target Url\",\n				\"class\": \"textbox\",\n				\"hint\": \"Target url (SEO Url) of the related page section/ category/ content. It should be same as alias value\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"display_order\": {\n			\"name\": \"Display Order\",\n			\"searchable\": \"true\",\n			\"sortable\": \"true\",\n			\"editoptions\": {\n				\"type\": \"textbox\",\n				\"label\": \"Display Order\",\n				\"class\": \"textbox\",\n				\"hint\": \"Display order of the menu on header/footer in front end pages\",\n				\"validations\": [\n					\"required\"\n				]\n			}\n		},\n		\"enabled\": {\n			\"name\": \"Status\",			\n			\"sortable\": \"true\",\n			\"listoptions\": {\n				\"type\": \"button\",\n				\"customaction\": \"Cmshelper::changeMenuItemStatus\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"buttonColors\": {\n					\"Y\": \"green\",\n					\"N\": \"red\"\n				}\n			},\n			\"editoptions\": {\n				\"type\": \"select\",\n				\"source\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"default\": \"Y\",\n				\"source_type\": \"array\",\n				\"label\": \"status\",\n				\"class\": \"select\",\n				\"hint\": \"Whether to display the menu item in front end pages\",\n				\"enumvalues\": {\n					\"Y\": \"Enabled\",\n					\"N\": \"Disabled\"\n				},\n				\"validations\": [\n					\"required\"\n				]\n			}\n		}\n	},\n	\"opertations\": [\n		\"add\",\n		\"view\",\n		\"edit\",\n		\"delete\"\n	]\n}','0',0,'all','admin','main',NULL);
/*!40000 ALTER TABLE `cms_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('sadmin','admin') NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','deleted') NOT NULL,
  `module` enum('admin','user') NOT NULL DEFAULT 'admin',
  `visibility` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_users`
--

LOCK TABLES `cms_users` WRITE;
/*!40000 ALTER TABLE `cms_users` DISABLE KEYS */;
INSERT INTO `cms_users` VALUES (64,'admin','administrator','935d8b77ac3ab24217ddaacbea903083','administrator@gmail.com',0,'active','admin','1');
/*!40000 ALTER TABLE `cms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_usertoken`
--

DROP TABLE IF EXISTS `cms_usertoken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_usertoken` (
  `ut_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `accessToken` varchar(145) DEFAULT NULL,
  `deviceType` varchar(45) DEFAULT NULL,
  `deviceID` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`ut_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_usertoken`
--

LOCK TABLES `cms_usertoken` WRITE;
/*!40000 ALTER TABLE `cms_usertoken` DISABLE KEYS */;
INSERT INTO `cms_usertoken` VALUES (1,11,'1dd1d5bc6fe389bbb8a7b79f3a69c265','webui','123456','2018-07-10 12:56:21','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `cms_usertoken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smb`
--

DROP TABLE IF EXISTS `smb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `smbid_exten` varchar(50) DEFAULT NULL,
  `data` varchar(1000) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smb`
--

LOCK TABLES `smb` WRITE;
/*!40000 ALTER TABLE `smb` DISABLE KEYS */;
/*!40000 ALTER TABLE `smb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appsettings`
--

DROP TABLE IF EXISTS `tbl_appsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appsettings` (
  `settings_id` int(10) NOT NULL AUTO_INCREMENT,
  `settings_order` int(10) DEFAULT '0',
  `settings_name` varchar(255) DEFAULT NULL,
  `settings_value` varchar(255) DEFAULT NULL,
  `settings_label` varchar(255) DEFAULT NULL,
  `settings_group` varchar(50) DEFAULT NULL,
  `settings_field` varchar(50) DEFAULT NULL,
  `settings_helptext` tinytext,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appsettings`
--

LOCK TABLES `tbl_appsettings` WRITE;
/*!40000 ALTER TABLE `tbl_appsettings` DISABLE KEYS */;
INSERT INTO `tbl_appsettings` VALUES (1,1,'admin_mail','admin123@kliqbooth.com','Admin Email','email','textbox',NULL),(2,2,'admin_email_from_name','Admin123','Admin Email Name','email','textbox',NULL),(4,4,'smtp_host','smtp.gmail.com','SMTP Host','email','textbox',NULL),(3,3,'smtp_enable','true','Enable SMTP','email','textbox',NULL),(5,5,'smtp_port','4651','SMTP Port','email','textbox',NULL),(6,6,'smtp_username','alan.f@armiasystems.com','SMTP Username','email','textbox',NULL),(7,7,'smtp_pwd','kl8as3608','SMTP Password','email','textbox',NULL),(8,8,'company-name','Armia Systems pvt ltd1','Company Name','general','textbox',NULL),(9,9,'asterisk-no','55','Asterisk Number','calls','textbox','The asterisk number that you purchased'),(10,10,'asterisk-ip','192.168.0.28','Asterisk IP','calls','textbox','The outgoing ip address'),(11,11,'queue-waiting-time','101','Queue Waiting Time','calls','textbox','Seconds wait in the queue'),(12,12,'companylogo','mupd5s6hg8b.jpg','Company Logo','general','textbox',NULL),(18,18,'searchtype','1','Enable all field search','general','options','Search type in listing pages'),(13,13,'welcomemsgivr','mv45p8f7va5.wav','Welcome Message IVR','calls','file','Welcome message IVR'),(14,14,'periodicannouncement','mv42friq2zh.wav','Periodic Announcement','calls','file','Periodic announcement message'),(15,15,'callforwarding','0','Call Forwarding','calls','options','Call forwarding'),(16,16,'restrictsingleip','0','Restrict To Single Ip','calls','options','Restrict to single ip'),(17,17,'blockoutgoing','0','Block Outgoing','calls','options','Block Outgoing');
/*!40000 ALTER TABLE `tbl_appsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_banners`
--

DROP TABLE IF EXISTS `tbl_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_banners` (
  `banner_id` int(10) NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(250) DEFAULT '0',
  `banner_image_id1` int(10) DEFAULT '0',
  `banner_title` varchar(250) DEFAULT '0',
  `banner_content` text,
  `banner_status` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_banners`
--

LOCK TABLES `tbl_banners` WRITE;
/*!40000 ALTER TABLE `tbl_banners` DISABLE KEYS */;
INSERT INTO `tbl_banners` VALUES (1,'Business Solution',1,'Business Solution','Give yourself the best\nchance of success with Solution','Y'),(2,'Market Solution',3,'Market Solution','Give yourself the best\nchance of success with Solution','Y'),(3,'Industry Solution',4,'Industry Solution','Give yourself the best\nchance of success with Solution','N'),(6,'Business Solution',50,'Business Solution','Give yourself the best \nchance of success with Solution','Y');
/*!40000 ALTER TABLE `tbl_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bug_report`
--

DROP TABLE IF EXISTS `tbl_bug_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bug_report` (
  `bug_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `bug_image1_id` int(11) NOT NULL,
  `reported_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bug_report`
--

LOCK TABLES `tbl_bug_report` WRITE;
/*!40000 ALTER TABLE `tbl_bug_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_bug_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cms_settings`
--

DROP TABLE IF EXISTS `tbl_cms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cms_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_set_name` varchar(100) NOT NULL,
  `cms_set_value` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cms_settings`
--

LOCK TABLES `tbl_cms_settings` WRITE;
/*!40000 ALTER TABLE `tbl_cms_settings` DISABLE KEYS */;
INSERT INTO `tbl_cms_settings` VALUES (1,'admin_logo','project/themes/default/images/saasframework_logo.png','2014-11-04 03:47:30'),(2,'admin_copyright','Â© Copyright ICARUS, 2018','2018-09-18 06:01:45'),(4,'admin_page_count','100','2018-10-03 13:37:04'),(5,'site_logo','Cmshelper::bindSiteLogo','2013-01-04 08:34:39');
/*!40000 ALTER TABLE `tbl_cms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contents`
--

DROP TABLE IF EXISTS `tbl_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contents` (
  `cnt_id` int(10) NOT NULL AUTO_INCREMENT,
  `cnt_title` varchar(255) DEFAULT NULL,
  `cnt_summary` text NOT NULL,
  `cnt_content` longtext,
  `cnt_ispage` tinyint(1) DEFAULT NULL,
  `cnt_alias` varchar(50) DEFAULT NULL,
  `cnt_published` int(2) DEFAULT NULL,
  `cnt_button_text` varchar(250) NOT NULL,
  `cnt_order` int(11) NOT NULL,
  `cnt_status` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`cnt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contents`
--

LOCK TABLES `tbl_contents` WRITE;
/*!40000 ALTER TABLE `tbl_contents` DISABLE KEYS */;
INSERT INTO `tbl_contents` VALUES (1,'Company Overview','<p><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">eaque\n ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">aspernatur\n aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione\n voluptatem sequi nesciunt.Sed ut perspiciatis unde omnis iste<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.</span><br></p>','<p><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Sed ut perspiciatis unde omnis iste<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore. </span></p><p><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\"><br></span></p><p><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.</span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">aspernatur\n aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione\n voluptatem sequi nesciunt.Sed ut perspiciatis unde omnis iste<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">eaque\n ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,<span class=\"Apple-converted-space\" style=\"box-sizing: border-box;\"> </span></span><span style=\"box-sizing: border-box; color: rgb(32, 32, 32); font-family: Poppins; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 300; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-align: center; background-color: rgb(255, 255, 255); float: none; display: inline !important;\"><br></span><br></p>',NULL,'company-overview',NULL,'Get Started Now',3,'Y');
/*!40000 ALTER TABLE `tbl_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_countries`
--

DROP TABLE IF EXISTS `tbl_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(64) NOT NULL DEFAULT '',
  `country_iso_code_2` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`),
  KEY `IDX_COUNTRY_NAME` (`country_name`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_countries`
--

LOCK TABLES `tbl_countries` WRITE;
/*!40000 ALTER TABLE `tbl_countries` DISABLE KEYS */;
INSERT INTO `tbl_countries` VALUES (1,'Afghanistan','AF'),(2,'Albania','AL'),(3,'Algeria','DZ'),(4,'American Samoa','AS'),(5,'Andorra','AD'),(6,'Angola','AO'),(7,'Anguilla','AI'),(8,'Antarctica','AQ'),(9,'Antigua and Barbuda','AG'),(10,'Argentina','AR'),(11,'Armenia','AM'),(12,'Aruba','AW'),(13,'Australia','AU'),(14,'Austria','AT'),(15,'Azerbaijan','AZ'),(16,'Bahamas','BS'),(17,'Bahrain','BH'),(18,'Bangladesh','BD'),(19,'Barbados','BB'),(20,'Belarus','BY'),(21,'Belgium','BE'),(22,'Belize','BZ'),(23,'Benin','BJ'),(24,'Bermuda','BM'),(25,'Bhutan','BT'),(26,'Bolivia','BO'),(27,'Bosnia and Herzegowina','BA'),(28,'Botswana','BW'),(29,'Bouvet Island','BV'),(30,'Brazil','BR'),(31,'British Indian Ocean Territory','IO'),(32,'Brunei Darussalam','BN'),(33,'Bulgaria','BG'),(34,'Burkina Faso','BF'),(35,'Burundi','BI'),(36,'Cambodia','KH'),(37,'Cameroon','CM'),(38,'Canada','CA'),(39,'Cape Verde','CV'),(40,'Cayman Islands','KY'),(41,'Central African Republic','CF'),(42,'Chad','TD'),(43,'Chile','CL'),(44,'China','CN'),(45,'Christmas Island','CX'),(46,'Cocos (Keeling) Islands','CC'),(47,'Colombia','CO'),(48,'Comoros','KM'),(49,'Congo','CG'),(50,'Cook Islands','CK'),(51,'Costa Rica','CR'),(52,'Cote D\'Ivoire','CI'),(53,'Croatia','HR'),(54,'Cuba','CU'),(55,'Cyprus','CY'),(56,'Czech Republic','CZ'),(57,'Denmark','DK'),(58,'Djibouti','DJ'),(59,'Dominica','DM'),(60,'Dominican Republic','DO'),(61,'East Timor','TP'),(62,'Ecuador','EC'),(63,'Egypt','EG'),(64,'El Salvador','SV'),(65,'Equatorial Guinea','GQ'),(66,'Eritrea','ER'),(67,'Estonia','EE'),(68,'Ethiopia','ET'),(69,'Falkland Islands (Malvinas)','FK'),(70,'Faroe Islands','FO'),(71,'Fiji','FJ'),(72,'Finland','FI'),(73,'France','FR'),(74,'France, Metropolitan','FX'),(75,'French Guiana','GF'),(76,'French Polynesia','PF'),(77,'French Southern Territories','TF'),(78,'Gabon','GA'),(79,'Gambia','GM'),(80,'Georgia','GE'),(81,'Germany','DE'),(82,'Ghana','GH'),(83,'Gibraltar','GI'),(84,'Greece','GR'),(85,'Greenland','GL'),(86,'Grenada','GD'),(87,'Guadeloupe','GP'),(88,'Guam','GU'),(89,'Guatemala','GT'),(90,'Guinea','GN'),(91,'Guinea-bissau','GW'),(92,'Guyana','GY'),(93,'Haiti','HT'),(94,'Heard and Mc Donald Islands','HM'),(95,'Honduras','HN'),(96,'Hong Kong','HK'),(97,'Hungary','HU'),(98,'Iceland','IS'),(99,'India','IN'),(100,'Indonesia','ID'),(101,'Iran (Islamic Republic of)','IR'),(102,'Iraq','IQ'),(103,'Ireland','IE'),(104,'Israel','IL'),(105,'Italy','IT'),(106,'Jamaica','JM'),(107,'Japan','JP'),(108,'Jordan','JO'),(109,'Kazakhstan','KZ'),(110,'Kenya','KE'),(111,'Kiribati','KI'),(112,'Korea, Democratic People\'s Republic of','KP'),(113,'Korea, Republic of','KR'),(114,'Kuwait','KW'),(115,'Kyrgyzstan','KG'),(116,'Lao People\'s Democratic Republic','LA'),(117,'Latvia','LV'),(118,'Lebanon','LB'),(119,'Lesotho','LS'),(120,'Liberia','LR'),(121,'Libyan Arab Jamahiriya','LY'),(122,'Liechtenstein','LI'),(123,'Lithuania','LT'),(124,'Luxembourg','LU'),(125,'Macau','MO'),(126,'Macedonia, The Former Yugoslav Republic of','MK'),(127,'Madagascar','MG'),(128,'Malawi','MW'),(129,'Malaysia','MY'),(130,'Maldives','MV'),(131,'Mali','ML'),(132,'Malta','MT'),(133,'Marshall Islands','MH'),(134,'Martinique','MQ'),(135,'Mauritania','MR'),(136,'Mauritius','MU'),(137,'Mayotte','YT'),(138,'Mexico','MX'),(139,'Micronesia, Federated States of','FM'),(140,'Moldova, Republic of','MD'),(141,'Monaco','MC'),(142,'Mongolia','MN'),(143,'Montserrat','MS'),(144,'Morocco','MA'),(145,'Mozambique','MZ'),(146,'Myanmar','MM'),(147,'Namibia','NA'),(148,'Nauru','NR'),(149,'Nepal','NP'),(150,'Netherlands','NL'),(151,'Netherlands Antilles','AN'),(152,'New Caledonia','NC'),(153,'New Zealand','NZ'),(154,'Nicaragua','NI'),(155,'Niger','NE'),(156,'Nigeria','NG'),(157,'Niue','NU'),(158,'Norfolk Island','NF'),(159,'Northern Mariana Islands','MP'),(160,'Norway','NO'),(161,'Oman','OM'),(162,'Pakistan','PK'),(163,'Palau','PW'),(164,'Panama','PA'),(165,'Papua New Guinea','PG'),(166,'Paraguay','PY'),(167,'Peru','PE'),(168,'Philippines','PH'),(169,'Pitcairn','PN'),(170,'Poland','PL'),(171,'Portugal','PT'),(172,'Puerto Rico','PR'),(173,'Qatar','QA'),(174,'Reunion','RE'),(175,'Romania','RO'),(176,'Russian Federation','RU'),(177,'Rwanda','RW'),(178,'Saint Kitts and Nevis','KN'),(179,'Saint Lucia','LC'),(180,'Saint Vincent and the Grenadines','VC'),(181,'Samoa','WS'),(182,'San Marino','SM'),(183,'Sao Tome and Principe','ST'),(184,'Saudi Arabia','SA'),(185,'Senegal','SN'),(186,'Seychelles','SC'),(187,'Sierra Leone','SL'),(188,'Singapore','SG'),(189,'Slovakia (Slovak Republic)','SK'),(190,'Slovenia','SI'),(191,'Solomon Islands','SB'),(192,'Somalia','SO'),(193,'South Africa','ZA'),(194,'South Georgia and the South Sandwich Islands','GS'),(195,'Spain','ES'),(196,'Sri Lanka','LK'),(197,'St. Helena','SH'),(198,'St. Pierre and Miquelon','PM'),(199,'Sudan','SD'),(200,'Suriname','SR'),(201,'Svalbard and Jan Mayen Islands','SJ'),(202,'Swaziland','SZ'),(203,'Sweden','SE'),(204,'Switzerland','CH'),(205,'Syrian Arab Republic','SY'),(206,'Taiwan','TW'),(207,'Tajikistan','TJ'),(208,'Tanzania, United Republic of','TZ'),(209,'Thailand','TH'),(210,'Togo','TG'),(211,'Tokelau','TK'),(212,'Tonga','TO'),(213,'Trinidad and Tobago','TT'),(214,'Tunisia','TN'),(215,'Turkey','TR'),(216,'Turkmenistan','TM'),(217,'Turks and Caicos Islands','TC'),(218,'Tuvalu','TV'),(219,'Uganda','UG'),(220,'Ukraine','UA'),(221,'United Arab Emirates','AE'),(222,'United Kingdom','GB'),(223,'United States','US'),(224,'United States Minor Outlying Islands','UM'),(225,'Uruguay','UY'),(226,'Uzbekistan','UZ'),(227,'Vanuatu','VU'),(228,'Vatican City State (Holy See)','VA'),(229,'Venezuela','VE'),(230,'Viet Nam','VN'),(231,'Virgin Islands (British)','VG'),(232,'Virgin Islands (U.S.)','VI'),(233,'Wallis and Futuna Islands','WF'),(234,'Western Sahara','EH'),(235,'Yemen','YE'),(236,'Yugoslavia','YU'),(237,'Zaire','ZR'),(238,'Zambia','ZM'),(239,'Zimbabwe','ZW');
/*!40000 ALTER TABLE `tbl_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_credit_cardinfo`
--

DROP TABLE IF EXISTS `tbl_credit_cardinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_credit_cardinfo` (
  `card_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `card_cvno` varchar(255) NOT NULL,
  `card_expmonth` varchar(10) NOT NULL,
  `card_expyear` varchar(10) NOT NULL,
  `card_lastpaid` datetime NOT NULL,
  `card_lastpay_status` varchar(30) NOT NULL COMMENT '1 -> payment success, others are failure',
  `card_status` int(2) NOT NULL COMMENT '0 -> inactive ,1 -> active card, 2 -> blocked, 3 -> rejected',
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_credit_cardinfo`
--

LOCK TABLES `tbl_credit_cardinfo` WRITE;
/*!40000 ALTER TABLE `tbl_credit_cardinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_credit_cardinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_credit_tracker`
--

DROP TABLE IF EXISTS `tbl_credit_tracker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_credit_tracker` (
  `ct_id` int(10) NOT NULL AUTO_INCREMENT,
  `smb_account_id` int(10) DEFAULT NULL,
  `ct_credit_amount` float DEFAULT NULL,
  `ct_credit_status` int(2) DEFAULT NULL,
  `ct_transact_id` varchar(50) DEFAULT NULL,
  `ct_created_on` datetime DEFAULT NULL,
  `ct_created_by` varchar(50) DEFAULT NULL,
  `ct_creditvalue` int(10) DEFAULT NULL,
  `ct_current_user_credit` int(10) DEFAULT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_credit_tracker`
--

LOCK TABLES `tbl_credit_tracker` WRITE;
/*!40000 ALTER TABLE `tbl_credit_tracker` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_credit_tracker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_feedbacks`
--

DROP TABLE IF EXISTS `tbl_feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_feedbacks` (
  `feedback_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(250) NOT NULL,
  `lastName` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `emailId` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` longtext NOT NULL,
  `feedback_date` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Feedback';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feedbacks`
--

LOCK TABLES `tbl_feedbacks` WRITE;
/*!40000 ALTER TABLE `tbl_feedbacks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_files`
--

DROP TABLE IF EXISTS `tbl_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_orig_name` varchar(255) DEFAULT NULL,
  `file_extension` varchar(10) DEFAULT NULL,
  `file_mime_type` varchar(50) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL COMMENT 'video/photo',
  `file_width` int(4) DEFAULT NULL,
  `file_height` int(4) DEFAULT NULL,
  `file_play_time` varchar(250) DEFAULT '0',
  `file_size` int(11) DEFAULT NULL,
  `file_path` text,
  `file_status` int(11) DEFAULT NULL,
  `file_title` varchar(255) DEFAULT NULL,
  `file_caption` text,
  `file_tmp_name` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(250) DEFAULT NULL,
  `random_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_files`
--

LOCK TABLES `tbl_files` WRITE;
/*!40000 ALTER TABLE `tbl_files` DISABLE KEYS */;
INSERT INTO `tbl_files` VALUES (1,'business-team.jpg','jpg','image/jpeg','',1920,1315,'0',476640,'7jtl-business-team.jpg',NULL,NULL,NULL,NULL,NULL,'0','1937317246_1'),(2,'business.jpg','jpg','image/jpeg','',1920,1226,'0',341580,'07h0-business.jpg',NULL,NULL,NULL,NULL,NULL,'0','1780379134_1'),(3,'office.jpg','jpg','image/jpeg','',1920,1315,'0',1228764,'xy84-office.jpg',NULL,NULL,NULL,NULL,NULL,'0','1382550071_1'),(4,'reading.jpg','jpg','image/jpeg','',1920,1315,'0',1113642,'bdb6-reading.jpg',NULL,NULL,NULL,NULL,NULL,'0','3551059568_1'),(5,'lion.jpg','jpg','image/jpeg','',1920,1315,'0',1642673,'faxy-lion.jpg',NULL,NULL,NULL,NULL,NULL,'0','262976160_1'),(6,'user2.jpg','jpg','image/jpeg','',226,226,'0',37223,'r6u7-user2.jpg',NULL,NULL,NULL,NULL,NULL,'0','842274089_1'),(7,'user2.jpg','jpg','image/jpeg','',226,226,'0',37223,'vzda-user2.jpg',NULL,NULL,NULL,NULL,NULL,'0','61663850_1'),(8,'odr1gy8tjbc.jpg','jpg','image/jpeg','',300,300,'',17315,'t5kf-odr1gy8tjbc.jpg',NULL,NULL,NULL,NULL,NULL,'','792687752_1'),(9,'product_icon_1.jpg','jpg','image/jpeg','',651,485,'',25132,'9xba-product_icon_1.jpg',NULL,NULL,NULL,NULL,NULL,'','1527661754_NaN'),(10,'product_icon_1.jpg','jpg','image/jpeg','',651,485,'',25132,'06un-product_icon_1.jpg',NULL,NULL,NULL,NULL,NULL,'','2413010940_NaN'),(11,'product_icon_1.jpg','jpg','image/jpeg','',651,485,'',25132,'13se-product_icon_1.jpg',NULL,NULL,NULL,NULL,NULL,'','1652135979_1'),(12,'product_icon_2.jpg','jpg','image/jpeg','',651,485,'',31520,'9ocq-product_icon_2.jpg',NULL,NULL,NULL,NULL,NULL,'','3170059008_1'),(13,'product_icon_3.jpg','jpg','image/jpeg','',651,485,'',25391,'iw37-product_icon_3.jpg',NULL,NULL,NULL,NULL,NULL,'','2757568258_1'),(14,'product_icon_4.jpg','jpg','image/jpeg','',651,485,'',128709,'4lpj-product_icon_4.jpg',NULL,NULL,NULL,NULL,NULL,'','676330446_1'),(15,'product_icon_2.jpg','jpg','image/jpeg','',651,485,'',31520,'xs7a-product_icon_2.jpg',NULL,NULL,NULL,NULL,NULL,'','1954914910_1'),(16,'product_icon_3.jpg','jpg','image/jpeg','',651,485,'',25391,'kbik-product_icon_3.jpg',NULL,NULL,NULL,NULL,NULL,'','2539939717_1'),(17,'product_icon_1.jpg','jpg','image/jpeg','',651,485,'',25132,'rlsf-product_icon_1.jpg',NULL,NULL,NULL,NULL,NULL,'','309302773_1'),(18,'product_icon_2.jpg','jpg','image/jpeg','',651,485,'',31520,'8j3h-product_icon_2.jpg',NULL,NULL,NULL,NULL,NULL,'','2344045348_1'),(19,'product_icon_3.jpg','jpg','image/jpeg','',651,485,'',25391,'b7w4-product_icon_3.jpg',NULL,NULL,NULL,NULL,NULL,'','3399095734_1'),(20,'product_icon_4.jpg','jpg','image/jpeg','',651,485,'',128709,'d8ut-product_icon_4.jpg',NULL,NULL,NULL,NULL,NULL,'','788038539_1'),(21,'20137220214130850-500x500.jpg','jpg','image/jpeg','',360,332,'',21246,'jnur-20137220214130850-500x500.jpg',NULL,NULL,NULL,NULL,NULL,'','3323706412_1'),(22,'Nylon-Lanyard-Strap.jpg','jpg','image/jpeg','',360,332,'',35894,'qfr7-Nylon-Lanyard-Strap.jpg',NULL,NULL,NULL,NULL,NULL,'','602889774_1'),(23,'TheSun.jpg','jpg','image/jpeg','',360,332,'',22015,'v046-TheSun.jpg',NULL,NULL,NULL,NULL,NULL,'','605772847_1'),(24,'20140303153222_43215.png','png','image/png','',360,332,'',107305,'x6x8-20140303153222_43215.png',NULL,NULL,NULL,NULL,NULL,'','3155523086_1'),(25,'6809ce44-4d40-458d-93a7-9c3ef4a06e77.jpg','jpg','image/jpeg','',360,332,'',20870,'bez5-6809ce44-4d40-458d-93a7-9c3ef4a06e77.jpg',NULL,NULL,NULL,NULL,NULL,'','3001544386_1'),(26,'t706cb.jpg','jpg','image/jpeg','',360,332,'',15721,'ykqv-t706cb.jpg',NULL,NULL,NULL,NULL,NULL,'','72054666_1'),(27,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'m46j-user.jpg',NULL,NULL,NULL,NULL,NULL,'','2684631037_1'),(28,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'t5sw-user.jpg',NULL,NULL,NULL,NULL,NULL,'','2193422729_1'),(29,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'a6su-user.jpg',NULL,NULL,NULL,NULL,NULL,'','3346051952_1'),(30,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'ogrk-user.jpg',NULL,NULL,NULL,NULL,NULL,'','157737471_1'),(31,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'3p30-user.jpg',NULL,NULL,NULL,NULL,NULL,'','3134183999_1'),(32,'user2.jpg','jpg','image/jpeg','',226,226,'',37223,'s9nt-user2.jpg',NULL,NULL,NULL,NULL,NULL,'','3536548356_1'),(33,'user2.jpg','jpg','image/jpeg','',226,226,'',37223,'gkr3-user2.jpg',NULL,NULL,NULL,NULL,NULL,'','3298354087_1'),(34,'design.png','png','image/png','',48,48,'',16572,'56vp-design.png',NULL,NULL,NULL,NULL,NULL,'','3458693476_NaN'),(35,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'f0dg-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1679403516_1'),(36,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'vsq5-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1201164772_1'),(37,'user2.jpg','jpg','image/jpeg','',226,226,'',37223,'lp36-user2.jpg',NULL,NULL,NULL,NULL,NULL,'','2684173013_1'),(38,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'3rq0-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1359347065_1'),(39,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'0ipg-user.jpg',NULL,NULL,NULL,NULL,NULL,'','3392913719_1'),(40,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'sp89-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1442265011_1'),(41,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'sz5x-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1376547478_1'),(42,'user2.jpg','jpg','image/jpeg','',226,226,'',37223,'7bl8-user2.jpg',NULL,NULL,NULL,NULL,NULL,'','2045645206_1'),(43,'','','','',0,0,'',0,'mxc9-',NULL,NULL,NULL,NULL,NULL,'','2045645206_1'),(44,'user2.jpg','jpg','image/jpeg','',226,226,'',37223,'a5wi-user2.jpg',NULL,NULL,NULL,NULL,NULL,'','3261085101_1'),(45,'user.jpg','jpg','image/jpeg','',226,226,'',24970,'ge3a-user.jpg',NULL,NULL,NULL,NULL,NULL,'','1558773726_1'),(46,'pic-1-1.jpg','jpg','image/jpeg','',226,226,'',21501,'akm8-pic-1-1.jpg',NULL,NULL,NULL,NULL,NULL,'','1805994812_1'),(47,'pic-1-1.jpg','jpg','image/jpeg','',226,226,'',21501,'r49t-pic-1-1.jpg',NULL,NULL,NULL,NULL,NULL,'','3566341895_1'),(48,'bannerxx.jpg','jpg','image/jpeg','',1350,530,'',51828,'d5n1-bannerxx.jpg',NULL,NULL,NULL,NULL,NULL,'','615707332_1'),(49,'banner.jpg','jpg','image/jpeg','',1350,530,'',99711,'uaxh-banner.jpg',NULL,NULL,NULL,NULL,NULL,'','2290959326_1'),(50,'bannerxx.jpg','jpg','image/jpeg','',1350,530,'',51828,'jvtg-bannerxx.jpg',NULL,NULL,NULL,NULL,NULL,'','108188086_1'),(51,'uber-clone-banner.png','png','image/png','',1350,530,'',46309,'2g39-uber-clone-banner.png',NULL,NULL,NULL,NULL,NULL,'','956323541_1'),(52,'pic-1-1.jpg','jpg','image/jpeg','',226,226,'',21501,'lwd7-pic-1-1.jpg',NULL,NULL,NULL,NULL,NULL,'','372993723_1'),(53,'bannerxx.jpg','jpg','image/jpeg','',1350,530,'',51828,'djwa-bannerxx.jpg',NULL,NULL,NULL,NULL,NULL,'','47642369_1'),(54,'190x185.jpeg','jpeg','image/jpeg','',190,185,'',7257,'0nbk-190x185.jpeg',NULL,NULL,NULL,NULL,NULL,'','3544680595_1'),(55,'logo4.jpg','jpg','image/jpeg','',450,450,'',37425,'2sl0-logo4.jpg',NULL,NULL,NULL,NULL,NULL,'','2285499874_1'),(56,'restaurant logo1.png','png','image/png','',800,600,'',9719,'bmc5-restaurant logo1.png',NULL,NULL,NULL,NULL,NULL,'','2532967037_1'),(57,'driver1.jpg','jpg','image/jpeg','',225,225,'',6828,'p1e3-driver1.jpg',NULL,NULL,NULL,NULL,NULL,'','741858139_1'),(58,'sample banner.jpg','jpg','image/jpeg','',480,160,'',22238,'38ln-sample banner.jpg',NULL,NULL,NULL,NULL,NULL,'','88379278_1'),(59,'banneronlineshopping.jpg','jpg','image/jpeg','',1300,553,'',93145,'s1jg-banneronlineshopping.jpg',NULL,NULL,NULL,NULL,NULL,'','2792426165_1'),(60,'profile1.jpg','jpg','image/jpeg','',1600,1067,'',109980,'s5me-profile1.jpg',NULL,NULL,NULL,NULL,NULL,'','521623680_1'),(61,'profile1.jpg','jpg','image/jpeg','',1600,1067,'',109980,'e3kc-profile1.jpg',NULL,NULL,NULL,NULL,NULL,'','1537529004_1'),(62,'profile2.jpg','jpg','image/jpeg','',1200,800,'',101319,'aswr-profile2.jpg',NULL,NULL,NULL,NULL,NULL,'','2331040312_1'),(63,'profile2.png','png','image/png','',500,569,'',112180,'61c2-profile2.png',NULL,NULL,NULL,NULL,NULL,'','1814158044_1'),(64,'b1.jpg','jpg','image/jpeg','',2000,1000,'',230033,'t7h2-b1.jpg',NULL,NULL,NULL,NULL,NULL,'','35460550_1'),(65,'driver2.png','png','image/png','',200,203,'',3975,'xsyh-driver2.png',NULL,NULL,NULL,NULL,NULL,'','1248453521_1'),(66,'driver2.png','png','image/png','',200,203,'',3975,'qj3c-driver2.png',NULL,NULL,NULL,NULL,NULL,'','965735121_1'),(67,'driver2.png','png','image/png','',200,203,'',3975,'cm5r-driver2.png',NULL,NULL,NULL,NULL,NULL,'','3342727325_1'),(68,'ban3multicart.jpeg','jpeg','image/jpeg','',340,148,'',15156,'rs7p-ban3multicart.jpeg',NULL,NULL,NULL,NULL,NULL,'','3469627483_1'),(69,'f1.jpg','jpg','image/jpeg','',275,183,'',9309,'a4xh-f1.jpg',NULL,NULL,NULL,NULL,NULL,'','3228654261_1'),(70,'image2.jpg','jpg','image/jpeg','',1000,700,'',89266,'7q4v-image2.jpg',NULL,NULL,NULL,NULL,NULL,'','95810601_1'),(71,'driver1.jpg','jpg','image/jpeg','',225,225,'',6828,'9xhd-driver1.jpg',NULL,NULL,NULL,NULL,NULL,'','3352777112_1'),(72,'driver1.jpg','jpg','image/jpeg','',225,225,'',6828,'atj6-driver1.jpg',NULL,NULL,NULL,NULL,NULL,'','715144040_1'),(73,'aloo3.jpg','jpg','image/jpeg','',292,173,'',14409,'bmcz-aloo3.jpg',NULL,NULL,NULL,NULL,NULL,'','3452561530_1'),(74,'aloo3.jpg','jpg','image/jpeg','',292,173,'',14409,'jedm-aloo3.jpg',NULL,NULL,NULL,NULL,NULL,'','1419679635_1'),(75,'team-restaurant-workers-stand-side-260nw-593541629.jpg','jpg','image/jpeg','',549,280,'',40265,'fiop-team-restaurant-workers-stand-side-260nw-593541629.jpg',NULL,NULL,NULL,NULL,NULL,'','1240384116_1'),(76,'750.jpg','jpg','image/jpeg','',700,350,'',37943,'wzi6-750.jpg',NULL,NULL,NULL,NULL,NULL,'','1394850359_1'),(77,'gif618.gif','gif','image/gif','',618,618,'',160827,'6t4g-gif618.gif',NULL,NULL,NULL,NULL,NULL,'','2195513687_1'),(78,'bmp1.png','png','image/png','',512,512,'',37804,'yn5z-bmp1.png',NULL,NULL,NULL,NULL,NULL,'','3522936245_1'),(79,'bmo1600.jpeg','jpeg','image/jpeg','',1600,1200,'',139438,'hgbu-bmo1600.jpeg',NULL,NULL,NULL,NULL,NULL,'','1580372063_1'),(80,'jpg.jpg','jpg','image/jpeg','',271,186,'',30529,'8a2z-jpg.jpg',NULL,NULL,NULL,NULL,NULL,'','2872453510_1'),(81,'cropped-Web-banner.bmp','bmp','image/bmp','',739,188,'',417414,'p53y-cropped-Web-banner.bmp',NULL,NULL,NULL,NULL,NULL,'','880309109_1'),(82,'team-restaurant-workers-stand-side-260nw-593541629.jpg','jpg','image/jpeg','',549,280,'',40265,'ze3n-team-restaurant-workers-stand-side-260nw-593541629.jpg',NULL,NULL,NULL,NULL,NULL,'','201141313_1'),(83,'team-restaurant-workers-stand-side-260nw-593541629.jpg','jpg','image/jpeg','',549,280,'',40265,'plg3-team-restaurant-workers-stand-side-260nw-593541629.jpg',NULL,NULL,NULL,NULL,NULL,'','212766328_1'),(84,'gif2.gif','gif','image/gif','',1500,600,'',796159,'pnwp-gif2.gif',NULL,NULL,NULL,NULL,NULL,'','2364448085_1'),(85,'jpeg.jpeg','jpeg','image/jpeg','',1600,1200,'',139438,'1zah-jpeg.jpeg',NULL,NULL,NULL,NULL,NULL,'','2957005252_1'),(86,'profile1.jpg','jpg','image/jpeg','',1600,1067,'',109980,'j73l-profile1.jpg',NULL,NULL,NULL,NULL,NULL,'','1229553207_1'),(87,'bmp.bmp','bmp','image/bmp','',225,225,'',152154,'2pix-bmp.bmp',NULL,NULL,NULL,NULL,NULL,'','3181866151_1'),(88,'png11.png','png','image/png','',355,142,'',4239,'wl7n-png11.png',NULL,NULL,NULL,NULL,NULL,'','1939544118_1'),(89,'gif2.gif','gif','image/gif','',1500,600,'',796159,'0hb7-gif2.gif',NULL,NULL,NULL,NULL,NULL,'','728027511_1'),(90,'content.png','png','image/png','',1063,493,'',34738,'mklo-content.png',NULL,NULL,NULL,NULL,NULL,'','1954155562_1'),(91,'business dashboard.png','png','image/png','',1143,415,'',22385,'7gbc-business dashboard.png',NULL,NULL,NULL,NULL,NULL,'','2042076695_1'),(92,'750.jpg','jpg','image/jpeg','',700,350,'',37943,'4xld-750.jpg',NULL,NULL,NULL,NULL,NULL,'','2974404200_1'),(93,'driver2.png','png','image/png','',200,203,'',3975,'2oc8-driver2.png',NULL,NULL,NULL,NULL,NULL,'','3088671154_1'),(94,'profile2.jpg','jpg','image/jpeg','',1200,800,'',101319,'xhak-profile2.jpg',NULL,NULL,NULL,NULL,NULL,'','3601378322_1');
/*!40000 ALTER TABLE `tbl_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lookup`
--

DROP TABLE IF EXISTS `tbl_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lookup` (
  `nLookUp_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vLookUp_Name` varchar(100) NOT NULL DEFAULT '',
  `vLookUp_Value` text NOT NULL,
  `settinglabel` varchar(250) NOT NULL,
  `groupLabel` varchar(50) NOT NULL,
  `helptext` varchar(255) NOT NULL,
  `type` varchar(256) NOT NULL,
  `parent_settingfield` varchar(256) NOT NULL,
  `display_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`nLookUp_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lookup`
--

LOCK TABLES `tbl_lookup` WRITE;
/*!40000 ALTER TABLE `tbl_lookup` DISABLE KEYS */;
INSERT INTO `tbl_lookup` VALUES (8,'site_surl','http://localhost/icarus-project/','Secure site url','General','','','',3),(10,'site_url','http://localhost/icarus-project/','Site url','General','','','',2),(11,'sitename','Icarus Frameworks','Site name','General','','','',1),(69,'addressfromemail','admin@domain.com','','','','','',0),(70,'addressfromemailname','Icarus','','','','','',0),(71,'addressreplyemail','admin@domain.com','','','','','',0),(72,'addressreplyemailname','admin@domain.com','','','','','',0),(1,'admin_email','admin@domain.com','Admin e-mail','General','','','',4),(115,'groupLabelOrder','General,Advanced,Payment','','','','','',0),(116,'sitelogo','oqgjdaaqvxr.png','Site Logo','General','','file','',5),(21,'EnableSMTP','false','Enable SMTP','Advanced','','checkbox','',100),(22,'SMTPHost','domain.com','SMTP Host','Advanced','','','EnableSMTP',100),(23,'SMTPUsername','admin@domain.com','SMTP Username','Advanced','','','EnableSMTP',100),(24,'SMTPPassword','aW~iC%bO68G4','SMTP Password','Advanced','','password','EnableSMTP',100),(25,'SMTPPort','port number','SMTP PORT','Advanced','','','EnableSMTP',100),(26,'SSLEnabled','false','SSL Enabled Or Not','Advanced','','checkbox','',100),(117,'bg_color','#60d0f0','Theme Color','General','','color','',3),(118,'social_media_enabled','true','Enable Social Media Links?','General','Social Media Needed on Footer','checkbox','',6),(119,'footer_links_enabled','true','Enable Footer Links?','General','Check whether footer links needed or not','checkbox','',7),(120,'homepage_slider_enabled','true','Enable Homepage Slider?','General','Check whether homepage slider needed or not','checkbox','',8),(121,'site_address','Armia Systems Inc. 1020 Milwakee Ave, \n#245 Deerfield IL 60015 US','Site Address','General','Address of the site office','textarea','',10),(122,'site_phone','(312) 423-6728, 61 525 240 401','Site Phone','General','Phone number for the office','','',11),(123,'site_email','admin@domain.com','Site Email','General','Email address of the site office','','',12),(124,'facebook_url','https://www.facebook.com','Facebook Url','General','Facebook Url','','',13),(125,'twitter_url','https://twitter.com/','Twitter Url','General','Twitter Url','','',14),(126,'instagram_url','https://www.instagram.com/?hl=en','Instagram Url','General','Instagram Url','','',15),(127,'googleplus_url','https://plus.google.com/discover','Google Plus Url','General','Google Plus Url','','',17),(128,'frontend_perpagesize','12','Front end page size','General','Front end page size','','',16),(129,'contact_address','true','Contact Address','General','Address for Contact','textarea','',18),(130,'contact_phone','+201 126 216 88,     +201 126 216 88','Contact Phone','General','Phone number to contact','','',19),(131,'contact_email','admin@domain.com','Contact Email','General','Email address to contact','','',20),(132,'skype_address','oscend.live','Skype Contact Address','General','Address to contact via Skype','','',21),(133,'testimonial_enabled','true','Enable Testimonial?','General','Check whether testimonial needed or not','checkbox','',9),(134,'banner_button1_label','Get Start Now','Label for Button-1 on Homepage Banner','Advanced','','','',100),(135,'banner_button1_alias','about','Alias for Button-1 on Homepage Banner','Advanced','','','',100),(136,'banner_button2_label','Contact Us','Label for Button-2 on Homepage Banner','Advanced','','','',100),(137,'banner_button2_alias','contact','Alias for Button-2 on Homepage Banner','Advanced','','','',100),(138,'banner_button3_label','','Label for Button-3 on Homepage Banner','Advanced','','','',100),(139,'banner_button3_alias','','Alias for Button-3 on Homepage Banner','Advanced','','','',100),(140,'contact_last_name','true','Do we need Last name field for Contact form?','Advanced','','checkbox','',100),(141,'contact_address','true','Do we need Address field for Contact form?','Advanced','','checkbox','',100),(142,'contact_phone_number','true','Do we need Phone number field for Contact form?','Advanced','','checkbox','',100),(143,'contact_city','true','Do we need City field for Contact form?','Advanced','','checkbox','',100),(144,'contact_country','true','Do we need Country field for Contact form?','Advanced','','checkbox','',100);
/*!40000 ALTER TABLE `tbl_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lookup_cms`
--

DROP TABLE IF EXISTS `tbl_lookup_cms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lookup_cms` (
  `nLookUp_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `settingfield` varchar(100) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `settinglabel` varchar(250) NOT NULL,
  `groupLabel` varchar(50) NOT NULL,
  `type` varchar(256) NOT NULL,
  `parent_settingfield` varchar(256) NOT NULL,
  `display_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`nLookUp_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lookup_cms`
--

LOCK TABLES `tbl_lookup_cms` WRITE;
/*!40000 ALTER TABLE `tbl_lookup_cms` DISABLE KEYS */;
INSERT INTO `tbl_lookup_cms` VALUES (1,'sitename','ICARUS Frameworks','Site Name','General','','',1),(2,'site_surl','https://domain.com','Secure URL','General','','',2),(3,'site_url','domian.com','Site URL','General','','',2),(4,'admin_email','admin@gmail.com','Admin Email','General','','',5),(5,'addressfromemail','admin@domain.com','addressfromemail','','','',1),(6,'addressfromemailname','Admin','addressfromemailname','','','',1),(7,'addressreplyemail','admin@domain.com','addressreplyemail','','','',1),(8,'addressreplyemailname','domain.com','addressreplyemailname','','','',1),(9,'metatagKey','ICARUS Framework','Default Meta Keywords','General','textarea','',10),(10,'metatagDes','ICARUS Framework','Default Meta Description','General','textarea','',12),(11,'metaTitle','ICARUS Framework','Default Page/Meta Title','General','','',11),(12,'EnableSMTP','1','Enable SMTP','Advanced','checkbox','',100),(13,'SMTPHost','admin.host.com','SMTP Host','Advanced','','EnableSMTP',100),(14,'SMTPUsername','admin@host.com','SMTP Username','Advanced','','EnableSMTP',100),(15,'SMTPPassword','password','SMTP Password','Advanced','password','EnableSMTP',100),(16,'SMTPPort','port number','SMTP PORT','Advanced','','EnableSMTP',100),(17,'SSLEnabled','1','SSL Enabled Or Not','Advanced','checkbox','',100),(18,'one_credit_value','10','Credit value for $1','Payment','','',1),(19,'vauthorize_loginid','cnpdev3623','Authorize.Net Login Id','Payment','','',2),(20,'vauthorize_transkey','u6FxFKGcJANf8pKL','Authorize.Net Transaction Key','Payment','','',3),(21,'vauthorize_email','simi.nazar@armiasystems.com','Authorize.Net Email','Payment','','',4),(22,'vauthorize_test_mode','0','Enable Authorize.Net  Test Mode','Payment','checkbox','',5),(24,'groupLabelOrder','General,Advanced,Payment','','','','',0),(23,'sitelogo','nfmslnrnmkd.png','Site Logo','General','file','',6);
/*!40000 ALTER TABLE `tbl_lookup_cms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mail_template`
--

DROP TABLE IF EXISTS `tbl_mail_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mail_template` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `mail_template_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `mail_template_sub` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `mail_template_body` text COLLATE latin1_general_ci NOT NULL,
  `mail_template_status` smallint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `test` (`id`),
  FULLTEXT KEY `mail_template_title` (`mail_template_sub`,`mail_template_body`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='templates for all emails sent out from system';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mail_template`
--

LOCK TABLES `tbl_mail_template` WRITE;
/*!40000 ALTER TABLE `tbl_mail_template` DISABLE KEYS */;
INSERT INTO `tbl_mail_template` VALUES (9,'appregister-admin','{SITE_NAME} - A new user has been registered ','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi Admin </h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \">A new user has been registerd with Ipool. <br>\r\n                                    The details are as follows.<br>\r\n                                    <br>\r\n                                     Application Id&nbsp;&nbsp;&nbsp; : {APPID} <strong><br>\r\n                                    </strong> Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {USERNAME}<br>\r\n                                    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : \r\n {EMAIL}</p>\r\n                                    </td>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                </tr>\r\n                                \r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                  <td>                                   {SIGNATURE}</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n',1,'2018-02-08 10:39:24'),(1,'mailcontainer','Mail Container','<table width=\"600\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"border:1px solid #ccc; background-color:#cccccc; \">\r\n    <tbody>\r\n        \r\n        <tr>\r\n\r\n            <td width=\"586\">\r\n            <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td height=\"56\"  >\r\n                        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"  style=\"background:#8354ED\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\" height=\"80\">&nbsp;</td>\r\n                                    <td width=\"37%\">{SITE_LOGO}</td>\r\n                                    <td width=\"61%\">\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#CCCCCC; text-align:right; padding:0 15px 0 0; \">{DATE}</p>                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>                        </td>\r\n                    </tr>\r\n                    \r\n                    \r\n                    <tr>\r\n                        <td>{MAIL_BODY}</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>\r\n                        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"background:#8354ED\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td height=\"30\"  >\r\n                                  <p style=\"color:#CCC; font-family:Arial, Helvetica, sans-serif; font-size:12px; padding:0 0 0 15px; \"> {COPYRIGHT}</p>                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>                        </td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>            </td>\r\n\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>&nbsp;</p>',1,'2018-03-07 08:30:09'),(36,'app_userregistration','{SITE_NAME} -  Your Account Details','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {firstName} ,</h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \">Thanks for registering with iPool APP. <br>\r\n                                    The details are as follows.<br>\r\n                                  \r\n                                    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : \r\n {email}<br>\r\n Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {password}<br>\r\n </p>\r\n                                    </td>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                </tr>\r\n                                \r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                  <td>                                   {SIGNATURE}</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n',1,'2018-04-16 12:54:45'),(37,'web_place_registration','{SITE_NAME} -  Your Account Details','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {FNAME} ,</h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \">Thanks for registering with iPool Place. <br>\r\n                                    The details are as follows.<br>\r\n                                  \r\n                                    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : \r\n {EMAIL}<br>\r\n Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {PASSWORD}<br>\r\n </p>\r\n                                    </td>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                </tr>\r\n                                \r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                  <td>                                   {SIGNATURE}</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                    <td>&nbsp;</td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n',1,'2018-04-16 12:54:13'),(38,'place_registration_admin','{SITE_NAME} - A place manager has been registered ','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                            <tbody>\n                                <tr>\n                                    <td width=\"2%\">&nbsp;</td>\n                                    <td width=\"97%\">\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi Admin </h3>\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \">A new user has been registerd with Ipool. <br>\n                                    The details are as follows.<br>\n                                    <br>\n\n                                    </strong> Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {NAME}<br>\n                                    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : \n {EMAIL}</p>\n                                    </td>\n                                    <td width=\"2%\">&nbsp;</td>\n                                </tr>\n                                \n                                <tr>\n                                    <td>&nbsp;</td>\n                                    <td>&nbsp;</td>\n                                    <td>&nbsp;</td>\n                                </tr>\n                                <tr>\n                                    <td>&nbsp;</td>\n                                  <td>                                   {SIGNATURE}</td>\n                                    <td>&nbsp;</td>\n                                </tr>\n                                <tr>\n                                    <td>&nbsp;</td>\n                                    <td>&nbsp;</td>\n                                    <td>&nbsp;</td>\n                                </tr>\n                            </tbody>\n                        </table>\n',1,'2018-04-13 12:06:29'),(35,'web_club_resetPassword','{SITE_NAME} - Reset Password','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {FIRSTNAME}</h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \"> You have successfully changed your password. Your new password is <b>{PASSWORD_NEW}</b></td>\r\n								                </tr>	                             \r\n                              <tr><td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">{SIGNATURE}</td></tr>\r\n                            </tbody>\r\n                        </table>\r\n\r\n\r\n\r\n\r\n',1,'2018-03-07 06:48:27'),(32,'app_forgotpasswordemail','{SITE_NAME} - Reset Password','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                            <tbody>\n                                <tr>\n                                    <td width=\"2%\">&nbsp;</td>\n                                    <td width=\"97%\">\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {FIRSTNAME}</h3>\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \"> You have successfully changed your password. Your new password is <b>{PASSWORD_NEW}</b></td>\n								                </tr>	                             \n                              <tr><td width=\"2%\">&nbsp;</td>\n                                    <td width=\"97%\">{SIGNATURE}</td></tr>\n                            </tbody>\n                        </table>\n\n\n\n\n',1,'2018-02-08 10:38:34'),(33,'app_activationmail','{SITE_NAME} - Confirm Your Account','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {FIRSTNAME}</h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \"> Please confirm your account by clicking <a href=\"{BASE_URL}index/registerconfirm?key={KEY}&id={ID}\">here</a></b></td>\r\n								                </tr>	                             \r\n                              <tr><td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">{SIGNATURE}</td></tr>\r\n                            </tbody>\r\n                        </table>\r\n\r\n\r\n\r\n\r\n',1,'2018-02-08 10:38:46'),(34,'app_emailchange','{SITE_NAME} - Update Email Id','<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">\r\n                                    <h3 style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333333; font-weight:normal; margin:5px 0 5px 0; \">Hi {FIRSTNAME} </h3>\r\n                                    <p style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; \"> To Update your email please click <a href=\"{BASE_URL}index/activate?ekey={EKEY}&id={ID}&em={EMAIL}\">here</a></b></td>\r\n								                </tr>	                             \r\n                              <tr><td width=\"2%\">&nbsp;</td>\r\n                                    <td width=\"97%\">{SIGNATURE}</td></tr>\r\n                            </tbody>\r\n                        </table>\r\n\r\n\r\n\r\n\r\n',1,'2018-02-08 10:38:55');
/*!40000 ALTER TABLE `tbl_mail_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_metatags`
--

DROP TABLE IF EXISTS `tbl_metatags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_metatags` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `pagename` varchar(255) DEFAULT NULL,
  `pageurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_metatags`
--

LOCK TABLES `tbl_metatags` WRITE;
/*!40000 ALTER TABLE `tbl_metatags` DISABLE KEYS */;
INSERT INTO `tbl_metatags` VALUES (1,'Welcome to Home Page - ICARUS Framework','Home page, ICARUS, Framework','Lorem ipsum dolor sit amet, consectetur adipiscing elit','Home Page','home'),(2,'Services - ICARUS Framework','Services, ICARUS, Framework','Lorem ipsum dolor sit amet, consectetur adipiscing elit','Services','services'),(3,'Products - ICARUS Framework','Products, ICARUS, Framework','Lorem ipsum dolor sit amet, consectetur adipiscing','Products','products');
/*!40000 ALTER TABLE `tbl_metatags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_newsletter_subscribers`
--

DROP TABLE IF EXISTS `tbl_newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_newsletter_subscribers` (
  `vSubscriberId` bigint(11) NOT NULL AUTO_INCREMENT,
  `vEmail` varchar(250) NOT NULL,
  `vStatus` enum('Y','N') NOT NULL,
  `vJoinedOn` datetime NOT NULL,
  PRIMARY KEY (`vSubscriberId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_newsletter_subscribers`
--

LOCK TABLES `tbl_newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `tbl_newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_newsletters`
--

DROP TABLE IF EXISTS `tbl_newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_newsletters` (
  `vNewsletterId` bigint(11) NOT NULL AUTO_INCREMENT,
  `vSubject` varchar(500) NOT NULL,
  `vContent` longtext NOT NULL,
  `vSendDate` date NOT NULL,
  `vSendStatus` enum('Yes','No') NOT NULL,
  `vStatus` enum('Y','N') NOT NULL,
  `vCreatedOn` datetime NOT NULL,
  `vLastUpdatedOn` datetime NOT NULL,
  PRIMARY KEY (`vNewsletterId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Newsletter contents';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_newsletters`
--

LOCK TABLES `tbl_newsletters` WRITE;
/*!40000 ALTER TABLE `tbl_newsletters` DISABLE KEYS */;
INSERT INTO `tbl_newsletters` VALUES (1,'Newsletter dated on September 14','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis \nmolestie   ultricies faucibus. Integer convallis ullamcorper dolor, at \nscelerisque   velit volutpat in. Nunc vel nulla nulla. Quisque ornare \nmolestie   imperdiet. Sed adipiscing imperdiet orci, in laoreet erat \nrhoncus ut.   Proin suscipit vestibulum neque in cursus. Sed volutpat \nlaoreet justo,   ac sagittis massa ornare non. Aliquam elit nunc, luctus\n varius turpis   non, tempus ornare erat. Nunc luctus dapibus metus, a \ndapibus tellus.   Maecenas feugiat molestie justo, eu posuere leo \nhendrerit at.</p>   <p>Vestibulum accumsan metus tempor, rutrum orci ut,\n euismod felis. Etiam   pretium augue purus, ac tincidunt arcu \ncondimentum feugiat. In blandit   risus eu nulla facilisis euismod. Nam \nornare scelerisque neque, vel   volutpat nibh adipiscing eget. \nPellentesque at metus ut purus pretium   vestibulum vitae non purus. \nNulla sollicitudin lorem nec ligula mattis   iaculis. Aenean eget \npharetra arcu. Etiam aliquam neque ac tellus mollis   tempor. Vivamus \nullamcorper lobortis laoreet. Duis vitae erat ipsum.   Etiam sit amet \nerat nibh. Mauris tempor ullamcorper commodo. Morbi vel   tristique \ntellus. Aliquam vehicula placerat nunc laoreet tempor.</p>   <p>Nulla \nviverra arcu eget faucibus faucibus. Donec dapibus sit amet tellus   at \nauctor. Nunc sed feugiat lorem, non rhoncus eros. Sed tempus dolor   nec\n elit eleifend imperdiet in non elit. Cum sociis natoque penatibus et   \nmagnis dis parturient montes, nascetur ridiculus mus. Etiam rutrum,   \npurus non porta malesuada, lorem sem mollis turpis, at commodo dolor sem\n   vestibulum est. Sed accumsan vel dui at aliquet.</p>   <p>Sed blandit\n at elit in viverra. Morbi commodo sed orci nec vehicula.   Suspendisse \nvarius leo vel purus pharetra sodales. Curabitur varius sed   arcu sed \nfringilla. Curabitur a blandit orci. Quisque sollicitudin   vulputate \nvenenatis. Vestibulum egestas rhoncus elit, quis condimentum   erat. \nPellentesque a eros quis felis laoreet fermentum a vitae elit.   \nCurabitur vel libero erat.</p>   <p>Donec in quam urna. Proin euismod \nlorem ante, non volutpat mauris   aliquam ac. Nullam vitae sodales \njusto. Sed nec porta metus. In eu   imperdiet neque, in ornare est. \nNullam feugiat viverra mauris vitae   ullamcorper. Proin pulvinar erat \negestas ante tincidunt varius. Vivamus   non lacinia quam.&nbsp;</p>','2018-09-14','Yes','Y','2018-09-14 08:10:01','2018-09-14 08:10:01'),(2,'Newsletter dated on September 19','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis molestie ultricies faucibus. Integer convallis ullamcorper dolor, at scelerisque velit volutpat in. Nunc vel nulla nulla. Quisque ornare molestie imperdiet. Sed adipiscing imperdiet orci, in laoreet erat rhoncus ut. Proin suscipit vestibulum neque in cursus. Sed volutpat laoreet justo, ac sagittis massa ornare non. Aliquam elit nunc, luctus varius turpis non, tempus ornare erat. Nunc luctus dapibus metus, a dapibus tellus. Maecenas feugiat molestie justo, eu posuere leo hendrerit at.</p><p>Vestibulum accumsan metus tempor, rutrum orci ut, euismod felis. Etiam pretium augue purus, ac tincidunt arcu condimentum feugiat. In blandit risus eu nulla facilisis euismod. Nam ornare scelerisque neque, vel volutpat nibh adipiscing eget. Pellentesque at metus ut purus pretium vestibulum vitae non purus. Nulla sollicitudin lorem nec ligula mattis iaculis. Aenean eget pharetra arcu. Etiam aliquam neque ac tellus mollis tempor. Vivamus ullamcorper lobortis laoreet. Duis vitae erat ipsum. Etiam sit amet erat nibh. Mauris tempor ullamcorper commodo. Morbi vel tristique tellus. Aliquam vehicula placerat nunc laoreet tempor.</p>','2018-09-19','No','Y','2018-09-17 13:40:07','2018-09-17 13:40:07'),(7,'dss','sdfd','2018-09-28','No','Y','2018-09-27 10:19:16','2018-09-27 10:19:16'),(8,'careers','<div><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\">dfgdg<br></p></div>','2018-10-19','No','Y','2018-10-09 10:55:53','2018-10-09 10:55:53'),(9,'sdf','dfdaa','2018-10-13','No','Y','2018-10-09 10:55:32','2018-10-09 10:55:32');
/*!40000 ALTER TABLE `tbl_newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_details`
--

DROP TABLE IF EXISTS `tbl_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_details` (
  `od_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT NULL,
  `od_item_description` varchar(255) DEFAULT NULL,
  `od_item_amount` float DEFAULT NULL,
  `od_item_qty` int(10) DEFAULT NULL,
  `od_created_on` datetime DEFAULT NULL,
  `od_created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_details`
--

LOCK TABLES `tbl_order_details` WRITE;
/*!40000 ALTER TABLE `tbl_order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orders`
--

DROP TABLE IF EXISTS `tbl_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orders` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `smb_account_id` int(10) DEFAULT NULL,
  `order_type` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `order_total` float DEFAULT NULL,
  `subscription_id` int(10) DEFAULT NULL,
  `transact_id` varchar(50) DEFAULT NULL,
  `order_status` int(10) DEFAULT NULL,
  `order_created_on` datetime DEFAULT NULL,
  `order_created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orders`
--

LOCK TABLES `tbl_orders` WRITE;
/*!40000 ALTER TABLE `tbl_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_phonenumbers`
--

DROP TABLE IF EXISTS `tbl_phonenumbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_phonenumbers` (
  `ph_id` int(10) NOT NULL AUTO_INCREMENT,
  `ph_number` varchar(20) DEFAULT NULL,
  `ph_appid` int(10) NOT NULL DEFAULT '0',
  `ph_fancy` tinyint(2) DEFAULT NULL,
  `ph_status` tinyint(2) DEFAULT NULL COMMENT '1-> active , 0-> inactive, 2-> booked',
  `ph_bookdate` datetime DEFAULT NULL,
  `ph_expiredate` datetime DEFAULT NULL,
  PRIMARY KEY (`ph_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_phonenumbers`
--

LOCK TABLES `tbl_phonenumbers` WRITE;
/*!40000 ALTER TABLE `tbl_phonenumbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_phonenumbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_plans`
--

DROP TABLE IF EXISTS `tbl_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_plans` (
  `plan_id` int(10) NOT NULL AUTO_INCREMENT,
  `plan_type` int(10) DEFAULT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `plan_desc` text,
  `plan_amount` float DEFAULT NULL,
  `plan_user_limit` int(10) DEFAULT NULL,
  `plan_status` int(2) DEFAULT NULL,
  `plan_call_limit` int(10) DEFAULT NULL,
  `plan_period` int(10) DEFAULT NULL COMMENT 'in dates',
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_plans`
--

LOCK TABLES `tbl_plans` WRITE;
/*!40000 ALTER TABLE `tbl_plans` DISABLE KEYS */;
INSERT INTO `tbl_plans` VALUES (1,1,'Professional','For powerful users',100,100,1,10000,100),(6,3,'Premium','Most popular plan',50,25,1,5000,365),(8,0,'Basic','For small groups',25,5,1,300,30);
/*!40000 ALTER TABLE `tbl_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_privilages`
--

DROP TABLE IF EXISTS `tbl_privilages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_privilages` (
  `priv_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) DEFAULT NULL,
  `priv_section` varchar(50) DEFAULT NULL,
  `priv_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`priv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_privilages`
--

LOCK TABLES `tbl_privilages` WRITE;
/*!40000 ALTER TABLE `tbl_privilages` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_privilages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_roles` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL,
  `role_desc` text,
  `role_status` int(1) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_roles`
--

LOCK TABLES `tbl_roles` WRITE;
/*!40000 ALTER TABLE `tbl_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_settings` (
  `settings_key` varchar(50) DEFAULT NULL,
  `settings_value` varchar(50) DEFAULT NULL,
  `settings_type` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_settings`
--

LOCK TABLES `tbl_settings` WRITE;
/*!40000 ALTER TABLE `tbl_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_smb_account`
--

DROP TABLE IF EXISTS `tbl_smb_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_smb_account` (
  `smb_acc_id` int(10) NOT NULL AUTO_INCREMENT,
  `smb_owner_id` int(10) DEFAULT NULL,
  `smb_name` varchar(50) DEFAULT NULL,
  `smb_desc` text,
  `smb_subscription_type` varchar(50) DEFAULT NULL,
  `smb_subscription_date` datetime DEFAULT NULL,
  `smb_subscription_expire_date` datetime DEFAULT NULL,
  `smb_avail_credit` float(20,2) DEFAULT NULL,
  `smb_createdon` varchar(50) DEFAULT NULL,
  `smb_createdby` int(10) DEFAULT NULL,
  `smb_plan` int(2) DEFAULT NULL,
  PRIMARY KEY (`smb_acc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_smb_account`
--

LOCK TABLES `tbl_smb_account` WRITE;
/*!40000 ALTER TABLE `tbl_smb_account` DISABLE KEYS */;
INSERT INTO `tbl_smb_account` VALUES (1,1,'Armia',NULL,NULL,'2014-12-01 12:29:55','2014-12-01 12:29:55',0.00,'2014-12-01 12:29:55',NULL,0),(2,7,'AA1',NULL,NULL,'2014-12-01 13:39:35','2014-12-01 13:39:35',0.00,'2014-12-01 13:39:35',NULL,0),(3,8,'A01',NULL,NULL,'2014-12-02 04:18:10','2014-12-02 04:18:10',0.00,'2014-12-02 04:18:10',NULL,0);
/*!40000 ALTER TABLE `tbl_smb_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_subscription_tracker`
--

DROP TABLE IF EXISTS `tbl_subscription_tracker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_subscription_tracker` (
  `st_id` int(10) NOT NULL AUTO_INCREMENT,
  `st_type` varchar(3) NOT NULL DEFAULT '0' COMMENT '1-> subscription for plan, 2-> phone number subscription',
  `smb_account_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `plan_id` int(10) DEFAULT NULL,
  `st_subscription_amount` float DEFAULT NULL,
  `st_start_date` datetime DEFAULT NULL,
  `st_expiry_date` datetime DEFAULT NULL,
  `st_transact_id` varchar(50) DEFAULT NULL,
  `st_status` int(2) DEFAULT NULL,
  `st_created_on` datetime DEFAULT NULL,
  `st_created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_subscription_tracker`
--

LOCK TABLES `tbl_subscription_tracker` WRITE;
/*!40000 ALTER TABLE `tbl_subscription_tracker` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_subscription_tracker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_testimonials`
--

DROP TABLE IF EXISTS `tbl_testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_testimonials` (
  `testi_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `testi_name` varchar(250) NOT NULL,
  `testi_desc` longtext NOT NULL,
  `testi_location` varchar(250) NOT NULL,
  `testi_image_1` varchar(250) NOT NULL,
  `status` enum('Y','N') NOT NULL,
  PRIMARY KEY (`testi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_testimonials`
--

LOCK TABLES `tbl_testimonials` WRITE;
/*!40000 ALTER TABLE `tbl_testimonials` DISABLE KEYS */;
INSERT INTO `tbl_testimonials` VALUES (1,'Mike Serrano','Armia was a game changer for me. I knew what I wanted to do and how I wanted to do it. The challenge for me was to cost effectively build the application. I looked at a number of different options','USA','37','Y'),(2,'Amy Recchia','I am really happy with the way the site turned out and am excited to launch this endeavor. I already have a list of future customizations and will let you know when I am ready to start them, but for now I am focusing on getting it off the ground... Thank you and your team for all of your hard work.','USA','8','Y');
/*!40000 ALTER TABLE `tbl_testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_transactions`
--

DROP TABLE IF EXISTS `tbl_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_transactions` (
  `tr_id` int(10) NOT NULL AUTO_INCREMENT,
  `tr_status` int(2) DEFAULT NULL,
  `tr_amount` float DEFAULT NULL,
  `tr_type` int(2) DEFAULT NULL,
  `tr_mode` int(2) DEFAULT NULL,
  `tr_details` varchar(255) DEFAULT NULL,
  `tr_created_on` datetime DEFAULT NULL,
  `tr_created_by` int(10) DEFAULT NULL,
  `tr_card_info` varchar(255) DEFAULT NULL,
  `tr_transact_id` varchar(255) DEFAULT NULL,
  `tr_account_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_transactions`
--

LOCK TABLES `tbl_transactions` WRITE;
/*!40000 ALTER TABLE `tbl_transactions` DISABLE KEYS */;
INSERT INTO `tbl_transactions` VALUES (1,0,150,1,NULL,'Plan Purchase','2014-12-01 13:30:08',3,NULL,NULL,NULL),(2,0,50,1,NULL,'Plan Purchase','2014-12-02 04:22:55',9,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_us_states`
--

DROP TABLE IF EXISTS `tbl_us_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_us_states` (
  `state_id` int(10) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(100) DEFAULT NULL,
  `state_abbr` varchar(50) DEFAULT NULL,
  `country_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COMMENT='store us states list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_us_states`
--

LOCK TABLES `tbl_us_states` WRITE;
/*!40000 ALTER TABLE `tbl_us_states` DISABLE KEYS */;
INSERT INTO `tbl_us_states` VALUES (1,'Alabama','AL','US'),(2,'Alaska','AK','US'),(3,'Arizona','AZ','US'),(4,'Arkansas','AR','US'),(5,'California','CA','US'),(6,'Colorado','CO','US'),(7,'Connecticut','CT','US'),(8,'Delaware','DE','US'),(9,'District of Columbia','DC','US'),(10,'Florida','FL','US'),(11,'Georgia','GA','US'),(12,'Hawaii','HI','US'),(13,'Idaho','ID','US'),(14,'Illinois','IL','US'),(15,'Indiana','IN','US'),(16,'Iowa','IA','US'),(17,'Kansas','KS','US'),(18,'Kentucky','KY','US'),(19,'Louisiana','LA','US'),(20,'Maine','ME','US'),(21,'Maryland','MD','US'),(22,'Massachusetts','MA','US'),(23,'Michigan','MI','US'),(24,'Minnesota','MN','US'),(25,'Mississippi','MS','US'),(26,'Missouri','MO','US'),(27,'Montana','MT','US'),(28,'Nebraska','NE','US'),(29,'Nevada','NV','US'),(30,'New Hampshire','NH','US'),(31,'New Jersey','NJ','US'),(32,'New Mexico','NM','US'),(33,'New York','NY','US'),(34,'North Carolina','NC','US'),(35,'North Dakota','ND','US'),(36,'Ohio','OH','US'),(37,'Oklahoma','OK','US'),(38,'Oregon','OR','US'),(39,'Pennsylvania','PA','US'),(40,'Rhode Island','RI','US'),(41,'South Carolina','SC','US'),(42,'South Dakota','SD','US'),(43,'Tennessee','TN','US'),(44,'Texas','TX','US'),(45,'Utah','UT','US'),(46,'Vermont','VT','US'),(47,'Virginia','VA','US'),(48,'Washington','WA','US'),(49,'West Virginia','WV','US'),(50,'Wisconsin','WI','US'),(51,'Wyoming','WY','US'),(52,'Other Locations','OL','');
/*!40000 ALTER TABLE `tbl_us_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_profile`
--

DROP TABLE IF EXISTS `tbl_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_profile` (
  `profile_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_phone_extension` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_profile`
--

LOCK TABLES `tbl_user_profile` WRITE;
/*!40000 ALTER TABLE `tbl_user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL DEFAULT '0',
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_fname` varchar(100) DEFAULT NULL,
  `user_lname` varchar(100) DEFAULT NULL,
  `user_address1` varchar(100) NOT NULL,
  `user_address2` varchar(100) NOT NULL,
  `user_city` varchar(50) NOT NULL,
  `user_state` varchar(50) NOT NULL,
  `user_country` varchar(50) NOT NULL,
  `user_zipcode` varchar(10) NOT NULL,
  `user_gender` enum('male','female','other') NOT NULL DEFAULT 'male',
  `user_status` tinyint(2) DEFAULT NULL,
  `user_photo1_id` int(11) DEFAULT NULL,
  `user_photo_url` varchar(220) DEFAULT NULL,
  `user_joinedon` datetime DEFAULT NULL,
  `user_auth_token` text,
  `user_device_token` text NOT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_bio` text,
  `facebook_user_id` varchar(250) DEFAULT NULL,
  `set_private` tinyint(4) DEFAULT '0',
  `notification` int(11) DEFAULT '0',
  `referral_code` varchar(255) DEFAULT '0',
  `referral_id` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_verification_keys`
--

DROP TABLE IF EXISTS `tbl_verification_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_verification_keys` (
  `vid` int(10) NOT NULL AUTO_INCREMENT,
  `vkey` varchar(255) DEFAULT '0',
  `vuserid` int(12) DEFAULT '0',
  `vtype` int(2) DEFAULT '0' COMMENT '1-> for users ; 2-> apps',
  `vdate` datetime DEFAULT NULL,
  `vstatus` int(2) DEFAULT '1' COMMENT '1-> active ; 0-> inactive; 2-> used',
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_verification_keys`
--

LOCK TABLES `tbl_verification_keys` WRITE;
/*!40000 ALTER TABLE `tbl_verification_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_verification_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'icarus'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-17 17:04:24

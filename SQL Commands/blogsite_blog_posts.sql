CREATE DATABASE  IF NOT EXISTS `blogsite` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci */;
USE `blogsite`;
-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: blogsite
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_turkish_ci DEFAULT NULL,
  `postContent` text COLLATE utf8_turkish_ci,
  `date` double DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'Github’a Terminalden Kod Atma','Merhaba arkadaşlar,\n\nSize bu yazımda Github’a terminalden proje atmayı resimlerle destekli bir şekilde göstereceğim.\n\nİlk olarak Github’da bir repository oluşturuyoruz. Ben repository’nin adıyla bilgisayardaki dosyanın adını aynı koyacağım . Benim aşağıdaki resimde oluşturduğum repository’nin adı DenemeRepository’dir. Bilgisayarımda da DenemeRepository adında bir dosya oluşturdum. Daha önceden Eclipse’de oluşturduğum deneme adlı bir projeyi workspace den kopyalayıp bu dosyanın içine yapıştırdım.\n\nGithub zaten repository oluşturunca izleyeceğimiz adımları bize veriyor. \n\n1. cd Masaüstü/DenemeRepository                                                                                     \n >>  Masaüstünde bulunan DenemeRepository dosyasının içine girdim.\n\n2. ls                                                                                                                                    \n  >> bu komut ile dosyanın içindeki dosyaları görüntüledim.\n\n3. touch README.md\n4. gedit README.md\nBu iki komutun ne işe yaradığını resimdeki md uzantılı dosyadan okuyabilirsiniz.\n\nYukarıdaki resimdeki md uzantılı dosyayı kaydedip çıktığımızda 1. resimdeki komutları teker teker yazıyoruz. Bunlar sağdaki terminalde mevcut. Bu komutlar:\n\n1. git init\n\n2. git add deneme\n\n3. git add README.md\n4. git commit -m “first commit”\n\n5. git remote add origin https://github.com/ozgurince/DenemeRepository.git  (Buradaki linki repository i ilk oluşturduğumuzda Github bize veriyor.\n\n6. git push -u origin master',1425408011,3),(2,'Öğrenci Bilgi Sistemi Projesi','Merhaba arkadaşlar,\n\nBu yazımda size PHP ile geliştirmekte olduğum bir projemi paylaşacağım. Projemin adı Öğrenci Bilgi Sistemi’dir.\n\nBu programla öğrencilerin adını, soyadını, numarasını, sınıfını ve notunu veritabanına ekleyebilirsiniz. İstediğiniz zaman öğrencinin bilgilerine ulaşabilir, bu bilgileri görüntüleyebilir, güncelleyebilir ve tamamen silebilirsiniz. Yani kısacası CRUD (Create, Read, Update, Delete) işlemlerini gerçekleştirebilirsiniz. Proje henüz gelişim aşamasında olduğu için tasarımı çok iyi değildir :)\n\nBen bu projede veritabanı olarak MySQL, tasarım için ise HTML ve çok az CSS kullandım.\n\nProjemin kodlarına <a  target=\"_blank\" href=\"https://github.com/ozgurince/OgrenciBilgiSistemi\">Github adresim</a>den ulaşabilirsiniz.\n\nBir sonraki yazımda görüşmek üzere, esen kalın…',1425408214,1),(3,'Github’ta Fork Edilen Projeyi Güncelleme','Merhaba arkadaşlar,\n\nBu yazımda size başkasının Github’ta yaptığı bir projeyi nasıl commitleyip, güncellediğimiz versiyonunu push etmeyi anlatacağım.\n\nÖncelikle destekleyeceğiniz projeyi kendi hesabınızla forklayın. Bu proje için kendi bilgisayarınızda bir dosya oluşturun. Benim tavsiyem, oluşturduğunuz dosyanın adı ile forkladığınız repository’nin adı aynı olsun. Böylelikle o dosyanın ne işe yaradığını unutmazsınız.  Ben bu yazımda uygulama olarak Mehmet DİK arkadaşımın Terminal_commands adlı repository sini kullanacağım.\n\nHadi başlayalım;\n\n1.  Açtığınız dosyanın içine girip bu dosyayı initialize edelim. Bunu “git init” komutu ile uygularız.\n\n2.  “git remote add origin link.git”  –> Buradaki link yerine kendi hesabımızda forkladığımız repository nin linkini gireriz.\n\n3. “git push” komutunu girerek bunları onaylarız. Burada Github username ve password da girmeniz gerekmektedir.\n\n4. “git clone link.git”  –> Buradaki link yerine kendi hesabımızda forkladığımız repository nin linkini gireriz. Bu kod ile verdiğimiz linkte bulunan dosyaları kendi bilgisayarımıza çekeriz. “ls” komutu ile bunları görebilirsiniz.\n\n5. İndirdiğimiz dosyaların içeriğini değiştirdikten sonra “git add dosyaAdı” şeklinde dosyaları git’e ekleyeceğiz. “git commit -m “your message” komutuyla mesaj şeklinde commit ekledikten sonra, “git push” ile bu düzenlediğimiz dosyaları gitleyip yollarız.\n\nYolladıktan sonraki repository nin halini aşağıdaki resimlerden görebilirsiniz. Bir sonraki yazımda görüşmek üzere, esenle kalın…',1425408373,3),(25,'Telefon Rehberi','Merhaba arkadaşlar,\n\nBu yazımda sizlerle C programlama dilinde yapmış olduğum bir projeyi paylaşmak istiyorum. Projenin adı Telefon Rehberi’dir.\n\nRehbere giriş yapmak için öncelikle kullanıcı adı ve şifre oluşturmalısınız.\n\nBu rehberde kişi ekleme, görüntüleme, silme, güncelleme ve arama yapabilirsiniz.\n\nKişi Ekleme: Kişileri eklerken adını, soyadını, ev telefonunu, cep telefonunu, iş telefonunu, e-mail adresini ve doğum tarihini girebilirsiniz.\n\nKişileri Görüntüleme: Rehberdeki kişileri alfabetik sıraya göre sıralı bir şekilde görebilirsiniz.\n\nKişi Güncelleme: Rehberdeki kişilerin adını, soyadını , ev telefonunu, cep telefonunu, iş telefonunu, e-mail adresini ve doğum tarihini istediğiniz şekilde güncelleyebilirsiniz.\n\nKişi Silme: Rehberden istediğiniz kişiyi silebilirsiniz.\n\nKişi Arama: Rehberde kayıtlı olan kişileri 4 farklı şekilde arayabilirsiniz. Bunlar:\n\n1. Ada Göre Arama\n\n2. Soyada Göre Arama\n\n3. E-posta adresine Göre Arama\n\n4.Doğum Tarihine Göre Arama\n\nBu projenin kodlarına <a href=\"https://github.com/ozgurince\" target=\"_blank\" sl-processed=\"1\">Github adresim</a>den ulaşabilirsiniz.',1425408790,2);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-03 21:07:49

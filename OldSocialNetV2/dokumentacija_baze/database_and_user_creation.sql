create database if not exists scn2 char set utf8mb4 collate utf8mb4_general_ci;
create user if not exists 'adminscn'@'localhost' identified by 'admin';
grant all privileges on scn2.* to 'adminscn'@'localhost';
create user if not exists 'userscn'@'localhost' identified by 'user';
grant select,update,delete,insert on scn2.* to 'userscn'@'localhost';
use scn2; 



-- --------------------------------------------------------

--
-- Table structure for table `registration`
--
-- Creation: Apr 17, 2017 at 07:47 AM
--
CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50)  NOT NULL,
  `lname` varchar(50)  NOT NULL,
  `sex` varchar(1)  NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50)  NOT NULL,
  `countryofbirth` varchar(50)  NOT NULL,
  `pass` varchar(50)  NOT NULL,
  `email` varchar(255)  NOT NULL,
  `uloga` enum('Administrator','Korisnik','Banovani korisnik')  NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

--
-- RELATIONS FOR TABLE `registration`:
--

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` ( `fname`, `lname`, `sex`, `dateofbirth`, `cityofbirth`, `countryofbirth`, `pass`, `email`, `uloga`) VALUES
('Josip', 'Bošnjak', 'm', '1992-05-11', 'Wintherthur', 'Švicarska', 'm', 'jbosnjak3@gmail.com', 'Administrator'),
('Josipa', 'Malenica', 'z', '1988-05-12', 'Zagreb', 'Hrvatska', 'maz16', 'jmale@gmail.com', 'Administrator'),
('Marko', 'Marković', 'm', '1968-05-12', 'Fažana', 'Hrvatska', 'pass', 'mmarkovic@gmail.com', 'Korisnik');


-- --------------------------------------------------------

--
-- Table structure for table `profilna`
--
-- Creation: Apr 17, 2017 at 07:47 AM
--
CREATE TABLE IF NOT EXISTS `profilna` (
  `imageId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `imageType` varchar(25)  NOT NULL,
  `imageData` longblob NOT NULL,
  `email` varchar(255)  NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `email` (`email`)
);

--
-- Constraints for table `profilna`
--
ALTER TABLE `profilna`
  ADD CONSTRAINT `em` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;



-- --------------------------------------------------------

--
-- Table structure for table `galerija`
--
-- Creation: Nov 05, 2017 at 09:02 AM
--


CREATE TABLE IF NOT EXISTS `galerija` (
  `imageId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `korisnik` varchar(255)  NOT NULL,
  `datum_uploada` varchar(255)  NOT NULL,
  `type_of_gallery` varchar(255)  NOT NULL,
  `imageType` varchar(25)  NOT NULL,
  `imageData` longblob NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `type_of_gallery` (`type_of_gallery`)
);

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--
-- Creation: Nov 05, 2017 at 09:01 AM
--


CREATE TABLE IF NOT EXISTS `kategorije` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_gallery` varchar(255)  NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_of_gallery_2` (`type_of_gallery`),
  KEY `type_of_gallery` (`type_of_gallery`)
);

INSERT INTO `kategorije` ( `type_of_gallery`) VALUES
( 'animal'),
( 'animatedpeople'),
( 'boots'),
( 'femaleactress'),
('femaledancers'),
( 'femalemodels'),
( 'femalesingers'),
( 'photoshopped'),
( 'porn'),
( 'rest'),
( 'san andreas'),
( 'sportcars'),
( 'supercars'),
( 'test');



--
-- Constraints for table `galerija`
--
ALTER TABLE `galerija`
  ADD CONSTRAINT `typeofgal` FOREIGN KEY (`type_of_gallery`) REFERENCES `kategorije` (`type_of_gallery`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RELATIONS FOR TABLE `galerija`:
--   `type_of_gallery`
--       `kategorije` -> `type_of_gallery`
--


-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--
-- Creation: Jun 06, 2017 at 12:25 PM
--


CREATE TABLE IF NOT EXISTS `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `broj_teme` varchar(255)  NOT NULL,
  `email` varchar(255)  NOT NULL,
  `datum_i_vrijeme_komentara` datetime NOT NULL,
  `komentar` varchar(255)  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `broj_teme` (`broj_teme`)
);

--
-- RELATIONS FOR TABLE `komentari`:
--   `broj_teme`
--       `teme` -> `broj_teme`
--   `email`
--       `registration` -> `email`
--

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `broj_teme`, `email`, `datum_i_vrijeme_komentara`, `komentar`) VALUES
(1, '1', 'jmale@gmail.com', '2017-06-14 00:00:00', 'nfnfnf');



-- --------------------------------------------------------

--
-- Table structure for table `teme`
--
-- Creation: Apr 17, 2017 at 07:47 AM
--


CREATE TABLE IF NOT EXISTS `teme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255)  NOT NULL,
  `broj_teme` varchar(255)  NOT NULL,
  `naziv_teme` varchar(255)  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `broj_teme` (`broj_teme`),
  KEY `email` (`email`)
);

--
-- RELATIONS FOR TABLE `teme`:
--   `email`
--       `registration` -> `email`
--

--
-- Dumping data for table `teme`
--

INSERT INTO `teme` (`id`, `email`, `broj_teme`, `naziv_teme`) VALUES
(1, 'jbosnjak3@gmail.com', '1', 'Sport');




--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `brojteme` FOREIGN KEY (`broj_teme`) REFERENCES `teme` (`broj_teme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Constraints for table `teme`
--
ALTER TABLE `teme`
  ADD CONSTRAINT `teme_ibfk_1` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;



-- --------------------------------------------------------

--
-- Table structure for table `kvaliteta`
--
-- Creation: Apr 17, 2017 at 07:47 AM
--


CREATE TABLE IF NOT EXISTS `kvaliteta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(60)  NOT NULL,
  `lastname` varchar(60)  NOT NULL,
  `suggestion` varchar(255)  NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- RELATIONS FOR TABLE `kvaliteta`:
--

--
-- Dumping data for table `kvaliteta`
--

INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(9, 'Josipa', 'Malenica', 'Napraviti nekakvo tekstualno polje za dodavanje novih kategorija te da lista preuzima iz baze nazive kategorija. Dodavanje nove kategorije treba biti opcionalno.'),
(10, 'Josip', 'Bošnjak', 'Kod feedbacka, u listi treba ograničiti veličinu  . Ne smije probijati section i eventualno nekakvu stranicu.'),
(11, 'Josip', 'Bošnjak', 'Treba početi raditi forum.'),
(12, 'Josip', 'Bošnjak', 'Treba popraviti da se random pozadina pojavljuje u body-u.'),
(13, 'Josip', 'Bošnjak', 'Potrebno je napraviti nekakve sponzore ili bannere da stranica ne bude prazna.'),
(14, 'Josip', 'Bošnjak', 'Treba dodati semantičko značenje web stranici.'),
(15, 'Josip', 'Bošnjak', 'Napraviti nekakav eventualni alat za dohvaćanje određenih stvari sa stranica naravno to ograniliti samo za administratore'),
(16, 'Josip', 'Bošnjak', 'Treba prikupljati određenu statistiku koliko je neka stranica posjećena odakle su posjete, koji su linkovi najčešće kliknuti, koji su korisnici najaktivniji, implementirati pravila kaznenih bodova kao što piše u feedbacku'),
(17, 'Josip', 'Bošnjak', 'Treba ukloniti nepotrebne greške  recimo pojavljuje se php greška pri dodavanju slika u galeriju'),
(18, 'Josip', 'Bošnjak', 'U galeriji treba popraviti pozicije između slika i opisa te link prema drugoj stranici'),
(19, 'Anonimni', 'Korisnik', 'Napraviti nekakve aplikacije za planiranje'),
(20, 'Anonimni', 'korisnik', 'Napraviti nekakvi captcha za odgodu kako se ne bi previše opterećivao server pri postanju  prijedloga. Ovo nije potrebno da radi u realnom vremenu.'),
(21, 'Josip', 'Bošnjak', 'Prilikom odabira feedbacka, potrebno je definirati i uvjet u kojem se izlistavaju samo oni feedbackovi koji nisu gotovi oni koji su gotovi se ne izlistavaju.'),
(22, 'Josip', 'Bošnjak', 'Za sve napravljene feedbackove, potrebno je definirati novu stranicu koja će ispisivati prijedloge koji su završeni.'),
(23, 'Anonimni', 'Korisnik', 'Razdvojiti kategorije u bazi da se kategorije nalaze u posebnom šifrarniku i samo se putem id-a vežu na slike i pri tome nema previše redundancije'),
(24, 'Josip', 'Bošnjak', 'Kod feedbacka, podebljati slova tako da se primjeti komentar ili napraviti skriptu koja uvećava slova.'),
(25, 'Josip', 'Bošnjak', 'Popraviti galerije tako da budu ili u jednom sectionu i da ne izlaze izvan sectiona.'),
(26, 'Josip', 'Bošnjak', 'Na ostale linkove u galeriji, dodati i onu php galeriju s time da bi se mogla dodati i napomena da se za još galerija vuče prema dolje, ili da se link  povuče kada se klikne na link ili oboje.'),
(27, 'Josip', 'Bošnjak', 'Kod php galerije slika, potrebno je dodati  koliko maksimalno slika ima u bazi te treba dodati kvačicu za maksimalan ispis slika. Možda eventualno broj slika treba biti u obliku check boxa ili ako ne, po defaultu možemo to naznačiti opcionalno, te  stavit'),
(28, 'Josip', 'Bošnjak', 'Kod update profila, popraviti treba napravfiti section.'),
(29, 'Josip', 'Bošnjak', 'Ukoliko amdinistrator ne želi birati uloge, ili što mora napraviti na stranici, treba napraviti izbor koji automatski bira random zadatak i to bude prikazano developeru da napravi. Naravno to treba vrijediti samo za nenapravljene stvari koje još nisu impl'),
(30, 'Josip', 'Bošnjak', 'Osim za stranicu koje su aktivnosti napravljene, napraviti i stranicu i za one kativnosti koje nisu napravljene. Lista treba ispisivati samo one aktivnosti koje su trenutno u tablici.'),
(31, 'Josip', 'Bošnjak', 'U bazi napraviti opis slika za galeriju koja će poslužiti za optimizaciju eventualne tražilice'),
(32, 'Josip', 'Bošnjak', 'Napraviti tražilicu'),
(33, 'Josip', 'Bošnjak', 'U kategorijama slika treba se napraviti query kloji će ispisivati i nove kategorije. Kod feedbacka potrebno je napraviti da se ne izlistavaju naznačeni feedbackovi koji se nalaze u drugoj tablici.'),
(34, 'Josip', 'Bošnjak', 'Napraviti u random slikama da se ispisuju i slike iz baze i postavljaju kao random slike'),
(35, 'Josip', 'Bošnjak', 'Pozicija buttona tijekom selekcije stranice od galerije treba biti usklađena.'),
(37, 'Josip', 'Bošnjak', 'Napraviti tablicu u koja će služiti za zaprimanje određenih zahtijeva. ti zahtjevi mogu biti recimo za brisanja feedbackova.Pri tome korisnik mora znati izravno vrijeme, tj datum i sat kada je postao feedback. Proširiti feedback da piše currentime u bazi.'),
(38, 'Josip', 'Bošnjak', 'Napraviti tablicu koja praqti kad se korisnik ulogirao, te koliko vremena je bio logiran. To će biti dostupno u posebnom mjestu u profilu, koji kada korisnik klikne, prikazati će mu se njegovi logovi.'),
(39, 'Josip', 'Bošnjak', 'Napraviti da se slike u bazi spremaju u određenu mapu na serveru kako bi se moglo napraviti da se te slike mogu pregledavati u modalu. Ili napraviti preko javascripta da se te slike otvaraju na klik i promijenom id-a se mijenjaju u obliku prezentacije.'),
(40, 'Josip', 'Bošnjak', 'Promijeniti naziv liste iz undone linked list u done linked list'),
(41, 'Josip', 'Bošnjak', 'Pomaiknutilijevu navigaciju u desno i stvoriti novi prostor za dodavanje raznoraznih linkova,aplikacija...'),
(42, 'Josip', 'Bošnjak', 'Prilikom dodavanja odgovora za administratora popraviti da se poruka ispisuje u istom browseru ili u javascript obavijesti, tj. alertu'),
(43, 'Josip', 'Bošnjak', 'Kod random zadatka napraviti kod buttona da se može dodavati kvačica ako je napravljeno. Naravno dodati i dodatni button ako nema nikakvih podataka, tj. aktivnost ili prijedlog je u napravljenim ili nenapravljenim aktivnostima.'),
(44, 'Josip', 'Bošnjak', 'Tijekom ispisa kategorija,potrebno je napraviti da se u realnom vremenu napravi da se ispiše odmah i dodana kategorija bez refresha stranice.'),
(45, 'Josip', 'Bošnjak', 'Ovo vrijedi ako je napravljeno. Kada se random slika pojavljuje na ekranu kod random slike, korisnik može upisati u formu da sazna kad je njegova slika na redu. Pri tome se može koristiti implementacija reda.');



-- --------------------------------------------------------

--
-- Table structure for table `obavljeno`
--
-- Creation: Nov 02, 2017 at 10:53 AM
--


CREATE TABLE IF NOT EXISTS `obavljeno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_feedbacka` int(11) NOT NULL,
  `obavljeno` tinyint(1) NOT NULL,
  `email` varchar(255)  NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `user_email` (`email`)
);

--
-- RELATIONS FOR TABLE `obavljeno`:
--

--
-- Dumping data for table `obavljeno`
--

INSERT INTO `obavljeno` (`id`, `id_feedbacka`, `obavljeno`, `email`) VALUES
(3, 10, 1, 'jbosnjak3@gmail.com'),
(4, 12, 0, 'jbosnjak3@gmail.com'),
(7, 29, 1, 'jbosnjak3@gmail.com'),
(8, 9, 1, 'jbosnjak3@gmail.com'),
(9, 25, 1, 'jbosnjak3@gmail.com'),
(10, 23, 1, 'jbosnjak3@gmail.com'),
(11, 17, 1, 'jbosnjak3@gmail.com'),
(12, 21, 1, 'jbosnjak3@gmail.com'),
(13, 30, 1, 'jbosnjak3@gmail.com'),
(14, 18, 0, 'jbosnjak3@gmail.com'),
(15, 28, 1, 'jbosnjak3@gmail.com'),
(16, 20, 0, 'jbosnjak3@gmail.com'),
(17, 22, 1, 'jbosnjak3@gmail.com'),
(18, 15, 0, 'jbosnjak3@gmail.com'),
(19, 33, 1, 'jbosnjak3@gmail.com'),
(20, 27, 1, 'jbosnjak3@gmail.com');


SELECT id,pass,email,uloga FROM registration;
SELECT uloga FROM registration;
SELECT uloga FROM registration WHERE email = 'mmarkovic@gmail.com';

SELECT k.id,k.firstname,k.lastname,k.suggestion FROM kvaliteta k
left join obavljeno o on k.id=o.id_feedbacka where o.obavljeno = 0


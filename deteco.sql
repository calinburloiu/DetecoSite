-- phpMyAdmin SQL Dump
-- version 2.10.0-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: 10.1.1.30
-- Generation Time: Jul 26, 2011 at 11:54 PM
-- Server version: 5.0.18
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `detecoro_1`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `content`
-- 

CREATE TABLE `content` (
  `name` varchar(32) collate utf8_romanian_ci NOT NULL,
  `namespace` varchar(32) collate utf8_romanian_ci NOT NULL default 'common',
  `value` text collate utf8_romanian_ci NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- 
-- Dumping data for table `content`
-- 

INSERT INTO `content` (`name`, `namespace`, `value`) VALUES 
('menu_home', 'common', '{"ro": "Home", "en": "Home"}'),
('menu_company', 'common', '{"ro": "Companie", "en": "Company"}'),
('menu_team', 'common', '{"ro": "Echipa", "en": "Team"}'),
('menu_portfolio', 'common', '{"ro": "Portofoliu", "en": "Portfolio"}'),
('menu_partners', 'common', '{"ro": "Parteneri", "en": "Partners"}'),
('menu_contact', 'common', '{"ro": "Contact", "en": "Contact"}'),
('project_category', 'portfolio', '{"ro": "Categorie", "en": "Category"}'),
('project_name', 'portfolio', '{"ro": "Nume Clădire", "en": "Building Name"}'),
('project_address', 'portfolio', '{"ro": "Adresă", "en": "Address"}'),
('project_developer', 'portfolio', '{"ro": "Dezvoltator", "en": "Developer"}'),
('project_chief_architect', 'portfolio', '{"ro": "Proiectant General", "en": "Chief Architect"}'),
('project_whole_area', 'portfolio', '{"ro": "Suprafață desfășurată", "en": "Whole Area"}'),
('project_height', 'portfolio', '{"ro": "Regim de Înălțime", "en": "Height"}'),
('project_phase', 'portfolio', '{"ro": "Fază", "en": "Phase"}'),
('project_year', 'portfolio', '{"ro": "Anul Execuției", "en": "Building Year"}'),
('project_description', 'portfolio', '{"ro": "Descriere", "en": "Description"}'),
('project_category_office', 'common', '{"ro": "Birouri", "en": "Offices"}'),
('project_category_residential', 'common', '{"ro": "Rezidențial", "en": "Residential"}'),
('project_category_hotel', 'common', '{"ro": "Hoteluri", "en": "Hotels"}'),
('project_category_industrial', 'common', '{"ro": "Industrial", "en": "Industrial"}'),
('project_category_commercial', 'common', '{"ro": "Comercial", "en": "Commercial"}'),
('project_category_restoration', 'common', '{"ro": "Restaurări", "en": "Restorations"}'),
('project_category_hospital', 'common', '{"ro": "Spitale", "en": "Hospitals"}'),
('project_category_other', 'common', '{"ro": "Diverse", "en": "Other"}'),
('portfolio_next', 'portfolio', '{"ro":"Următoarele","en":"Next"}'),
('portfolio_previous', 'portfolio', '{"ro":"Precedentele","en":"Previous"}'),
('link_more', 'common', '{"ro": "mai mult", "en": "more"}'),
('header_from_portfolio', 'common', '{"ro": "Din portofoliu", "en": "From Portfolio"}'),
('header_ads', 'common', '{"ro": "Publicitate", "en": "Ads"}'),
('link_back', 'common', '{"ro": "Înapoi", "en": "Back"}'),
('title', 'common', '{"ro":"DETECO S.R.L. Proiectare, verificare și consultanță în instalații pentru construcții","en":"DETECO S.R.L. Design Engineering, Checking and Consulting in Installations for Construction"}');

-- --------------------------------------------------------

-- 
-- Table structure for table `languages`
-- 

CREATE TABLE `languages` (
  `code` varchar(8) collate utf8_romanian_ci NOT NULL,
  `name` varchar(32) collate utf8_romanian_ci NOT NULL,
  `image` varchar(64) collate utf8_romanian_ci default NULL,
  PRIMARY KEY  (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- 
-- Dumping data for table `languages`
-- 

INSERT INTO `languages` (`code`, `name`, `image`) VALUES 
('ro', 'Română', 'Romania.png'),
('en', 'English', 'UK.png');

-- --------------------------------------------------------

-- 
-- Table structure for table `portfolio`
-- 

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_romanian_ci NOT NULL,
  `category` enum('office','residential','hotel','industrial','commercial','restoration','hospital','other') collate utf8_romanian_ci NOT NULL,
  `tags` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL,
  `address` varchar(512) collate utf8_romanian_ci NOT NULL,
  `developer` varchar(128) collate utf8_romanian_ci NOT NULL,
  `chief_architect` varchar(128) collate utf8_romanian_ci NOT NULL,
  `whole_area` int(11) default NULL,
  `height` varchar(128) collate utf8_romanian_ci NOT NULL,
  `phase` varchar(128) collate utf8_romanian_ci NOT NULL,
  `year_begin` year(4) default NULL,
  `year_end` year(4) default NULL,
  `description` text collate utf8_romanian_ci NOT NULL,
  `images` varchar(512) collate utf8_romanian_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci AUTO_INCREMENT=67 ;

-- 
-- Dumping data for table `portfolio`
-- 

INSERT INTO `portfolio` (`id`, `name`, `category`, `tags`, `address`, `developer`, `chief_architect`, `whole_area`, `height`, `phase`, `year_begin`, `year_end`, `description`, `images`) VALUES 
(48, 'Lakeview Office Building Bucharest', 'office', 'lakeview-office-building', 'Str. Barbu Vacarescu nr. 301-311, Sector 2, Bucuresti', 'BVB Real Estate / AIG Lincoln', 'Vlad Simionescu si Asociatii Arhitecti', 50000, '4S+P+14E+15ET', 'DTAC+PTh+DE+AS', 2007, 2010, '{"ro":"Cladire formata din doua corpuri cu destinatie principala birouri (actualmete sediul Royal Bank of Scotland, Price Waters Coopers si AIG Lincoln) si secundar, parcaje pe patru nivele subtreane si spatii tehnice.\\r\\nS-au proiectat instalatii alimentare cu apa rece si calda intr-o singura zona de presiune, instalatiile de canalizare menajera in sistem Sovent - Geberit si instalatii de stingere incendii cu hidranti, sprinklere si drencere.","en":"The building is made of two parts with their main destination as offices (now the headquarter of Royal Bank of Scotland, Price Waters Coopers and AIG Lincoln). As a secondary destination, the building hosts parking places located in four basement floors and technical facilities.\\r\\nThere were designed installation for cold and hot water in a single zone of pressure, sewage installations in Sovent Geberit System and fire fighting installation with hydrants, sprinklers and drenchers. "}', '["lakeview01.jpg","lakeview02.jpg"]'),
(18, 'Neocity Center', 'office', 'neocity-center', 'Calea Dorobanti nr.237B, sector 1 Bucuresti  ', 'Luxemburg Real Estate', 'Design Construct 93’', 6000, '2S+P+12E+13ET', 'DTAC+PTh+DE+AS', 1998, 2000, '{"ro":"Cladire cu destinatie principala birouri (actualmete sediul Alpha Bank) si secundar parcaje subterane suprapuse (sistem Klaus) si statii tehnice. \\r\\nS-au proiectat instalatii alimentare cu apa rece si calda intr-o singura zona de presiune, instalatiile de canalizare in sistem Sovent - Geberit si instalatii de stingere incendii cu hidranti, sprinklere si drencere.","en":"Office building (now headquarter of Alpha Bank) which also holds overlapping parking places at the ground floor in Klaus System and technical spaces.\\r\\nThere were designed installations for cold and hot water in single zone pressure, sewage installations in Sovent Geberit System and fire fighting installations with hydrants, sprinklers and drenchers."}', '["neocity-center.jpg"]'),
(49, 'Business Center Șerban Vodă', 'office', 'business-center-serban-voda', 'Calea Șerban Vodș nr. 232, București Sector 4', 'Arta Grafică S.A.', 'București Internațional Proiect', 1071, 'P+5E', 'PTh+DE+AS', 2008, NULL, '{"ro":"Cl\\u0103dire format\\u0103 din patru corpuri cu destina\\u021bie principal\\u0103 birouri (actualmete sediul KPMG, Accor Services \\u0219i altii) \\u0219i secundar, spa\\u0219ii tehnice \\u0219i amenaj\\u0103ri exterioare.\\r\\nS-au proiectat instala\\u021bii alimentare cu ap\\u0103 rece \\u0219i cald\\u0103, instala\\u021biile de canalizare menajer\\u0103 \\u0219i pluvial\\u0103 \\u00een sistem Pluvia Geberit \\u0219i instala\\u021bii de stingere incendii cu hidran\\u021bi interiori \\u0219i exteriori.","en":"The building has four parts with its primary destination as offices (now the headquarter of KPMG, Accor Services and others) and secondary as technical spaces and exterior facilities.\\r\\nThere were designed cold and hot water installations, sewerage and pluvial drainage with Pluvia Geberit System and fire fighting installations with interior and exterior hydrants."}', '["business_center_serban_voda.jpg"]'),
(50, 'Bectro Center', 'office', 'bectro-center', 'Str. Sfanta Vineri, nr. 29, sect. 3, Bucuresti', 'Bectro', 'Bogoescu Arhitectura si Urbanism', 4780, 'S+P+4E', 'PAC+PTh+DE+AS', 2000, 2002, '{"ro":"Cladire cu destinatia birouri clasa A.","en":"Office Building class A."}', '["bectro_center.jpg"]'),
(51, 'Iride Business Park Obiect 2a+b', 'office', 'iride-business-park', 'Str. Dimitrie Pompei nr. 9-9A Bucuresti Sect. 1 (in cadrul Iride Business Park)', 'IRIDE S.A.', 'Fleuron Design', 25000, 'P+E', 'PAC+PTh', 2003, 2004, '{"ro":"Cladire cu destinatia birouri clasa A, actualmente sediul Raiffeisen Bank, Procter & Gamble Romania","en":"Building of offices class A, now the headquarter of Raiffeisen Bank, Procter $ Gamble Romania."}', '["iride_business_park01.jpg","iride_business_park02.jpg"]'),
(52, 'Piraeus Bank Headquarter', 'office', 'piraeus-bank', 'Sos. Nicolae Titulescu nr. 29-31 Bucuresti Sect. 1', 'Piraeus Bank', 'Bucuresti International Proiect', 3500, '4S+P+Mz+16E', 'PAC+PTh+DE', 2007, 2008, '{"ro":"Cladire cu destinatia birouri clasa A, actualmente sediul Piraeus Bank. La subsol s-au amenajat parcari auto.","en":"Building with its main destination as office class A, now the headquarter of Piraeus Bank. At the basement there are parking places."}', '["piraeus_bank01.jpg"]'),
(53, 'Amenajare spatii birouri BRD – troson I', 'office', 'birouri-brd', 'Splaiul Independentei nr. 15, bl. 100, tronson 3, sector 5, Bucuresti', 'BRD – Groupe Societe Generale', 'Bucuresti International Proiect', 4223, 'S+P+9E in  ', 'PAC+PTh+DE+AS ', 2008, 2009, '{"ro":"Reamenajarea unui imobil de birouri prin inlocuirea totala a instalatiilor si obiectelor sanitare, adaptate la cerintele moderne. La subsol s-au amenajat spatii tehnice.","en":"Redevelopment of an office building by totally replacing installations, adapting it to the modern norms. At the basement there are technical spaces."}', '["brd_sigla01.jpg"]'),
(54, 'Ansamblul Rezidential Doamna Ghica Plaza (Romfelt Plaza)', 'residential', 'ansamblul-rezidential-domna-ghica', 'Str. Paharnicul Turturea 18 Bucuresti Sector 2', 'Romfelt Real Estate', 'Vlad Simionescu si Asociatii Arhitecti', 100000, '2S+P+4E, 16E, 23E', 'DTAC+PTh+DE+AS', 2007, 2010, '{"ro":"Ansamblu de 9 blocuri de locuinta cu inaltimi diferite (4, 16, respectiv 23 etaje), avand 616 apartamente, magazine la parter si, de asemenea, la subsoluri parcaje subterane pentru  580 auto si spatii tehnice. ","en":"Nine blocks of flats with different heights (4, 16, and 23 floors respectively), having 616 apartment, stores at ground floor and at the basement 580 parking places and technical facilities."}', '["romfelt_plaza01.jpg"]'),
(55, 'Ansamblul de vile rezidentiale Ibiza Golf si Golf & Light', 'residential', 'vile-ibiza-golf-light', 'Pipera - Tunari', 'Avila Construct', 'ELF Proiect Group', 300, 'P+E', 'DTAC+PTh+DE', 2006, 2008, '{"ro":"Doua ansambluri de vile proiectate in doua etape diferite. Cuprind 38, respectiv 36 de vile unifamiliale, P+E, fiecare avand solarium si gradina proprie. Amenajarea exterioara cuprinde parcaje, spatii verzi cu jocuri copii si patru piscine, doua in fiecare ansamblu.","en":"Two ensembles of villas designed in two different phases. They hold 38 and 36 one-family villas respectively, each with one floor, solarium and its own garden. The exterior facilities hold parking places, parks for the children and four pools, two in each ensemble."}', '["ibiza_golf01.jpg","ibiza_golf02.jpg"]'),
(56, 'City Center Residence', 'residential', 'city-center-residence', 'Str. Episcop Chesarie nr. 15 Sector 4 Bucuresti', 'Europa Group', 'BBM Grup ', 18000, 'S+P+6E', 'DTAC+PTh+DE+AS', 2007, 2009, '{"ro":"Ansamblu cuprinde 6 blocuri de locuinta cu 6 etaje, in total 104 apartamente si spatii birouri la parter. La subsol s-au amenajat parcaje pentru 100 auto  si spatii tehnice. ","en":"Six blocks of flats with six floors each, holding 104 apartments and offices at ground floor. At the basement there are 100 parking places and technical facilities."}', '["city_center_residence02.jpg","city_center_residence03.jpg"]'),
(57, 'Parcul Copilului Apartments Building (Domenii Park Village)', 'residential', 'parcul-copilului-apartments', 'Str. Siret  nr. 55 Sector 1 București', 'Cyrom Romania', 'Vlad Simionescu  și Asociații Arhitecți', 18000, 'S+P+5-6E', 'DTAC+PTh+DE+AS', 2007, 2011, '{"ro":"Ansamblu cuprinde 4 blocuri de locuin\\u021be cu 6 etaje, \\u00een total 63 apartamente de lux, spa\\u021bii birouri \\u0219i spa\\u021bii comerciale la parter. La subsol s-au amenajat parcaje pentru 108 auto \\u0219i spa\\u021bii tehnice. ","en":"Four residential buildings with 6 floors, holding 63 luxury apartments and offices and stores at ground floor. At the basement there are 108 parking places and technical facilities."}', '["Parcul_Copilului01.jpg"]'),
(58, 'Parcul Tineretului Residencial Tower', 'residential', 'tineretului-residential-tower', 'Str. Pajiștei nr. 30 Sector 4 București', 'Hanner RD', 'Vlad Simionescu și Asociații Arhitecți', 18000, '2S+P+9-12E', 'DTAC+PTh+DE', 2007, 2008, '{"ro":"Ansamblu cuprinde 4 blocuri de locuin\\u021be cu 9 p\\u00e2n\\u0103 la 12 etaje, \\u00een total 288 apartamente. \\r\\nLa subsoluri s-au amenajat parcaje pentru 296 auto \\u0219i spa\\u021bii tehnice.","en":"Four residential building with 9 to 12 floors, holding 288 apartments.\\r\\nAt the basement there are 296 parking places and technical facilities."}', '["Parcul_Tineretului_Residential_Tower01.jpg"]'),
(59, 'Avionului Condominium București', 'residential', 'avionului-condominium', 'Str. Avionului nr. 52-70 Bucuresti Sector 1', 'Red Sea & Shikun & Binui Real Estate Development', 'Vlad Simionescu și Asociații Arhitecți', 13500, 'S+P+7E', 'DTAC+PTh+DE+AS', 2009, NULL, '{"ro":"Ansamblu cuprinde patru blocuri de locuin\\u021be cu 6 etaje, \\u00een total 63 apartamente de lux, iar la parter spa\\u021bii de birouri \\u0219i spa\\u021bii comerciale. La subsol s-au amenajat parcaje pentru 108 auto \\u0219i spa\\u021bii tehnice.","en":"There are four blocks of flats with 6 floors each, having a total of 63 luxury apartments. At the ground floor there are offices and commercial spaces and at the basement there are 108 parking places and technical spaces."}', '["Avionului_Condominium01.jpg"]'),
(60, 'Avionului Residential Park Bucuresti', 'residential', 'avionului-residential-park', 'Str. Avionului nr. 52-70 București Sector 1', 'Red Sea & Shikun & Binui Real Estate Development', 'Vlad Simionescu  și Asociații Arhitecți', 156000, '2S+P+15-23E', 'DTAC+PTh+DE+AS', 2009, NULL, '{"ro":"Ansamblul cuprinde p\\u00e2n\\u0103 la 4000 de apartamente \\u00een blocuri de locuin\\u021be cu regim de \\u00een\\u0103l\\u021bime de 15 si 23 etaje. La subsoluri sunt prev\\u0103zute cca. 1200 locuri de parcare auto \\u0219i spatii tehnice.","en":"The buildings host around 4000 apartments in blocks of flats with a height between 15 and 23 floors. At their basements there are about 1200 parking places and also technical spaces."}', '["Avionului_Residential_Park01.jpg"]'),
(61, 'Delea Veche 24 Apartments and Offices', 'residential', 'delea-veche-appartments-offices', 'Str. Delea Veche nr. 24  Bucuresti Sector 2', 'Area 10 Eastern World', 'Bogoescu Arhitectură și Urbanism', 34000, '2S+P+6-13E', 'DTAC+PTh+DE+AS', 2008, 2011, '{"ro":"Ansamblu in curs de execu\\u021bie. La final va cuprinde patru cl\\u0103diri, dou\\u0103 de locuin\\u021be P+9 \\u0219i dou\\u0103 cl\\u0103diri de birouri avand P+6, respectiv P+12 etaje. La subsoluri se vor amenaja cca. 200 locuri parcare auto \\u0219i spatii tehnice.","en":"Buildings ensemble currently under development. At the completion date it is going to hold four buildings, two of them for residence and the others two as offices with 6 and 12 floors respectively. At the basement there will be 200 parking places and technical facilities."}', '["Delea_Veche01.jpg","Delea_Veche02.jpg"]'),
(62, 'Ansamblul Rezidential Barbu Delavrancea - Clucerului', 'residential', 'ansamblul-rezidential-delavrancea-clucerului', 'Str. Barbu Delavrancea – Clucerului nr. 63-66 Sect. 1 Bucuresti', 'Radu Dumitrescu și Elena Popescu', 'Anteu Invest', NULL, '2S+P+3-5E', 'DTAC+PTh+DE+AS', 2008, 2010, '{"ro":"Ansamblu cuprinde cinci cl\\u0103diri, cu destina\\u021bia locuin\\u021be de lux, av\\u00e2nd 3 p\\u00e2n\\u0103 la 5 nivele. La subsoluri s-au amenajat cca. 150 locuri parcare auto \\u0219i spa\\u021bii tehnice.","en":"The residential park holds five buildings with luxury apartments, with a height between 3 and 5 floors. At the basement there are about 150 parking places and technical spaces."}', 'null'),
(63, 'Carrefour Băneasa - Centrul Comercial Feeria', 'commercial', 'carrefour-baneasa-feeria', 'Sos. Bucuresti – Ploiesti nr. 44 A, Sect. 1 Bucuresti', 'Soconac - Vinci', 'Soconac - Vinci', 30135, 'P+Mez', 'DTAC+PTh+AS', 2005, 2006, '{"ro":"Complexul Comercial are la parter galerie comercial\\u0103 cu magazine \\u0219i restaurante tip fast-food, hypermarket tip Carrefour cu spa\\u021bii v\\u00e2nzare, depozite, laboratoare produc\\u021bie alimentar\\u0103 precum \\u0219i spa\\u021bii tehnice.\\r\\nLa mezanin s-au amenajat birouri aferente galeriei comerciale precum si vestiare, localuri tehnice, grupuri sanitare \\u0219i  birouri aferente hypermarketului.\\r\\nAmenajarea exterioar\\u0103 are o suprafa\\u021b\\u0103 de 50000 mp.","en":"Commercial space that holds at the ground floor a commercial gallery with stores and fast-food restaurants, Carrefour type hypermarkets with sell spaces, deposits, food production laboratories and technical facilities.\\r\\nAt the mezzanine there are offices attached to the commercial gallery and also changing rooms, technical spaces and bathrooms.\\r\\nThe exterior facility has a surface of 50000 square meters."}', '["Carrefour_Baneasa01.jpg"]'),
(64, 'Carrefour - Centrul Comercial Felicia Iași ', 'commercial', 'carrefour-felicia-iasi', 'Str. Bucium nr. 36 Iași', 'Soconac – Vinci', 'Soconac – Vinci', 29335, 'P+Mez', 'DTAC+PTh+AS', 2006, 2007, '{"ro":"Complexul Comercial are la parter galerie comercial\\u0103 cu magazine \\u0219i restaurante tip fast-food, hypermarket tip Carrefour cu spa\\u021bii v\\u00e2nzare, depozite, laboratoare produc\\u021bie alimentar\\u0103 precum \\u0219i spa\\u021bii tehnice.\\r\\nLa mezanin s-au amenajat birouri aferente galeriei comerciale precum \\u0219i vestiare, localuri tehnice, grupuri sanitare \\u0219i birouri aferente hypermarketului.\\r\\nAmenajarea exterioar\\u0103 are o suprafa\\u021b\\u0103 de 40000 mp.","en":"Commercial space that holds at the ground floor a commercial gallery with stores and fast-food restaurants, Carrefour type hypermarkets with sell spaces, deposits, food production laboratories and technical facilities.\\r\\nAt the mezzanine there are offices attached to the commercial gallery and also changing rooms, technical spaces and bathrooms.\\r\\nThe exterior facility has a surface of 40000 square meters."}', '["Carrefour_Iasi01.jpg"]'),
(65, 'Supermarket Billa Satu Mare', 'commercial', 'supermarket-billa-satu-mare', 'Str. C.S. Anderco nr. 1 Satu Mare', 'Billa Invest Construct', 'Birou Individual de Arhitectură Bogdan Teodor', 2180, 'parter + amenajare exterioara', 'DTAC+PTh+DE+AS', 2005, 2006, '{"ro":"Supermarketul cupride sala de v\\u00e2nzare, spa\\u021bii tehnice \\u0219i administrative,  grupuri sanitare clien\\u021bi, depozitare marf\\u0103, zone distribu\\u021bie marf\\u0103, grupuri sanitare \\u0219i vestiare personal, laboratoare semipreparate. Amenajarea exterioar\\u0103 are o suprafa\\u021b\\u0103 de 6000 mp \\u0219i cuprine utilit\\u0103\\u021bile tehnice \\u0219i parcaje amenajate.","en":"Supermarket which holds the selling room, technical and administrative spaces, bathrooms, merchandise deposits, merchandise distribution zones, changing rooms for the personnel and laboratories for precooked food. The exterior facility holds a surface of 6000 square meters that includes technical utilities and parking places."}', '["Billa_Satu_Mare01.jpg"]'),
(66, 'Supermarket Billa Baia Mare', 'commercial', 'supermarket-billa-baia-mare', 'Str. George Cosbuc  nr. 18  Baia Mare', 'Billa Invest Construct', 'Birou Individual de Arhitectura Bogdan Teodor', 2180, 'Parter +amenajare exterioară', 'DTAC+PTh+DE+AS', 2006, 2007, '{"ro":"Supermarketul cupride sala v\\u00e2nzare, spa\\u021bii tehnice \\u0219i administrative, grupuri sanitare, depozitare marfa, zone distribu\\u021bie marf\\u0103, vestiare personal \\u0219i laboratoare semipreparate. Amenajarea exterioar\\u0103 are o suprafa\\u021b\\u0103 de 6000 mp \\u0219i cuprine utilit\\u0103\\u021bile tehnice \\u0219i parcaje amenajate","en":"Supermarket which holds the selling room, technical and administrative spaces, bathrooms, merchandise deposits, merchandise distribution zones, changing rooms for the personnel and laboratories for precooked food. The exterior facility holds a surface of 6000 square meters that includes technical utilities and parking places."}', '["Billa_Baia_Mare01.jpg"]');

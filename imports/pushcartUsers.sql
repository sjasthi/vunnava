-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 09, 2017 at 08:08 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pushcart`
--

INSERT INTO `users` (`id`, `username`, `password`, `token`, `expires`, `libraryID`) VALUES
(2, 'siva', '$2y$10$ToqtF5MRlOn9fPZswXn9ROuFO5OjVohWz0rG8yseSVvmzXEjExaZa', NULL, NULL, 1),
(5, 'admin', '$2y$10$WQtaA4BvivKovbQlVyTL0eUWDwZnrEvx.6S..cQwaz5CER7QuIB1e', NULL, NULL, 0),
(9, 'dennis', '$2y$10$ZD40ychO2yuG.9mKce3sqOxy3dgVYwv5hZFB5g9tJlTqW16S0Eq3G', NULL, NULL, 2),
(10, 'tien', '$2y$10$sqfAgiXNbnXTpJIo6DacrupGg0iISbUxgzOV7FTPpopk9s1uCNSI.', NULL, NULL, 3),
(11, 'salbih', '$2y$10$m/v0QKdTgLXBthUEKa.HWOzB9ZxDNCE6jvK2YN5oalnCcc8VwGyRO', NULL, NULL, 5),
(12, 'brandon', '$2y$10$7Gbk.Np9E0c8hffCEbtNi.aGvs0nEcPHQWQPWz.UKNjFNuk45wdmK', NULL, NULL, 6),
(14, 'vitaly', '$2y$10$Ag3zbKwU6zEU6UHMMydBk.2zn12GCM1pbPgrt0UOhhQnWC7cY9ZuK', NULL, NULL, 21),
(15, 'prashant', '$2y$10$2WMGDGMSQcA7pKbcNFvfZuenyyS7rWzNPKosohzXxg7KSom4dYNT2', NULL, NULL, 7),
(16, 'jamal', '$2y$10$BgtJgEvYQWSQ5stspaeS2.NHECj2cZB946LzjhicwBjfCavO1qDZS', NULL, NULL, 8),
(17, 'isaiah', '$2y$10$DptEE1aBB4/8Fc.GXY.52.lkVZJMTqKjmoH/.frD7ppUrloy/QF8G', NULL, NULL, 9),
(18, 'abdirihaman', '$2y$10$A1coUJL8f9MWWA.1Z9E4/eui4JWS2nNuRzCnXYi7KNtAuPN8CykHu', NULL, NULL, 10),
(19, 'adam', '$2y$10$y8hYeoAHbDBkbX0wfZC/seFEzJre/fqEd2BMhc4hYs4.zajyvkUrm', NULL, NULL, 11),
(20, 'gary', '$2y$10$GnqVaRql2ZgIKRmRoWIfnea02is2jmn1Kto6z4xme3c1Al5Oh3lZi', NULL, NULL, 12),
(21, 'ying', '$2y$10$j98skeoR0x8WHFU4Oh7ak.PU4Dqt2oFyQXHuNc5/cF.Acn6w3xzai', NULL, NULL, 13),
(22, 'andrew', '$2y$10$Xz2dAr6HfAGIUaysArlmWeWl2I1CYlJBUcc37NERsIj9crhXceIEC', NULL, NULL, 14),
(23, 'shakir', '$2y$10$.6Zd2C1vt.j3Ynl8cSZ/6uMfUt2Ia1qwMBM.1r/f9IenoT/HxkGxC', NULL, NULL, 15),
(24, 'blandy', '$2y$10$rYzeE7Z9.xGrzkKK0tpSKet3iGDbuM7Tq1AvvWyqtMfJWBvX4RZIq', NULL, NULL, 16),
(25, 'conrad', '$2y$10$DAswjlwm7jwgGK58bFdOeeqQ49Ao1mxcXvytaaY95JDiD8lVl0CMO', NULL, NULL, 17),
(26, 'michael', '$2y$10$mLsLrVDvpidfvWDQaY8XD.ZqzZgwpdyMB/d3wdJWfTVLRUfVzIC1y', NULL, NULL, 18),
(27, 'ryan', '$2y$10$EXdHNm4vfLsTfppjuZhwPeTtbNwk8cOiO/hOzPSPaCi31FI9eKgTK', NULL, NULL, 19),
(28, 'tyler', '$2y$10$ekNnv6ABVU37X89e7M73ce0LEhdhxRn4Cg5LD913X2xDXhAr4X9KK', NULL, NULL, 20);


INSERT INTO `library` (`id`, `Name`, `DistrictName`, `MandalName`, `VillageName`, `Description`) VALUES
(0, 'Topudu Bandi Main Library', 'Topudu Bandi District', 'Topudu Bandi Mandal', 'Topudu Bandi', 'Main Library for Topudu Bandi'),
(1, 'Vunnava Village Library (ఉన్నవ గ్రామ గ్రంధాలయం) ', 'Vunnava District', 'Vunnava Mandal', 'Vunnava Village', 'Vunnava is a small village in Edlapadu Mandal, Guntur District, Andhra Pradesh, India; It is 18 km away from Guntur between Guntur and Chilakaluripeta. Many of the professionals from this village are settled all over Andhra Pradesh, in different states of India and in different countries. This library is setup through the generous support of the community through the coordinated efforts of Vunnava Dot Com. Charter of Vunnava Dot Com [1] Create a virtual forum to bring all the professionals and community from this village together – irrespective of caste, religion, age, gender or political affiliation [2] Establish the communication and networking channels through the web, facebook, monthly conference calls, school reunions, celebrations, emails and postal/snail mails to strengthen the community [3] Solicit ideas and suggestions from the community on what can be done to vunnava (in terms of education, community, health and technology). [4] Establish a mechanism to pair up the projects with the sponsors / donors through membership drives and fund-raising events. [5] Acknowledge and recognize the people of vunnava who take / support projects through several communication channels such as (a) bi-annual news letter (b) the web site (c) facebook group. [6] Preserve the legacy and history of the past so that we can learn from it and work towards a better tomorrow. [7] Networking with other NGOs, Government Organizations, Departments, Trusts, Charities, Professional Contacts and Business Establishments while executing the identified projects [8] Ensure that there is respect, transparency, openness, efficiency, continuity in executing these projects [9] Celebrate and share the success stories of vunnava community in their professions, businesses, fields so as to provide an example to the young generation. [10] Strive to make vunnava village a model village for its achievements and status. ఉన్నవ డాట్ కామ్ విధాన పత్రం ఏమిటి? Ø 1. ఇదొక సమావేశ వేదిక. ఈ గ్రామస్ధుల/ గ్రామం నుంచి వచ్చిన వివిధ వృత్తులు/వ్యాసంగాలలో గల వారిని, కుల, మత, వయస్సు, లింగం, రాజకీయబేధాలకు అతీతంగా, ఒక చోటికి చేర్చటం. Ø 2. సభ్యులమధ్య సంబంధబాంధవ్యాలను కొనసాగించటానికి వెబ్ సైట్, ఫేస్ బుక్, నెలవారీ నెట్ సదస్సులు, పాఠశాలల్లో తిరిగి కలుసుకోవటం, ఉత్తరాల ద్వారా మాటాడుకోవటం వంటి మాధ్యమాలను ఏర్పాటు చేయటం. Ø 3. ఉన్నవకు- విద్య, సామాజికం,ఆరోగ్యం, సాంకేతికతల విషయంలో- ఏమి మంచి చేయగలము అనే ఆలోచనలను, సలహాలను పోగుచేయటానికి ఏర్పాటుచేయబడిన వేదిక ఇది. Ø 4. చేపట్టిన పధకాలను దాతలు/సౌజన్యకారులతో అనుసంధానం చేయటానికి ఒక యంత్రాంగాన్ని ఏర్పాటు చేయటం. Ø 5. పధకాలను అమలు చేయటంలో ఆత్మాభిమానం, పారదర్శకత, బహిరంగత, సామర్ధ్యం,నిరంతర కొనసాగింపు ఉండేలాగా చూడటం. Ø 6. పధకాలు అమలు చేసేటప్పుడు ఇతర ప్రభుత్వేతర సంస్థలు, ప్రభుత్వ సంస్థలు, విభాగాలు,ట్రస్టులు, సేవాసంస్థలు, వృత్తిపరమైన సంబంధాలు మరియు వ్యాపార సంస్థల యొక్క సహాయ సహకారాలు తీసుకోవడం. Ø 7. ఉన్నవ డాట్ కామ్ ద్వారా కార్యక్రమాలు చేయటానికి సహాయపడిన వారిని సముచితంగా గౌరవించటం. వారు చేసిన సహాయాలు ఈ వెబ్ సైట్ లో శాశ్వతంగా రాబోయే సంవత్సరాలలో ప్రతిబింబింప చేయటం. Ø 8. యువతరానికి ఆదర్శంగా ఉండటానికి ఉన్నవ సమాజ సభ్యులు తమ రంగాలు, వృత్తులు,వ్యాపకాలల'),
(2, 'dennis', '', '', 'dennis', 'dennis'),
(3, 'tien', 'tien  District', 'tien Mandal', 'tien village', 'tien'),
(4, 'dennis', '', '', 'dennis', 'dennis'),
(5, 'salbih', '', '', 'salbih', 'salbih'),
(6, 'brandon', '', '', 'brandon', 'brandon'),
(7, 'prashant', '', '', 'prashant', 'prashant'),
(8, 'jamal', '', '', 'jamal', 'jamal'),
(9, 'isaiah', '', '', 'isaiah', 'isaiah'),
(10, 'abdirihaman', '', '', 'abdirihaman', 'abdirihaman'),
(11, 'adam', '', '', 'adam', 'adam'),
(12, 'gary', '', '', 'gary', 'gary'),
(13, 'ying', '', '', 'ying', 'ying'),
(14, 'andrew', '', '', 'andrew', 'andrew'),
(15, 'shakir', '', '', 'shakir', 'shakir'),
(16, 'blandy', '', '', 'blandy', 'blandy'),
(17, 'conrad', '', '', 'conrad', 'conrad'),
(18, 'michael', '', '', 'michael', 'michael'),
(19, 'ryan', '', '', 'ryan', 'ryan'),
(20, 'tyler', '', '', 'tyler', 'tyler'),
(21, 'vitaly', '', '', 'vitaly', 'vitaly'),
(22, 'Mammoth Library', '', '', 'Mammoth', 'mammoth');
w
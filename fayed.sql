

CREATE TABLE `articlesimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `mrand` varchar(20) NOT NULL,
  `docnum` varchar(20) NOT NULL,
  `office` varchar(15) NOT NULL,
  `docchk` varchar(10) NOT NULL,
  `img1` varchar(100) NOT NULL,
  `imgsize` varchar(11) NOT NULL,
  `writer` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;






CREATE TABLE `documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctyp` varchar(150) NOT NULL,
  `doclet` varchar(10) NOT NULL,
  `date` varchar(100) NOT NULL,
  `docnum` binary(20) DEFAULT NULL,
  `repet` varchar(10) DEFAULT NULL,
  `writer` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `office` varchar(15) NOT NULL,
  `mrand` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`doctyp`,`doclet`),
  FULLTEXT KEY `title_2` (`doctyp`,`doclet`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;






CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrt` int(11) NOT NULL,
  `member` binary(240) NOT NULL,
  `nid` varchar(20) NOT NULL,
  `mrand` varchar(15) NOT NULL,
  `docnum` binary(20) NOT NULL,
  `office` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office` varchar(100) NOT NULL,
  `mrand` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;


INSERT INTO offices VALUES
("28","فايد","19010908");




CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` binary(40) NOT NULL,
  `fullname` tinytext NOT NULL,
  `office` varchar(15) NOT NULL,
  `role` varchar(255) NOT NULL,
  `lsession` varchar(100) DEFAULT NULL,
  `try` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `wrongpass` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;


INSERT INTO users VALUES
("82","admin1901","123456\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","مدير فرع توثيق فايد","19010908","Admin","الاثنين ، 10 اغسطس 2020 - 10:14 ص","0","on","123456"),
("83","salah","123456\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","صلاح عاطف ابراهيم","19010908","User","الاثنين ، 10 اغسطس 2020 - 10:08 ص","0","on",""),
("84","mohamed","123456\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","محمد اسماعيل عبدالحميد","19010908","User","الاثنين ، 10 اغسطس 2020 - 10:07 ص","0","on",""),
("85","omar","123456\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","عمر السيد عمر ريان","19010908","User","الاثنين ، 10 اغسطس 2020 - 10:10 ص","0","on","");



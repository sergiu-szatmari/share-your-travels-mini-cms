-- Blog posts table --
CREATE TABLE `blogposts` (
  `id` int(20) NOT NULL,
  `postTitleRo` varchar(100) COLLATE utf8_bin NOT NULL,
  `postTitleEn` varchar(100) COLLATE utf8_bin NOT NULL,
  `seo` varchar(100) COLLATE utf8_bin NOT NULL,
  `postContentRo` mediumtext COLLATE utf8_bin NOT NULL,
  `postContentEn` mediumtext COLLATE utf8_bin NOT NULL,
  `createdAt` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `blogposts`
  ADD PRIMARY KEY (`id`);
-- / Blog posts table --

-- Contact forms table --
CREATE TABLE `forms` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `live` varchar(100) COLLATE utf8_bin NOT NULL,
  `travelStory` varchar(10000) COLLATE utf8_bin NOT NULL,
  `skype` varchar(50) COLLATE utf8_bin NOT NULL,
  `formDate` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- / Contact forms table --

-- Users table --
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `cookieval` varchar(300) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `users`(`username`, `password`, `cookieval`) VALUES ('dev', SHA1('dev'), 'UNDEF');
-- / Users table --

-- Reviews table --
CREATE TABLE `reviews` (
  `id` int(20) NOT NULL,
  `displayName` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `message` varchar(2000) COLLATE utf8_bin NOT NULL,
  `createdAt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reviews`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- / Reviews table --


# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Nov 11, 2004 at 02:33 PM
# Server version: 4.0.15
# PHP Version: 4.3.3
# 
# Database : `dev2`
# 

# --------------------------------------------------------

#
# Table structure for table `xent_team_expertise_cat`
#

CREATE TABLE `xent_team_expertise_cat` (
    `ID_EXPERTISECAT` INT(5)       NOT NULL AUTO_INCREMENT,
    `name`            VARCHAR(255) NOT NULL DEFAULT '',
    `priority`        INT(5)       NOT NULL DEFAULT '0',
    KEY `ID_EXPERTISECAT` (`ID_EXPERTISECAT`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

# --------------------------------------------------------

#
# Table structure for table `xent_team_expertise_item`
#

CREATE TABLE `xent_team_expertise_item` (
    `ID_EXPERTISEITEM` INT(5)       NOT NULL AUTO_INCREMENT,
    `name`             VARCHAR(255) NOT NULL DEFAULT '',
    `alwaysShown`      INT(5)       NOT NULL DEFAULT '0',
    `display`          INT(5)       NOT NULL DEFAULT '0',
    `id_expertisecat`  INT(5)       NOT NULL DEFAULT '0',
    KEY `ID_EXPERTISEITEM` (`ID_EXPERTISEITEM`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;



# --------------------------------------------------------

#
# Table structure for table `xent_team_groups`
#

CREATE TABLE `xent_team_groups` (
    `ID_GROUP` INT(5) NOT NULL DEFAULT '0',
    `display`  INT(5) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID_GROUP`),
    UNIQUE KEY `ID_GROUP` (`ID_GROUP`)
)
    ENGINE = ISAM;


# --------------------------------------------------------

#
# Table structure for table `xent_team_link_expertise_users`
#

CREATE TABLE `xent_team_link_expertise_users` (
    `ID_USER`          INT(5) NOT NULL DEFAULT '0',
    `ID_EXPERTISEITEM` INT(5) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID_USER`, `ID_EXPERTISEITEM`)
)
    ENGINE = ISAM;

# --------------------------------------------------------

#
# Table structure for table `xent_team_display`
#

CREATE TABLE `xent_team_display` (
    `ID_DISPLAY`     INT(5) NOT NULL AUTO_INCREMENT,
    `display`        INT(5) NOT NULL DEFAULT '0',
    `pictprowhereto` INT(5) NOT NULL DEFAULT '0',
    `id_user`        INT(5) NOT NULL DEFAULT '0',
    KEY `ID_DISPLAY` (`ID_DISPLAY`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

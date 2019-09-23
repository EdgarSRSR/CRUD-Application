<?php
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=automobiles', 'ed', 'yes');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

##create database automobiles;

##GRANT ALL ON automobiles.* TO 'ed'@'localhost' IDENTIFIED BY 'yes';
##GRANT ALL ON automobiles.* TO 'ed'@'127.0.0.1' IDENTIFIED BY 'yes';

#CREATE TABLE autos (
#        autos_id INTEGER NOT NULL KEY AUTO_INCREMENT,
#        make VARCHAR(255),
#        model VARCHAR(255),
#        year INTEGER,
#        mileage INTEGER
#) ENGINE=InnoDB DEFAULT CHARSET=utf8;
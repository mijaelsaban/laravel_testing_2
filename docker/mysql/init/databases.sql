# create databases
CREATE DATABASE IF NOT EXISTS `bitpanda_database`;
CREATE DATABASE IF NOT EXISTS `bitpanda_testing`;

GRANT ALL PRIVILEGES ON *.* TO 'bitpanda'@'%';

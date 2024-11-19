-- Crear usuario 'marvel-app'
CREATE USER 'marvel-app'@'%' IDENTIFIED BY 'db-p@55w0rd/*';

-- Crear base de datos 'marvel-app' y asignar privilegios
CREATE DATABASE IF NOT EXISTS `marvel-app`;
GRANT ALL PRIVILEGES ON `marvel-app`.* TO 'marvel-app'@'%';


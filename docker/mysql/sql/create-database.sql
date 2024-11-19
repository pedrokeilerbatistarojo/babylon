-- Crear usuario 'babylon-app'
CREATE USER 'babylon-app'@'%' IDENTIFIED BY 'db-p@55w0rd/*';

-- Crear base de datos 'babylon-app' y asignar privilegios
CREATE DATABASE IF NOT EXISTS `babylon-app`;
GRANT ALL PRIVILEGES ON `babylon-app`.* TO 'babylon-app'@'%';


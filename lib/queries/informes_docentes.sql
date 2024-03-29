-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2011 a las 01:32:00
-- Versión del servidor: 5.0.92
-- Versión de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tutoitse_tutorias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes_docentes`
--

CREATE TABLE IF NOT EXISTS `informes_docentes` (
  `periodo` varchar(20) character set latin1 NOT NULL,
  `nu_carrera` tinyint(4) NOT NULL default '0',
  `nu_semana` tinyint(3) unsigned NOT NULL,
  `nu_docente` int(11) NOT NULL,
  `nu_materia` int(11) NOT NULL,
  `nu_contexto` int(11) NOT NULL,
  `nombregrupo` varchar(50) character set latin1 NOT NULL default '',
  `nu_alumno` int(11) NOT NULL,
  `reprobacion` tinyint(3) unsigned default NULL,
  `inasistencia` tinyint(3) unsigned NOT NULL,
  `indisciplina` tinyint(3) unsigned NOT NULL default '0',
  `no_entrega_trabajo` tinyint(3) unsigned NOT NULL default '0',
  `apoyo_psicologico` tinyint(3) unsigned NOT NULL default '0',
  `apoyo_economico` tinyint(3) unsigned NOT NULL default '0',
  `observaciones` varchar(500) character set latin1 default NULL,
  PRIMARY KEY  (`periodo`,`nu_carrera`,`nu_semana`,`nu_docente`,`nu_materia`,`nu_contexto`,`nombregrupo`,`nu_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `informes_docentes`
--

INSERT INTO `informes_docentes` (`periodo`, `nu_carrera`, `nu_semana`, `nu_docente`, `nu_materia`, `nu_contexto`, `nombregrupo`, `nu_alumno`, `reprobacion`, `inasistencia`, `indisciplina`, `no_entrega_trabajo`, `apoyo_psicologico`, `apoyo_economico`, `observaciones`) VALUES
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 15, 0, 0, 0, 0, 0, 0, 'Ha mejorado su actitud'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 16, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 18, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 19, 0, 0, 0, 1, 0, 1, 'Ha bajado su rendimiento'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 22, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 23, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 24, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 28, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 32, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 34, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 35, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 38, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 44, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 47, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 50, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 53, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 54, 0, 0, 1, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 55, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 69, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 70, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 71, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 72, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMA-5', 87, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 8, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 9, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 10, 0, 0, 0, 0, 1, 0, 'Existen problemas con otro compañero de clase'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 11, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 12, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 13, 0, 0, 1, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 14, 0, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 17, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 20, 0, 0, 0, 0, 1, 0, 'Existen problemas con otro compañero de clase'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 21, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 26, 0, 0, 0, 0, 1, 0, 'Existen problemas con otro compañero de clase'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 29, 0, 0, 1, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 30, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 36, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 37, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 39, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 43, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 45, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 15, 100, 'ISMB-5', 48, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 78, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 84, 0, 0, 1, 1, 0, 0, 'Muestra indiferencia en los trabajos realizados en clase'),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 85, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 86, 0, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 186, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 187, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 214, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 216, 0, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 310, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 5, 16, 153, 'ISVB-3', 313, 0, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 28, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 101, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 103, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 104, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 105, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 106, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 107, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 109, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 110, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 111, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 113, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 114, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 115, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 116, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 117, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 118, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 143, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 144, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 145, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 146, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 184, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 185, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 190, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 219, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 220, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 221, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 223, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 317, 1, 1, 1, 1, 1, 1, 'Ya no regreso a clase'),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 322, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 333, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 334, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 350, 0, 1, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 351, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 354, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 355, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 357, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 24, 297, 'ISMA-1', 409, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 15, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 16, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 18, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 19, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 22, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 23, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 24, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 32, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 34, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 38, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 44, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 47, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 50, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 53, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 54, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 69, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 1, 101, 27, 345, 'ISMA-5', 72, 1, 1, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 15, 0, 0, 0, 0, 0, 0, 'Ha mostrado gran mejorí­a en las clases'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 16, 0, 0, 0, 0, 0, 0, 'Ha mostrado gran mejorí­a en las clases'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 18, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 19, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 22, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 23, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 24, 0, 0, 1, 1, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 28, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 32, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 34, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 35, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 38, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 44, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 47, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 50, 0, 0, 1, 0, 1, 0, 'Requiere orientación, su comportamiento es erratico en esta semana del nuevo semestre'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 53, 0, 0, 0, 0, 0, 0, 'Ha mostrado mejorí­a en su desempeño'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 54, 0, 0, 1, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 55, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 69, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 70, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 71, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 72, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMA-5', 87, 0, 0, 0, 0, 1, 0, 'Le es dificil establecer comunicación'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 8, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 9, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 10, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 11, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 12, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 13, 0, 0, 1, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 14, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 17, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 20, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 21, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 26, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 29, 0, 0, 1, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 30, 0, 0, 1, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 36, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 37, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 39, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 43, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 45, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 15, 100, 'ISMB-5', 48, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 78, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 84, 0, 0, 1, 1, 0, 0, 'No muestra mejoria'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 85, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 86, 0, 0, 0, 0, 0, 1, 'Requiere ayuda economica'),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 186, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 187, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 214, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 216, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 310, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 2, 5, 16, 153, 'ISVB-3', 313, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 15, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 16, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 18, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 19, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 22, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 23, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 24, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 28, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 32, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 34, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 35, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 38, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 44, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 47, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 50, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 53, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 54, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 55, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 69, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 70, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 71, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 72, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 15, 100, 'ISMA-5', 87, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 33, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 78, 0, 0, 0, 1, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 84, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 85, 0, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 86, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 186, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 187, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 213, 0, 1, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 214, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 216, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 310, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 313, 1, 0, 0, 0, 0, 1, ''),
('AGOSTO2011-ENERO2012', 3, 3, 5, 16, 153, 'ISVB-3', 316, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 15, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 16, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 18, 1, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 19, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 22, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 23, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 24, 0, 0, 0, 1, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 28, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 32, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 34, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 35, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 38, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 44, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 47, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 50, 0, 0, 0, 0, 1, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 53, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 54, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 55, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 69, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 70, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 71, 0, 0, 0, 0, 0, 0, 'No trabaja'),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 72, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 3, 4, 5, 15, 100, 'ISMA-5', 87, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 231, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 280, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 287, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 289, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 344, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 345, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 347, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 353, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 363, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 365, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 366, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 367, 0, 0, 0, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 368, 0, 0, 1, 0, 0, 0, ''),
('AGOSTO2011-ENERO2012', 4, 1, 349, 55, 809, 'IIMA-7', 369, 0, 0, 0, 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

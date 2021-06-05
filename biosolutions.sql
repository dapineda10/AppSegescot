-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.31-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para biosolutions
CREATE DATABASE IF NOT EXISTS `biosolutions` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `biosolutions`;

-- Volcando estructura para tabla biosolutions.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `cat_idCategoria` char(11) NOT NULL,
  `cat_nombre` char(40) NOT NULL,
  `cat_descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `cli_documento` int(25) NOT NULL,
  `cli_paginaWeb` varchar(50) DEFAULT NULL,
  `cli_direccion` varchar(50) NOT NULL,
  `cli_email` char(100) NOT NULL,
  `cli_zonaCliente` int(3) NOT NULL,
  `cli_ciudad` char(100) NOT NULL,
  `cli_nombre` varchar(50) DEFAULT NULL,
  `cli_pais` char(60) NOT NULL,
  `cli_telefono` char(25) NOT NULL,
  `cli_password` varchar(20) NOT NULL,
  PRIMARY KEY (`cli_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.clientepotencial
CREATE TABLE IF NOT EXISTS `clientepotencial` (
  `cp_nit` int(15) NOT NULL,
  `cp_nombre` varchar(40) NOT NULL,
  `cp_ciudad` varchar(25) NOT NULL,
  `cp_direccion` varchar(30) NOT NULL,
  `cp_observaciones` varchar(100) NOT NULL,
  `cp_telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`cp_nit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.clienteproducto
CREATE TABLE IF NOT EXISTS `clienteproducto` (
  `cli_documento` int(25) NOT NULL,
  `prd_codigoProducto` int(11) NOT NULL,
  `cli_promedioInicial` int(10) NOT NULL,
  `cli_fechaPromedio` date NOT NULL,
  PRIMARY KEY (`cli_documento`,`prd_codigoProducto`),
  KEY `prd_codigoProducto` (`prd_codigoProducto`),
  CONSTRAINT `cli_documento` FOREIGN KEY (`cli_documento`) REFERENCES `cliente` (`cli_documento`),
  CONSTRAINT `prd_codigoProducto` FOREIGN KEY (`prd_codigoProducto`) REFERENCES `producto` (`prd_codigoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.comentario
CREATE TABLE IF NOT EXISTS `comentario` (
  `com_idComentario` int(11) NOT NULL AUTO_INCREMENT,
  `ser_ticket` int(11) DEFAULT NULL,
  `usu_documento` int(20) NOT NULL,
  `com_fecha` date DEFAULT NULL,
  `com_descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`com_idComentario`),
  KEY `usu_documento` (`usu_documento`),
  KEY `sop_ticket` (`ser_ticket`),
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`usu_documento`) REFERENCES `usuario` (`usu_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.contacto
CREATE TABLE IF NOT EXISTS `contacto` (
  `con_codigo` char(10) NOT NULL,
  `cp_nit` int(15) DEFAULT NULL,
  `pro_nit` int(15) DEFAULT NULL,
  `cli_documento` int(15) DEFAULT NULL,
  `con_estadoCivil` char(10) DEFAULT NULL,
  `con_cargo` char(25) DEFAULT NULL,
  `con_telefono` char(15) DEFAULT NULL,
  `con_profesion` char(25) DEFAULT NULL,
  `con_email` char(25) DEFAULT NULL,
  `con_nombreCompleto` char(40) DEFAULT NULL,
  `con_fechaNacimiento` date DEFAULT NULL,
  PRIMARY KEY (`con_codigo`),
  KEY `cp_nit` (`cp_nit`),
  KEY `cli_documento` (`cli_documento`),
  KEY `pro_nit` (`pro_nit`),
  CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`cp_nit`) REFERENCES `clientepotencial` (`cp_nit`),
  CONSTRAINT `contacto_ibfk_2` FOREIGN KEY (`cli_documento`) REFERENCES `cliente` (`cli_documento`),
  CONSTRAINT `contacto_ibfk_3` FOREIGN KEY (`pro_nit`) REFERENCES `proveedor` (`pro_nit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.cotizaciones
CREATE TABLE IF NOT EXISTS `cotizaciones` (
  `cot_codigoCotizacion` varchar(15) NOT NULL,
  `con_codigo` char(10) NOT NULL,
  `cot_validez` int(2) NOT NULL,
  `cot_tiempoEntrega` int(2) NOT NULL,
  `cot_lugarEntrega` char(15) NOT NULL,
  `cot_formaPago` char(10) NOT NULL,
  `cot_fechaCotizacion` date NOT NULL,
  PRIMARY KEY (`cot_codigoCotizacion`),
  KEY `con_codigo` (`con_codigo`),
  CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`con_codigo`) REFERENCES `contacto` (`con_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.despacho
CREATE TABLE IF NOT EXISTS `despacho` (
  `des_CodigoDespacho` int(15) NOT NULL AUTO_INCREMENT,
  `des_Transportadora` varchar(20) NOT NULL,
  `des_ObservacionesEnvio` varchar(70) NOT NULL,
  `des_Contrato_Oc` char(20) NOT NULL,
  `des_NumeroGuia` char(20) NOT NULL,
  `des_CantidadCajas` int(2) NOT NULL,
  `des_FechaEnvio` date NOT NULL,
  `des_Numfactura` char(5) NOT NULL,
  `cli_documento` int(25) NOT NULL,
  `usu_documento` int(25) NOT NULL,
  PRIMARY KEY (`des_CodigoDespacho`),
  KEY `cli_documento` (`cli_documento`),
  KEY `usu_documento` (`usu_documento`),
  CONSTRAINT `despacho_ibfk_1` FOREIGN KEY (`cli_documento`) REFERENCES `cliente` (`cli_documento`),
  CONSTRAINT `despacho_ibfk_2` FOREIGN KEY (`usu_documento`) REFERENCES `usuario` (`usu_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.despachoproducto
CREATE TABLE IF NOT EXISTS `despachoproducto` (
  `des_CodigoDespacho` int(11) NOT NULL,
  `prd_CodigoProducto` char(25) NOT NULL,
  `des_NumeroCaja` char(2) NOT NULL,
  `prd_TiempoGarantia` int(3) DEFAULT NULL,
  `prd_cantidadVenta` int(11) NOT NULL,
  PRIMARY KEY (`des_CodigoDespacho`,`prd_CodigoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.documentacion
CREATE TABLE IF NOT EXISTS `documentacion` (
  `doc_idDocumento` int(15) NOT NULL,
  `cli_documento` int(25) NOT NULL,
  `doc_ruta` varchar(10) NOT NULL,
  `doc_descripcion` varchar(100) DEFAULT NULL,
  KEY `cli_documento` (`cli_documento`),
  CONSTRAINT `documentacion_ibfk_1` FOREIGN KEY (`cli_documento`) REFERENCES `cliente` (`cli_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.parametrizacion
CREATE TABLE IF NOT EXISTS `parametrizacion` (
  `par_idParametrizacion` int(20) NOT NULL,
  `par_porcentajeganacia` double NOT NULL,
  `par_valorDolar` int(10) NOT NULL,
  `par_valorEuro` int(10) NOT NULL,
  PRIMARY KEY (`par_idParametrizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `prd_codigoProducto` int(11) NOT NULL,
  `cat_idCategoria` char(11) NOT NULL,
  `pro_nit` int(15) NOT NULL,
  `prd_tipoDivisa` char(10) NOT NULL,
  `prd_costo` double NOT NULL,
  `prd_tipoPresentacion` char(12) NOT NULL,
  `prd_nombre` varchar(40) NOT NULL,
  `prd_descripcion` varchar(100) NOT NULL,
  `prd_foto` text NOT NULL,
  `prd_loteSerial` char(20) NOT NULL,
  `prd_fechaVencimiento` date NOT NULL,
  `prd_cantidadPresentacion` int(10) NOT NULL,
  `prd_iva` double NOT NULL,
  PRIMARY KEY (`prd_codigoProducto`),
  KEY `cat_idCategoria` (`cat_idCategoria`),
  KEY `pro_nit` (`pro_nit`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`cat_idCategoria`) REFERENCES `categoria` (`cat_idCategoria`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`pro_nit`) REFERENCES `proveedor` (`pro_nit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.productocotizacion
CREATE TABLE IF NOT EXISTS `productocotizacion` (
  `prd_CodigoProducto` int(11) NOT NULL,
  `cot_codigoCotizacion` varchar(15) NOT NULL,
  `cot_precioVenta` double NOT NULL,
  `cot_cantdad` int(7) NOT NULL,
  PRIMARY KEY (`prd_CodigoProducto`,`cot_codigoCotizacion`),
  KEY `cot_codigoCotizacion` (`cot_codigoCotizacion`),
  CONSTRAINT `cot_codigoCotizacion` FOREIGN KEY (`cot_codigoCotizacion`) REFERENCES `cotizaciones` (`cot_codigoCotizacion`),
  CONSTRAINT `productocotizacion_ibfk_3` FOREIGN KEY (`prd_CodigoProducto`) REFERENCES `producto` (`prd_codigoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.productoprecio
CREATE TABLE IF NOT EXISTS `productoprecio` (
  `prd_codprodprecio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prd_CodigoProducto` int(11) NOT NULL,
  `prd_costo` double NOT NULL,
  PRIMARY KEY (`prd_codprodprecio`),
  KEY `FK_prd_CodigoProducto` (`prd_CodigoProducto`),
  CONSTRAINT `FK_prd_CodigoProducto` FOREIGN KEY (`prd_CodigoProducto`) REFERENCES `producto` (`prd_codigoProducto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `pro_nit` int(20) NOT NULL,
  `pro_paginaWeb` varchar(50) DEFAULT NULL,
  `pro_Nombre` char(40) NOT NULL,
  `pro_emailEmpresa` varchar(30) NOT NULL,
  `pro_direccion` char(50) NOT NULL,
  `pro_telefono` char(15) NOT NULL,
  `pro_pais` char(30) NOT NULL,
  `pro_ciudad` char(30) NOT NULL,
  PRIMARY KEY (`pro_nit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_idRol` int(10) NOT NULL,
  `rol_tipoRol` char(15) NOT NULL,
  PRIMARY KEY (`rol_idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.seguimiento
CREATE TABLE IF NOT EXISTS `seguimiento` (
  `seg_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `usu_documento` int(20) NOT NULL,
  `cot_codigoCotizacion` varchar(15) NOT NULL,
  `seg_comentario` varchar(100) NOT NULL,
  `seg_fechaRegistro` date NOT NULL,
  `seg_fechacompromiso` date DEFAULT NULL,
  PRIMARY KEY (`seg_ticket`),
  KEY `usu_documento` (`usu_documento`),
  KEY `cot_codigoCotizacion` (`cot_codigoCotizacion`),
  CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`usu_documento`) REFERENCES `usuario` (`usu_documento`),
  CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`cot_codigoCotizacion`) REFERENCES `cotizaciones` (`cot_codigoCotizacion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.serviciocliente
CREATE TABLE IF NOT EXISTS `serviciocliente` (
  `ser_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `cli_documento` int(15) NOT NULL,
  `ser_fechaInicial` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ser_fechaFin` date NOT NULL,
  `ser_estado` char(10) NOT NULL,
  `ser_tipoSoporte` char(10) DEFAULT NULL,
  `ser_descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`ser_ticket`),
  KEY `cli_documento` (`cli_documento`),
  CONSTRAINT `serviciocliente_ibfk_1` FOREIGN KEY (`cli_documento`) REFERENCES `cliente` (`cli_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usu_documento` int(20) NOT NULL,
  `usu_nombre` char(50) NOT NULL,
  `usu_fechaNacimiento` date DEFAULT NULL,
  `usu_password` varchar(30) NOT NULL,
  `usu_telefono` char(15) NOT NULL,
  `usu_nombreUsuario` char(30) NOT NULL,
  `usu_direccion` char(40) NOT NULL,
  `usu_email` char(40) NOT NULL,
  `usu_rol` char(1) DEFAULT NULL,
  PRIMARY KEY (`usu_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla biosolutions.usuarioroles
CREATE TABLE IF NOT EXISTS `usuarioroles` (
  `usu_documento` int(10) NOT NULL,
  `rol_idRol` int(10) NOT NULL,
  PRIMARY KEY (`usu_documento`,`rol_idRol`),
  KEY `rol_idRol` (`rol_idRol`),
  CONSTRAINT `rol_idRol` FOREIGN KEY (`rol_idRol`) REFERENCES `roles` (`rol_idRol`),
  CONSTRAINT `usu_documento` FOREIGN KEY (`usu_documento`) REFERENCES `usuario` (`usu_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


insert into roles (rol_idRol,rol_tipoRol) values('1', 'Administrador');
insert into roles (rol_idRol,rol_tipoRol) values('2', 'Contador');
insert into roles (rol_idRol,rol_tipoRol) values('3', 'Vendedor');



  --alter table usuario add usu_rol CHAR;
  
  
  
  CREATE TRIGGER ant_add_usuario 
AFTER INSERT ON usuario
  FOR EACH ROW 

  
   insert into usuarioroles (usu_documento, rol_idRol) values (new.usu_documento,  new.usu_rol);
   

  
  

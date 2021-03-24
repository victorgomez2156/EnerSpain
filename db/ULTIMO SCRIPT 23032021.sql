
ALTER TABLE `T_ContactoCliente`
	CHANGE COLUMN `CodCli` `CodCli` INT(5) NULL COMMENT 'Código Cliente' AFTER `CodConCli`,
	CHANGE COLUMN `CodTipCon` `CodTipCon` INT(11) NULL COMMENT 'Código del Tipo de Contacto' AFTER `CodCli`,
	CHANGE COLUMN `EsRepLeg` `EsRepLeg` TINYINT(10) NULL COMMENT 'Es Representante Legal' AFTER `CodTipCon`,
	CHANGE COLUMN `TieFacEsc` `TieFacEsc` TINYINT(10) NULL DEFAULT NULL COMMENT 'Facultad en Escrituras' AFTER `EsRepLeg`,
	ADD COLUMN `EsPrescritor` TINYINT(10) NULL DEFAULT NULL COMMENT 'Para Validar si es Prescritor' AFTER `TieFacEsc`,
	ADD COLUMN `EsColaborador` TINYINT(10) NULL DEFAULT NULL COMMENT 'Para Validar si es colaborador' AFTER `EsPrescritor`,
	DROP FOREIGN KEY `T_ContactoCliente_ibfk_1`;
CREATE TABLE `T_ContactoDetalleCliente` (
	`CodDetCliCont` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'CODIGO AUTOINCREMENTO',
	`CodConCli` BIGINT NOT NULL COMMENT 'CODIGO AUTOINCREMENTO DE LA TABLA T_CONTACTOCLIENTE',
	`CodCli` BIGINT NOT NULL COMMENT 'CODIGO DEL CLIENTE',
	INDEX `Índice 1` (`CodDetCliCont`),
	INDEX `Índice 2` (`CodConCli`),
	INDEX `Índice 3` (`CodCli`),
	PRIMARY KEY (`CodDetCliCont`)
)
COLLATE='utf8_general_ci'
;
ALTER TABLE `T_ContactoCliente`
	ADD COLUMN `CodTipViaFis` INT NULL DEFAULT NULL COMMENT 'Código del Tipo de Via' AFTER `EsColaborador`,
	ADD COLUMN `NomViaDomFis` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Nombre de la Vía' AFTER `CodTipViaFis`,
	ADD COLUMN `NumViaDomFis` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Número de la Vía' AFTER `NomViaDomFis`,
	ADD COLUMN `CPLocFis` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Código Postal' AFTER `NumViaDomFis`,
	ADD COLUMN `CodLocFis` INT NULL DEFAULT NULL COMMENT 'Código Localidad' AFTER `CPLocFis`;
ALTER TABLE `T_ContactoCliente`
	CHANGE COLUMN `EmaConCli` `EmaConCli` VARCHAR(50) NULL COMMENT 'Correo Electrónico Contacto' COLLATE 'latin1_spanish_ci' AFTER `TelCelConCli`;
ALTER TABLE `T_ContactoDetalleCliente`
	ADD COLUMN `EsRepLeg` TINYINT(10) NULL DEFAULT NULL COMMENT 'IDENTIFICA SI ES REPRESENTANTE LEGAL PARA EL CLIENTE' AFTER `CodCli`,
	ADD COLUMN `TieFacEsc` TINYINT(10) NULL DEFAULT NULL COMMENT 'IDENTIFICA SI TIENE FACULTAD DE ESCRITURA PARA EL CLIENTE' AFTER `EsRepLeg`,
	ADD COLUMN `EsPrescritor` TINYINT(10) NULL DEFAULT NULL COMMENT 'IDENTIFICA SI ES PRESCRITOR' AFTER `TieFacEsc`,
	ADD COLUMN `EsColaborador` TINYINT(10) NULL DEFAULT NULL COMMENT 'IDENTIFICA SI ES COLABORADOR' AFTER `EsPrescritor`,
	ADD COLUMN `DocNIF` VARCHAR(250) NULL DEFAULT NULL COMMENT 'DOCUMENTO DEL REPRESENTANTE LEGAL' AFTER `EsColaborador`,
	ADD COLUMN `DocPod` VARCHAR(250) NULL DEFAULT NULL COMMENT 'DOCUMENTO DE LA FACULTAD DE ESCRITURA' AFTER `DocNIF`,
	ADD COLUMN `CanMinRep` INT NULL DEFAULT NULL COMMENT 'CANTIDAD DE FIRMANTES' AFTER `DocPod`,
	ADD COLUMN `TipRepr` INT NULL DEFAULT NULL COMMENT 'TIPO DE REPRESENTACIÓN' AFTER `CanMinRep`;
ALTER TABLE `T_ContactoDetalleCliente`
	DROP COLUMN `DocNIF`;
ALTER TABLE `T_ContactoCliente`
	CHANGE COLUMN `EsRepLeg` `EsRepLeg` TINYINT(10) NULL DEFAULT NULL COMMENT 'Es Representante Legal' AFTER `EstConCli`,
	CHANGE COLUMN `TieFacEsc` `TieFacEsc` TINYINT(10) NULL DEFAULT NULL COMMENT 'Facultad en Escrituras' AFTER `EsRepLeg`,
	CHANGE COLUMN `EsPrescritor` `EsPrescritor` TINYINT(10) NULL DEFAULT NULL COMMENT 'Para Validar si es Prescritor' AFTER `TieFacEsc`,
	CHANGE COLUMN `CodTipCon` `CodTipCon` INT(11) NULL DEFAULT NULL COMMENT 'Código del Tipo de Contacto' AFTER `EsPrescritor`,
	CHANGE COLUMN `EsColaborador` `EsColaborador` TINYINT(10) NULL DEFAULT NULL COMMENT 'Para Validar si es colaborador' AFTER `CodTipCon`,
	CHANGE COLUMN `DocPod` `DocPod` VARCHAR(250) NULL DEFAULT NULL COMMENT 'Poder de Representación' COLLATE 'utf8_spanish_ci' AFTER `EsColaborador`,
	CHANGE COLUMN `CanMinRep` `CanMinRep` INT(1) NULL DEFAULT NULL COMMENT 'Cantidad de firmantes' AFTER `DocPod`,
	CHANGE COLUMN `TipRepr` `TipRepr` INT(11) NOT NULL COMMENT 'Tipo de Representación' AFTER `CanMinRep`;
ALTER TABLE `T_ContactoCliente`
	CHANGE COLUMN `TipRepr` `TipRepr` INT(11) NULL COMMENT 'Tipo de Representación' AFTER `CanMinRep`;
ALTER TABLE `T_ContactoCliente`
	CHANGE COLUMN `CodCli` `CodCli` INT(5) NULL DEFAULT NULL COMMENT 'Código Cliente' AFTER `TipRepr`;
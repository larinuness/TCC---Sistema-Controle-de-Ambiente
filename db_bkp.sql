-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2020 at 11:17 AM
-- Server version: 10.2.31-MariaDB-1:10.2.31+maria~bionic
-- PHP Version: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u739432952_kaa`
--
CREATE DATABASE IF NOT EXISTS `u739432952_kaa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `u739432952_kaa`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `sp_atualiza_apelido`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_apelido` (IN `papelido` VARCHAR(15), IN `pid_gadget` DECIMAL(6), IN `ptipo_modulo` DECIMAL(11))  begin
    update tab_modulos set apelido = trim(papelido)
    where id_gadget = pid_gadget
      and id_tipo_modulo = ptipo_modulo;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_celular`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_celular` (IN `pcelular` VARCHAR(20), IN `pid` DECIMAL(11))  BEGIN
    UPDATE tab_usuarios
    SET celular = pcelular
    WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_email`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_email` (IN `pemail` VARCHAR(100), IN `pid` NUMERIC(11))  BEGIN
    UPDATE tab_usuarios
        SET email = pemail
    WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_nome_sobrenome`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_nome_sobrenome` (IN `pnome` VARCHAR(40), IN `psobrenome` VARCHAR(60), IN `pid` NUMERIC(11))  begin
    update tab_usuarios set nome = pnome, sobrenome = psobrenome
    where id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_senha`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_senha` (IN `psenha_nova` VARCHAR(30), IN `pid` INT(11))  begin
    UPDATE tab_usuarios SET senha = psenha_nova WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_status_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_status_usuario` (IN `pstatus` INT, IN `pid` INT)  begin
    UPDATE tab_usuarios SET status = pstatus WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_atualiza_valor`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_atualiza_valor` (IN `pvalor` FLOAT, IN `pdatahora` DATETIME, IN `pmod` DECIMAL(11))  begin
    UPDATE tab_modulos SET valor = pvalor, u_horario = pdatahora
    WHERE id = pmod;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_atividades_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_atividades_modulo` (IN `pid_usuario` INT, IN `ppagina` INT, IN `pitens` INT)  begin
    SELECT *
    FROM (SELECT atv_i.*,
                 ceil(itens/pitens) as paginas
          FROM (SELECT atv.*,
                       rank() over(order by data_hora,id_modulo,id_atividade) as itens
                FROM vw_atividades atv
                WHERE EXISTS(SELECT 1
                             FROM tab_modulos_usuarios mu
                             WHERE mu.id_usuario = pid_usuario
                               AND mu.id_modulo = atv.id_modulo
                               AND (mu.verificado = 1
                                OR (mu.verificado = 0
                               AND atv.data_hora <= mu.dt_modificacao)))) atv_i) atv_p
    WHERE paginas = ppagina
    ORDER BY itens;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_atividades_modulo_last`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_atividades_modulo_last` (IN `pid_usuario` INT, IN `ppagina` INT, IN `pitens` INT)  begin
    SELECT *
    FROM (SELECT atv_i.*,
                 ceil(ROW_NUMBER() OVER (PARTITION BY CEIL(itens/3) ORDER BY id_atividade desc) / pitens) as paginas
          FROM (SELECT atv.*,
                       ROW_NUMBER() over (partition by id_modulo order by id_atividade desc) as itens
                FROM vw_atividades atv
                WHERE EXISTS(SELECT 1
                             FROM tab_modulos_usuarios mu
                             WHERE mu.id_usuario = pid_usuario
                               AND mu.id_modulo = atv.id_modulo
                               AND (mu.verificado = 1
                                 OR (mu.verificado = 0
                                     AND atv.data_hora <= mu.dt_modificacao)))) atv_i
          WHERE itens in (1,2,3)) atv_p
    WHERE paginas = ppagina
    ORDER BY id_atividade desc;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_atividades_modulo_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_atividades_modulo_usuario` (IN `pid_mod_usu` INT)  begin
    SELECT *
    FROM tab_atividade
    WHERE id_modulos_usuarios in (SELECT id
                                  FROM tab_modulos_usuarios
                                  WHERE id_modulo in (SELECT id_modulo FROM tab_modulos_usuarios WHERE id = pid_mod_usu))
    ORDER BY data_hora DESC;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_atividades_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_atividades_usuario` (IN `pid_usuario` INT(11), IN `ppagina` INT(11), IN `pitens` INT(11))  begin
    SELECT *
    FROM (SELECT atv_i.*,
                 ceil(itens/pitens) as paginas
          FROM (SELECT atv.*,
                       rank() over(order by data_hora,id_atividade) as itens
                FROM vw_atividades atv
                WHERE id_usuario = pid_usuario) atv_i) atv_p
    WHERE paginas = ppagina
    ORDER BY itens;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_atividades_usuario_last`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_atividades_usuario_last` (IN `pid_usuario` INT, IN `ppagina` INT, IN `pitens` INT)  begin
    SELECT *
    FROM (SELECT atv_i.*,
                 ceil(ROW_NUMBER() OVER (PARTITION BY CEIL(itens/3) ORDER BY id_atividade desc) / pitens) as paginas
          FROM (SELECT atv.*,
                       ROW_NUMBER() over (partition by id_modulo order by id_atividade desc) as itens
                FROM vw_atividades atv
                WHERE id_usuario = pid_usuario) atv_i
          WHERE itens in (1,2,3)) atv_p
    WHERE paginas = ppagina
    ORDER BY id_atividade desc;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_modulo` (IN `pid` INT(11))  begin
    SELECT * FROM tab_modulos WHERE id = pid or id_gadget = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_modulos_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_modulos_usuario` (IN `pid` INT)  begin
    SELECT * FROM tab_modulos_usuarios WHERE id_usuario = pid and verificado = 1;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_modulos_usuario_mod`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_modulos_usuario_mod` (IN `pid_modulo` INT)  begin
    SELECT id FROM tab_modulos_usuarios WHERE id_modulo = pid_modulo AND verificado = 1 order by id;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_tipo_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_tipo_modulo` ()  begin
    SELECT * FROM tab_tipo_modulos;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_tipo_modulo_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_tipo_modulo_usuario` (IN `pid` INT)  begin
    SELECT DISTINCT atv.ìd_tipo_modulo as id, atv.tipo FROM vw_atividades atv where id_usuario = pid order by 1;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_usuario` (IN `pid` INT)  begin
    SELECT * FROM tab_usuarios WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_busca_usuario_email`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_usuario_email` (IN `pemail` VARCHAR(100))  begin
    SELECT * FROM tab_usuarios WHERE (email LIKE pemail);
end$$

DROP PROCEDURE IF EXISTS `sp_busca_vw_atividades`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_busca_vw_atividades` ()  BEGIN
    SELECT * FROM vw_atividades;
end$$

DROP PROCEDURE IF EXISTS `sp_cadastra_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_cadastra_modulo` (IN `pid_tipo_modulo` INT, IN `pid_gadget` INT, IN `psituacao` INT, IN `pvalor` FLOAT, IN `papelido` VARCHAR(15))  begin
    declare vmodulo int;
    declare vtipo int;
    declare c_modulo cursor for SELECT count(*)
                                FROM tab_modulos
                                where id_tipo_modulo = pid_tipo_modulo
                                  and id_gadget = pid_gadget;

    declare c_tipo cursor for SELECT COUNT(*)
                              FROM tab_tipo_modulos
                              WHERE id = cast(substr(cast(pid_gadget as char), 1, 1) as INT);

    OPEN c_modulo;
    FETCH c_modulo INTO vmodulo;

    OPEN c_tipo;
    FETCH c_tipo INTO vtipo;
    if ((vtipo = 1) and (length(pid_gadget) = 6)) then
        if (vmodulo < 1) then
            INSERT INTO tab_modulos(id_tipo_modulo, id_gadget, situacao, valor, u_horario, apelido)
            VALUES (pid_tipo_modulo, pid_gadget, psituacao, pvalor, sysdate(), papelido);
        end if;
    end if;
end$$

DROP PROCEDURE IF EXISTS `sp_cadastra_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_cadastra_usuario` (IN `pnome` VARCHAR(40), IN `psobrenome` VARCHAR(60), IN `pemail` VARCHAR(100), IN `psenha` VARCHAR(30), IN `pcod_rand` VARCHAR(20), IN `pstatus` INT, IN `pcelular` CHAR(20))  begin
    INSERT INTO tab_usuarios(NOME, SOBRENOME, EMAIL, SENHA, COD_RAND, STATUS, CELULAR)
    VALUES (pnome, psobrenome, pemail, psenha, pcod_rand, pstatus, pcelular);

    CALL sp_busca_usuario_email(pemail);
end$$

DROP PROCEDURE IF EXISTS `sp_cadastro_tipo_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_cadastro_tipo_modulo` (IN `ptipo` VARCHAR(20))  begin
    INSERT INTO tab_tipo_modulos(tipo)
    VALUES (ptipo);
end$$

DROP PROCEDURE IF EXISTS `sp_charts_dataset`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_charts_dataset` (IN `pid` INT, IN `ptipo_relatorio` VARCHAR(3), IN `ptipo_modulo` INT)  BEGIN
    SELECT DISTINCT BASE.apelido AS      label,
                    BASE.data_hora,
                    IFNULL(REL.valor, 0) valor
    FROM (SELECT *
          FROM (SELECT DISTINCT data_hora
                FROM vw_relatorio
                WHERE tipo_relatorio = ptipo_relatorio
                  AND vw_relatorio.ìd_tipo_modulo = ptipo_modulo
                  AND id_usuario = pid) DATA,
               (SELECT DISTINCT apelido
                FROM vw_relatorio
                WHERE tipo_relatorio = ptipo_relatorio
                  AND vw_relatorio.ìd_tipo_modulo = ptipo_modulo
                  AND id_usuario = pid) GADGET) BASE
             LEFT JOIN vw_relatorio REL ON (BASE.data_hora = REL.data_hora)
        AND (BASE.apelido = REL.apelido)
    ORDER BY BASE.apelido,
             STR_TO_DATE(BASE.data_hora, (select case
                                                     when ptipo_relatorio = 'DIA' THEN '%d-%m-%Y'
                                                     WHEN ptipo_relatorio = 'MES' THEN '%m-%Y'
                                                     WHEN ptipo_relatorio = 'ANO' THEN '%Y' END AS dtfmt));
END$$

DROP PROCEDURE IF EXISTS `sp_charts_labels`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_charts_labels` (IN `pid` INT, IN `ptipo_relatorio` VARCHAR(3), IN `ptipo_modulo` INT)  BEGIN
    SELECT DISTINCT data_hora
    FROM vw_relatorio
    WHERE tipo_relatorio = ptipo_relatorio
      AND vw_relatorio.ìd_tipo_modulo = ptipo_modulo
      AND id_usuario = pid
    ORDER BY STR_TO_DATE(data_hora, (select case
                                                when ptipo_relatorio = 'DIA' THEN '%d-%m-%Y'
                                                WHEN ptipo_relatorio = 'MES' THEN '%m-%Y'
                                                WHEN ptipo_relatorio = 'ANO' THEN '%Y' END AS dtfmt));
END$$

DROP PROCEDURE IF EXISTS `sp_desvincula_modulo`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_desvincula_modulo` (IN `pid_gadget` INT(6), IN `pid_usuario` INT)  begin
    declare vid_modulo int;

    select id into vid_modulo
    from tab_modulos
    where id_gadget = pid_gadget;

    update tab_modulos_usuarios
       set verificado = 0, dt_modificacao = sysdate()
     where id_modulo = vid_modulo
       and id_usuario = pid_usuario;
end$$

DROP PROCEDURE IF EXISTS `sp_grava_atividade`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_grava_atividade` (IN `pid_modulos_usuarios` INT, IN `patividade` VARCHAR(100), IN `psituacao` INT, IN `pdata_hora` DATETIME)  begin
    INSERT INTO tab_atividade(id_modulos_usuarios, atividade, situacao, data_hora)
    VALUES (pid_modulos_usuarios, patividade, psituacao, pdata_hora);
end$$

DROP PROCEDURE IF EXISTS `sp_grava_modulo_usuario`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_grava_modulo_usuario` (IN `pid_modulo` INT, IN `pid_usuario` INT)  begin
    declare v_mod_usu int;
    declare c_mod_usu cursor for SELECT count(*)
                                 FROM tab_modulos_usuarios
                                 where id_usuario = pid_usuario
                                   and id_modulo = pid_modulo;

    open c_mod_usu;

    fetch c_mod_usu into v_mod_usu;

    if (v_mod_usu < 1) then
        INSERT INTO tab_modulos_usuarios(id_modulo, id_usuario, verificado)
        VALUES (pid_modulo, pid_usuario, 1);
    else
        UPDATE tab_modulos_usuarios
           SET verificado = 1, dt_modificacao = sysdate()
         WHERE id_usuario = pid_usuario
           AND id_modulo = pid_modulo;
    end if;

end$$

DROP PROCEDURE IF EXISTS `sp_ligar_desligar_tomada`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_ligar_desligar_tomada` (IN `psituacao` INT, IN `pdatahora` DATETIME, IN `pid` INT(11))  begin
    UPDATE tab_modulos SET situacao = psituacao, u_horario = pdatahora  WHERE id = pid;
end$$

DROP PROCEDURE IF EXISTS `sp_login`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` PROCEDURE `sp_login` (IN `pemail` VARCHAR(100), IN `psenha` VARCHAR(30))  begin
    SELECT * FROM vw_login WHERE (email LIKE pemail AND (senha LIKE psenha));
end$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `get_status_gadget`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` FUNCTION `get_status_gadget` (`pid` NUMERIC(11)) RETURNS DECIMAL(11,0) begin
    declare v_situacao int;
    declare csituacao cursor for select situacao from tab_modulos where id = pid;

    open csituacao;

    fetch csituacao into v_situacao;

    close csituacao;

    return v_situacao;
end$$

DROP FUNCTION IF EXISTS `get_tot_paginas`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` FUNCTION `get_tot_paginas` (`pitens` DECIMAL(11), `pid` DECIMAL(11), `ptipo_not` DECIMAL(11)) RETURNS DECIMAL(11,0) BEGIN
    declare v_tot_paginas int;
    if (ptipo_not = 1) then -- Minhas notificações        SELECT ifnull(MAX(paginas), 1)
        into v_tot_paginas
        FROM (SELECT atv_i.id_usuario,
                     ceil(itens / pitens) as paginas
              FROM (SELECT rank() over (order by atv.data_hora,atv.id_atividade) as itens,
                           atv.id_usuario
                    FROM vw_atividades atv
                    WHERE id_usuario = pid) atv_i) atv_p;
    else -- Todas as notificações        SELECT ifnull(MAX(paginas), 1)
        into v_tot_paginas
        FROM (SELECT atv_i.*,
                     ceil(itens / pitens) as paginas
              FROM (SELECT rank() over (order by atv.data_hora,atv.id_modulo,atv.id_atividade) as itens,
                           atv.*
                    FROM vw_atividades atv
                    WHERE EXISTS(SELECT 1
                                 FROM tab_modulos_usuarios mu
                                 WHERE mu.id_usuario = pid
                                   AND mu.id_modulo = atv.id_modulo
                                   AND (mu.verificado = 1
                                     OR (mu.verificado = 0
                                    AND atv.data_hora <= mu.dt_modificacao)))) atv_i) atv_p;
    end if;
    return v_tot_paginas;
END$$

DROP FUNCTION IF EXISTS `get_tot_paginas_last`$$
CREATE DEFINER=`u739432952_admin`@`127.0.0.1` FUNCTION `get_tot_paginas_last` (`pitens` DECIMAL(11), `pid` DECIMAL(11), `ptipo_not` DECIMAL(11)) RETURNS DECIMAL(11,0) BEGIN
    declare v_tot_paginas int;
    if (ptipo_not = 1) then -- Minhas notificações        SELECT ifnull(MAX(paginas), 1)
        into v_tot_paginas
        FROM (SELECT atv_i.id_usuario,
                     ceil(ROW_NUMBER() OVER (PARTITION BY CEIL(itens/3) ORDER BY id_atividade desc) / pitens) as paginas
              FROM (SELECT ROW_NUMBER() over (partition by id_modulo order by id_atividade desc) as itens,
                           atv.id_usuario,
                           atv.id_atividade
                    FROM vw_atividades atv
                    WHERE id_usuario = pid) atv_i
              WHERE itens in (1,2,3)) atv_p;
    else -- Todas as notificações        SELECT ifnull(MAX(paginas), 1)
        into v_tot_paginas
        FROM (SELECT atv_i.*,
                     ceil(ROW_NUMBER() OVER (PARTITION BY CEIL(itens/3) ORDER BY id_atividade desc) / pitens) as paginas
              FROM (SELECT ROW_NUMBER() over (partition by id_modulo order by id_atividade desc) as itens,
                           atv.*
                    FROM vw_atividades atv
                    WHERE EXISTS(SELECT 1
                                 FROM tab_modulos_usuarios mu
                                 WHERE mu.id_usuario = pid
                                   AND mu.id_modulo = atv.id_modulo
                                   AND (mu.verificado = 1
                                     OR (mu.verificado = 0
                                         AND atv.data_hora <= mu.dt_modificacao)))) atv_i
              WHERE itens in (1,2,3)) atv_p;
    end if;
    return v_tot_paginas;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tab_atividade`
--

DROP TABLE IF EXISTS `tab_atividade`;
CREATE TABLE `tab_atividade` (
  `id` int(11) NOT NULL,
  `id_modulos_usuarios` int(11) DEFAULT NULL,
  `atividade` varchar(100) DEFAULT NULL,
  `situacao` int(11) DEFAULT NULL,
  `data_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tab_modulos`
--

DROP TABLE IF EXISTS `tab_modulos`;
CREATE TABLE `tab_modulos` (
  `id` int(11) NOT NULL,
  `id_tipo_modulo` int(11) NOT NULL,
  `id_gadget` int(11) NOT NULL,
  `situacao` int(11) NOT NULL,
  `valor` float NOT NULL,
  `u_horario` datetime NOT NULL,
  `apelido` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tab_modulos_usuarios`
--

DROP TABLE IF EXISTS `tab_modulos_usuarios`;
CREATE TABLE `tab_modulos_usuarios` (
  `id` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `verificado` int(2) NOT NULL DEFAULT 1,
  `dt_modificacao` datetime NOT NULL DEFAULT sysdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tab_tipo_modulos`
--

DROP TABLE IF EXISTS `tab_tipo_modulos`;
CREATE TABLE `tab_tipo_modulos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tab_tipo_modulos`
--

INSERT INTO `tab_tipo_modulos` (`id`, `tipo`) VALUES
(1, 'Temperatura'),
(2, 'Tomada Inteligente'),
(3, 'Umidade');

-- --------------------------------------------------------

--
-- Table structure for table `tab_usuarios`
--

DROP TABLE IF EXISTS `tab_usuarios`;
CREATE TABLE `tab_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `sobrenome` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `cod_rand` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `celular` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_atividades`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_atividades`;
CREATE TABLE `vw_atividades` (
`id_usuario` int(11)
,`nome` varchar(40)
,`sobrenome` varchar(60)
,`id_modulo` int(11)
,`tipo` varchar(20)
,`ìd_tipo_modulo` int(11)
,`apelido` varchar(15)
,`id_atividade` int(11)
,`atividade` varchar(100)
,`data_hora` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_login`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_login`;
CREATE TABLE `vw_login` (
`id` int(11)
,`email` varchar(100)
,`senha` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_relatorio`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_relatorio`;
CREATE TABLE `vw_relatorio` (
`id_usuario` int(11)
,`id_modulo` int(11)
,`apelido` varchar(15)
,`tipo` varchar(20)
,`ìd_tipo_modulo` int(11)
,`valor` double
,`data_hora` varchar(10)
,`tipo_relatorio` varchar(3)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_atividades`
--
DROP TABLE IF EXISTS `vw_atividades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u739432952_admin`@`127.0.0.1` SQL SECURITY DEFINER VIEW `vw_atividades`  AS  select `U`.`id` AS `id_usuario`,`U`.`nome` AS `nome`,`U`.`sobrenome` AS `sobrenome`,`M`.`id` AS `id_modulo`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,`M`.`apelido` AS `apelido`,`A`.`id` AS `id_atividade`,`A`.`atividade` AS `atividade`,`A`.`data_hora` AS `data_hora` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) order by `A`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_login`
--
DROP TABLE IF EXISTS `vw_login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u739432952_admin`@`127.0.0.1` SQL SECURITY DEFINER VIEW `vw_login`  AS  select `U`.`id` AS `id`,`U`.`email` AS `email`,`U`.`senha` AS `senha` from `tab_usuarios` `U` where `U`.`status` = 1 ;

-- --------------------------------------------------------

--
-- Structure for view `vw_relatorio`
--
DROP TABLE IF EXISTS `vw_relatorio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u739432952_admin`@`127.0.0.1` SQL SECURITY DEFINER VIEW `vw_relatorio`  AS  select `rel`.`id_usuario` AS `id_usuario`,`rel`.`id_modulo` AS `id_modulo`,`rel`.`apelido` AS `apelido`,`rel`.`tipo` AS `tipo`,`rel`.`ìd_tipo_modulo` AS `ìd_tipo_modulo`,`rel`.`valor` AS `valor`,`rel`.`data_hora` AS `data_hora`,`rel`.`tipo_relatorio` AS `tipo_relatorio` from (select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,14,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%d-%m-%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%d-%m-%Y') AS `data_hora`,'DIA' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 1 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,sum(`A`.`situacao`) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%d-%m-%Y')) AS `valor`,date_format(`A`.`data_hora`,'%d-%m-%Y') AS `data_hora`,'DIA' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 2 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,10,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%d-%m-%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%d-%m-%Y') AS `data_hora`,'DIA' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 3 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,14,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%m-%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%m-%Y') AS `data_hora`,'MES' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 1 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,sum(`A`.`situacao`) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%m-%Y')) AS `valor`,date_format(`A`.`data_hora`,'%m-%Y') AS `data_hora`,'MES' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 2 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,10,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%m-%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%m-%Y') AS `data_hora`,'MES' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 3 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,14,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%Y') AS `data_hora`,'ANO' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 1 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,sum(`A`.`situacao`) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%Y')) AS `valor`,date_format(`A`.`data_hora`,'%Y') AS `data_hora`,'ANO' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 2 and `A`.`atividade`  not like 'Apelido%' union select `U`.`id` AS `id_usuario`,`M`.`id` AS `id_modulo`,`M`.`apelido` AS `apelido`,`TM`.`tipo` AS `tipo`,`TM`.`id` AS `ìd_tipo_modulo`,truncate(avg(cast(substr(`A`.`atividade`,10,4) as double)) over ( partition by `M`.`id`,`TM`.`id`,date_format(`A`.`data_hora`,'%Y')),2) AS `valor`,date_format(`A`.`data_hora`,'%Y') AS `data_hora`,'ANO' AS `tipo_relatorio` from ((((`tab_atividade` `A` join `tab_modulos_usuarios` `MU` on(`MU`.`id` = `A`.`id_modulos_usuarios`)) join `tab_usuarios` `U` on(`U`.`id` = `MU`.`id_usuario`)) join `tab_modulos` `M` on(`M`.`id` = `MU`.`id_modulo`)) join `tab_tipo_modulos` `TM` on(`TM`.`id` = `M`.`id_tipo_modulo`)) where `M`.`id_tipo_modulo` = 3 and `A`.`atividade`  not like 'Apelido%') `rel` order by `rel`.`tipo_relatorio`,`rel`.`data_hora`,`rel`.`id_modulo` collate latin1_bin ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_atividade`
--
ALTER TABLE `tab_atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atividade_modulo_usuario` (`id_modulos_usuarios`);

--
-- Indexes for table `tab_modulos`
--
ALTER TABLE `tab_modulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulo_tipo_modulo` (`id_tipo_modulo`);

--
-- Indexes for table `tab_modulos_usuarios`
--
ALTER TABLE `tab_modulos_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulos_usuarios_modulos` (`id_modulo`),
  ADD KEY `fk_modulos_usuarios_usuarios` (`id_usuario`);

--
-- Indexes for table `tab_tipo_modulos`
--
ALTER TABLE `tab_tipo_modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tab_atividade`
--
ALTER TABLE `tab_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tab_modulos`
--
ALTER TABLE `tab_modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tab_modulos_usuarios`
--
ALTER TABLE `tab_modulos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tab_tipo_modulos`
--
ALTER TABLE `tab_tipo_modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tab_atividade`
--
ALTER TABLE `tab_atividade`
  ADD CONSTRAINT `fk_atividade_modulo_usuario` FOREIGN KEY (`id_modulos_usuarios`) REFERENCES `tab_modulos_usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tab_modulos`
--
ALTER TABLE `tab_modulos`
  ADD CONSTRAINT `fk_modulo_tipo_modulo` FOREIGN KEY (`id_tipo_modulo`) REFERENCES `tab_tipo_modulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tab_modulos_usuarios`
--
ALTER TABLE `tab_modulos_usuarios`
  ADD CONSTRAINT `fk_modulos_usuarios_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `tab_modulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_modulos_usuarios_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `tab_usuarios` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

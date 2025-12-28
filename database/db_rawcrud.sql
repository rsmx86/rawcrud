-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Dez-2025 às 17:41
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_rawcrud`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(150) NOT NULL,
  `nick` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `pais` enum('Brasil','Japan') DEFAULT 'Brasil',
  `cep` varchar(15) DEFAULT NULL,
  `cidade_provincia` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `carro_fabricante` varchar(50) DEFAULT NULL,
  `carro_modelo` varchar(100) DEFAULT NULL,
  `carro_ano` int(4) DEFAULT NULL,
  `carro_chassi` varchar(50) DEFAULT NULL,
  `carro_motor` varchar(50) DEFAULT NULL,
  `carro_cambio` enum('Manual','Automático') DEFAULT 'Manual',
  `carro_turbo` enum('Aspirado','Turbo','Supercharger') DEFAULT 'Aspirado',
  `carro_ecu` enum('Original','Programável','Piggyback') DEFAULT 'Original',
  `carro_suspensao` enum('Original','Esportiva','Preparada') DEFAULT 'Original',
  `carro_rodas` enum('Original','Aftermarket','Competição') DEFAULT 'Original',
  `uso_drift` tinyint(1) DEFAULT 0,
  `uso_track_day` tinyint(1) DEFAULT 0,
  `uso_rua` tinyint(1) DEFAULT 0,
  `uso_competicao` tinyint(1) DEFAULT 0,
  `observacoes` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome_completo`, `nick`, `telefone`, `pais`, `cep`, `cidade_provincia`, `bairro`, `endereco`, `carro_fabricante`, `carro_modelo`, `carro_ano`, `carro_chassi`, `carro_motor`, `carro_cambio`, `carro_turbo`, `carro_ecu`, `carro_suspensao`, `carro_rodas`, `uso_drift`, `uso_track_day`, `uso_rua`, `uso_competicao`, `observacoes`, `data_cadastro`) VALUES
(1, 'Keiichi Tsuchiya', 'Dorifuto Kingu', '(09) 07346-1289', 'Japan', '3890517', 'Togo City, Nagano Prefecture', 'Prefecture', 'Zip Code Area: 3890517', 'Toyota Motor Corporation', 'Toyota Sprinter Trueno AE86 (GT-APEX)', 1985, 'AE86-1234578DK', 'Toyota 4A-GE', 'Manual', 'Aspirado', 'Original', 'Esportiva', 'Competição', 1, 0, 1, 0, 'Transmissão: Manual de 5 marchas, Motor: 4A-GE aspirado, ECU original,Suspensão:Esportiva, ajustada para oversteer controlado, Rodas: Watanabe 15” competição.\r\n\r\nUso: Drift em tōge, corridas de clube e demonstrações técnicas', '2025-12-28 03:38:52'),
(4, 'Hiroshi Fushida', 'The Silent Drifter', '(09) 07346-1289', 'Japan', '3890501', 'Togo City, Nagano Prefecture', 'Shinbashi', 'Zip Code Area: 3890501', 'Nissan', 'Nissan Silvia S12', 1987, 'S12-9876543HF', 'CA18DE 1.8L', 'Manual', 'Turbo', 'Original', 'Esportiva', '', 1, 0, 1, 1, 'Rota 15” competição. Transmissão manual 5 marchas, clutch kick. Motor CA18DE 1.8L, aspirado/turbo opcional. Induction aspirado. ECU original. Suspensão esportiva, oversteer controlado.', '2025-12-28 03:56:29'),
(5, 'Yoshio Sugino', 'Tōge Master', '(09) 02314-9876', 'Japan', '3211401', 'Nikko City, Tochigi Prefecture', 'Kamibachishi-cho', 'Zip Code Area: 3211401', 'Honda Civic', 'Honda Civic CR-X EF', 1989, 'EF-246810YS', 'Motor D16A 1.6L', 'Manual', 'Aspirado', 'Original', 'Esportiva', 'Aftermarket', 0, 0, 0, 0, 'Motor D16A 1.6L, aspirado, ECU original. Transmissão manual 5 marchas, clutch kick. Suspensão esportiva, oversteer controlado. Rodas Enkei 14-15” esportiva.', '2025-12-28 04:02:02'),
(6, 'Takahiro Ueno', 'Street Samurai', '(08) 06789-1234', 'Japan', '2520813', 'Fujisawa-shi, Kanagawa', 'Kameino', 'Zip Code Area: 2520813', 'Nissan', 'Nissan Silvia S13', 1990, 'S13-135791TU', 'Motor SR20DET 2.0L turbo', 'Manual', 'Turbo', 'Original', 'Esportiva', 'Aftermarket', 0, 0, 0, 0, 'SR20DET 2.0L turbo, ECU original. Transmissão manual 5 marchas, clutch kick. Suspensão esportiva agressiva. Rodas Watanabe / Volk TE37 competição', '2025-12-28 04:04:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `nick` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('Garage Chief','Chief Mechanic','Mechanic') DEFAULT 'Mechanic',
  `especialidade` varchar(100) DEFAULT NULL,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_acesso` datetime DEFAULT NULL,
  `status` enum('Active','Offline','Suspended') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `nick`, `email`, `senha`, `nivel`, `especialidade`, `primeiro_acesso`, `ultimo_acesso`, `status`) VALUES
(1, 'Administrador', '', '', 'adm@garage.com', '$2a$12$YFmSfbP5cC3DNEEbR5nQsuafKwiH2zYPMk50DJ4HudXXSEdP8YFUi', 'Garage Chief', NULL, 1, '2025-12-28 13:30:13', 'Active'),
(3, 'Kunimitsu', 'Takahashi', 'Kuni-san', 'kuni@garage.com', '$2y$10$FCe9CIQ0KJPTG/J4tcq.BO6.9iFX6J0Pj6fpyMuWUjnyv7hEjuiR6', 'Garage Chief', NULL, 1, '2025-12-27 23:00:25', 'Active'),
(4, 'Keiichi', 'Tsuchiy', 'Dorifuto Kingu', 'keiichi@garage.com', '$2y$10$sbQcCjnPr7jU9tQwIFu.yewdfY/IsF4b5tN3.aUx8H8A8DR/7fUXK', 'Mechanic', NULL, 1, '2025-12-27 22:00:45', 'Active'),
(5, 'Kazuhiko', 'Nagata', 'Smokey Nagata', 'smokey@garage.com', '$2y$10$IDLQTxsoVNwJWs1D/hpjA.X/J08QxqOuIkoIKYKjbRUrgARpTvoX2', 'Garage Chief', NULL, 1, '2025-12-27 22:01:56', 'Active'),
(6, 'Kenji', 'Kazama', 'Kazama', 'kazama@garage.com', '$2y$10$LpEafAa97h0wdlp/CO4jH.6fchhssWpVW2j2S1FOU1jTxQZB1JVa6', 'Chief Mechanic', NULL, 1, '2025-12-27 22:02:28', 'Active'),
(9, 'Monarah', 'Louisy', 'Narinha', 'monarahlouisy@gmail.com', '$2y$10$2BDUc5UQ.QEWJWaChzUj2eMD5oMBZKlVNGV.WCV9c3ZqE5znjyGL2', 'Chief Mechanic', NULL, 1, '2025-12-28 13:27:27', 'Active');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

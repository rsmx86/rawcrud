-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Dez-2025 às 02:30
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
-- Estrutura da tabela `catalogo_produtos`
--

CREATE TABLE `catalogo_produtos` (
  `id` int(11) NOT NULL,
  `codigo_sku` varchar(50) NOT NULL,
  `nome_produto` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `catalogo_produtos`
--

INSERT INTO `catalogo_produtos` (`id`, `codigo_sku`, `nome_produto`, `descricao`, `data_cadastro`) VALUES
(1, '100245', 'Bateria Automotiva 45Ah', 'Categoria: Elétrica\r\n\r\nTipo: Chumbo-ácida\r\n\r\nCapacidade: 45Ah\r\n\r\nTensão: 12V\r\n', '2025-12-28 20:17:14'),
(2, '100246', 'Bateria Automotiva 60Ah', 'Categoria: Elétrica\r\n\r\nTipo: Chumbo-ácida\r\n\r\nCapacidade: 60Ah\r\n\r\nTensão: 12V\r\n', '2025-12-28 20:17:56'),
(3, '100247', 'Bateria Automotiva AGM 60Ah', 'Categoria: Elétrica\r\n\r\nTipo: AGM\r\n\r\nCapacidade: 60Ah\r\n\r\nTensão: 12V', '2025-12-28 20:18:33'),
(4, '100248', 'Bateria Automotiva 70Ah', 'Categoria: Elétrica\r\n\r\nTipo: Chumbo-ácida\r\n\r\nCapacidade: 70Ah\r\n\r\nTensão: 12V', '2025-12-28 20:18:55'),
(5, '100249', 'Bateria Automotiva 90Ah', 'Categoria: Elétrica\r\n\r\nTipo: Chumbo-ácida\r\n\r\nCapacidade: 90Ah\r\n\r\nTensão: 12V', '2025-12-28 20:19:12'),
(8, '300110', 'Pastilha de Freio Dianteira', 'Material: Semi-metálica', '2025-12-29 00:56:00'),
(9, '300130', 'Pastilha de Freio Traseira', 'Material: Cerâmica', '2025-12-29 00:56:28');

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
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `codigo_produto` varchar(50) NOT NULL,
  `produto_nome` varchar(150) NOT NULL,
  `posicao` varchar(50) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `fabricante` varchar(150) DEFAULT NULL,
  `qtd_atual` int(11) DEFAULT 0,
  `preco_unitario` decimal(10,2) DEFAULT 0.00,
  `valor_total` decimal(10,2) GENERATED ALWAYS AS (`qtd_atual` * `preco_unitario`) STORED,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque_v2`
--

CREATE TABLE `estoque_v2` (
  `id` int(11) NOT NULL,
  `id_catalogo` int(11) DEFAULT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `rua` char(1) DEFAULT NULL,
  `posicao` int(2) DEFAULT NULL,
  `status_posicao` varchar(20) DEFAULT 'LIVRE',
  `quantidade` int(11) DEFAULT 0,
  `origem_nota` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `estoque_v2`
--

INSERT INTO `estoque_v2` (`id`, `id_catalogo`, `lote`, `data_fabricacao`, `rua`, `posicao`, `status_posicao`, `quantidade`, `origem_nota`) VALUES
(1, 1, 'LT-45821', NULL, 'A', 1, 'NON_COMPLIANCE', 1, '1'),
(2, 1, 'LT-21854', NULL, 'A', 2, 'QUARANTINE', 5, '784512'),
(3, 2, 'LT-90854', NULL, 'A', 3, 'ACTIVE', 5, '784512'),
(4, 3, 'LT-1234', NULL, 'A', 4, 'LIVRE', 5, '784512'),
(5, 4, 'LT-4511', NULL, 'A', 5, 'LIVRE', 5, '784512'),
(6, 4, 'LT-11452', NULL, 'A', 6, 'LIVRE', 5, '784512'),
(7, 5, 'LT-95861', NULL, 'A', 7, 'LIVRE', 4, '784512'),
(11, 8, 'PF-T120-824', NULL, 'B', 1, 'LIVRE', 20, '785903'),
(12, 8, 'PF-D110-824', NULL, 'B', 2, 'LIVRE', 20, '785903'),
(13, 9, 'PF-SP140-824', NULL, 'B', 3, 'LIVRE', 20, '785903');

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `numero_nota` varchar(50) NOT NULL,
  `fornecedor` varchar(150) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `valor_total_nota` decimal(10,2) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `invoices`
--

INSERT INTO `invoices` (`id`, `numero_nota`, `fornecedor`, `data_emissao`, `valor_total_nota`, `data_registro`) VALUES
(2, '784512', 'Nippon Auto Parts Co., Ltd.', '2025-12-28', '9400.00', '2025-12-28 21:18:16'),
(8, '785903', 'Tokyo Brake Systems Co., Ltd.', '2025-12-28', '2000.00', '2025-12-29 00:58:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `id_invoice` int(11) DEFAULT NULL,
  `id_catalogo` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `status_alocacao` enum('Pendente','Concluido') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `id_invoice`, `id_catalogo`, `quantidade`, `lote`, `preco_unitario`, `data_fabricacao`, `status_alocacao`) VALUES
(2, 2, 1, 5, 'LT-45821', NULL, NULL, 'Concluido'),
(3, 2, 2, 5, 'LT-60277', NULL, NULL, 'Concluido'),
(4, 2, 3, 5, 'LT-70236', NULL, NULL, 'Concluido'),
(5, 2, 4, 5, 'LT-90584', NULL, NULL, 'Concluido'),
(6, 2, 4, 5, 'LT-456070', NULL, NULL, 'Concluido'),
(7, 2, 5, 4, 'LT-217736', NULL, NULL, 'Concluido'),
(11, 8, 8, 20, 'PF-T120-824', NULL, NULL, 'Concluido'),
(12, 8, 8, 20, 'PF-D110-824', NULL, NULL, 'Concluido'),
(13, 8, 9, 20, 'PF-SP140-824', NULL, NULL, 'Concluido');

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
(1, 'Administrador', '', '', 'adm@garage.com', '$2a$12$YFmSfbP5cC3DNEEbR5nQsuafKwiH2zYPMk50DJ4HudXXSEdP8YFUi', 'Garage Chief', NULL, 1, '2025-12-28 20:59:22', 'Active'),
(3, 'Kunimitsu', 'Takahashi', 'Kuni-san', 'kuni@garage.com', '$2y$10$FCe9CIQ0KJPTG/J4tcq.BO6.9iFX6J0Pj6fpyMuWUjnyv7hEjuiR6', 'Garage Chief', NULL, 1, '2025-12-28 22:21:33', 'Active'),
(4, 'Keiichi', 'Tsuchiy', 'Dorifuto Kingu', 'keiichi@garage.com', '$2y$10$sbQcCjnPr7jU9tQwIFu.yewdfY/IsF4b5tN3.aUx8H8A8DR/7fUXK', 'Mechanic', NULL, 1, '2025-12-27 22:00:45', 'Active'),
(5, 'Kazuhiko', 'Nagata', 'Smokey Nagata', 'smokey@garage.com', '$2y$10$IDLQTxsoVNwJWs1D/hpjA.X/J08QxqOuIkoIKYKjbRUrgARpTvoX2', 'Garage Chief', NULL, 1, '2025-12-27 22:01:56', 'Active'),
(6, 'Kenji', 'Kazama', 'Kazama', 'kazama@garage.com', '$2y$10$LpEafAa97h0wdlp/CO4jH.6fchhssWpVW2j2S1FOU1jTxQZB1JVa6', 'Chief Mechanic', NULL, 1, '2025-12-28 22:19:01', 'Active'),
(9, 'Monarah', 'Louisy', 'Narinha', 'monarahlouisy@gmail.com', '$2y$10$2BDUc5UQ.QEWJWaChzUj2eMD5oMBZKlVNGV.WCV9c3ZqE5znjyGL2', 'Chief Mechanic', NULL, 1, '2025-12-28 13:27:27', 'Active');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `catalogo_produtos`
--
ALTER TABLE `catalogo_produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_sku` (`codigo_sku`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `estoque_v2`
--
ALTER TABLE `estoque_v2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_catalogo` (`id_catalogo`);

--
-- Índices para tabela `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_nota` (`numero_nota`);

--
-- Índices para tabela `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_invoice` (`id_invoice`),
  ADD KEY `id_catalogo` (`id_catalogo`);

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
-- AUTO_INCREMENT de tabela `catalogo_produtos`
--
ALTER TABLE `catalogo_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque_v2`
--
ALTER TABLE `estoque_v2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `estoque_v2`
--
ALTER TABLE `estoque_v2`
  ADD CONSTRAINT `estoque_v2_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_produtos` (`id`);

--
-- Limitadores para a tabela `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`id_invoice`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

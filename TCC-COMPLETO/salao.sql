-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21-Ago-2023 às 16:55
-- Versão do servidor: 8.0.17
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `salao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `codigo` int(5) NOT NULL,
  `nomeCliente` varchar(50) NOT NULL,
  `codPessoa` int(5) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `procedimento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `banco`
--

CREATE TABLE `banco` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contascorrente`
--

CREATE TABLE `contascorrente` (
  `codigo` int(5) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `codBanco` int(5) NOT NULL,
  `agencia` int(11) NOT NULL,
  `digitoagencia` varchar(3) NOT NULL,
  `contacorrente` int(11) NOT NULL,
  `digito` varchar(3) NOT NULL,
  `saldoInicial` float NOT NULL,
  `saldoAtual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contaspagar`
--

CREATE TABLE `contaspagar` (
  `codigo` int(5) NOT NULL,
  `parcela` int(5) NOT NULL,
  `codPessoa` int(5) NOT NULL,
  `valor` float NOT NULL,
  `status` varchar(10) NOT NULL,
  `vencimento` date NOT NULL,
  `dataConta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contasreceber`
--

CREATE TABLE `contasreceber` (
  `codigo` int(5) NOT NULL,
  `parcela` int(5) NOT NULL,
  `codPessoa` int(5) NOT NULL,
  `valor` float NOT NULL,
  `status` varchar(10) NOT NULL,
  `vencimento` date NOT NULL,
  `dataConta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupoprodutos`
--

CREATE TABLE `grupoprodutos` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `codProduto` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimento`
--

CREATE TABLE `movimento` (
  `idmovimento` int(11) NOT NULL,
  `idcontareceber` int(11) DEFAULT NULL,
  `parcelareceber` int(11) DEFAULT NULL,
  `idcontapagar` int(11) DEFAULT NULL,
  `parcelapagar` int(11) DEFAULT NULL,
  `datamovimento` int(11) NOT NULL,
  `valorconta` decimal(15,2) NOT NULL,
  `juros` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentoestoque`
--

CREATE TABLE `movimentoestoque` (
  `codigo` int(5) NOT NULL,
  `codProduto` int(5) NOT NULL,
  `origem` varchar(10) NOT NULL,
  `dataMovimento` date NOT NULL,
  `quantidade` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` int(15) NOT NULL,
  `telefone` int(15) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `relacao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `saldoInicial` float NOT NULL,
  `saldoAtual` float NOT NULL,
  `codMarca` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codPessoa` (`codPessoa`);

--
-- Índices para tabela `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `contascorrente`
--
ALTER TABLE `contascorrente`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codBanco` (`codBanco`);

--
-- Índices para tabela `contaspagar`
--
ALTER TABLE `contaspagar`
  ADD PRIMARY KEY (`codigo`,`parcela`),
  ADD KEY `codPessoa` (`codPessoa`);

--
-- Índices para tabela `contasreceber`
--
ALTER TABLE `contasreceber`
  ADD PRIMARY KEY (`codigo`,`parcela`),
  ADD KEY `fk_pessoa` (`codPessoa`);

--
-- Índices para tabela `grupoprodutos`
--
ALTER TABLE `grupoprodutos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codProduto` (`codProduto`);

--
-- Índices para tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `movimento`
--
ALTER TABLE `movimento`
  ADD PRIMARY KEY (`idmovimento`),
  ADD KEY `movto_receber` (`idcontareceber`,`parcelareceber`),
  ADD KEY `movto_pagar` (`idcontapagar`,`parcelapagar`);

--
-- Índices para tabela `movimentoestoque`
--
ALTER TABLE `movimentoestoque`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codProduto` (`codProduto`);

--
-- Índices para tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codMarca` (`codMarca`);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`codPessoa`) REFERENCES `pessoa` (`codigo`);

--
-- Limitadores para a tabela `contascorrente`
--
ALTER TABLE `contascorrente`
  ADD CONSTRAINT `contascorrente_ibfk_1` FOREIGN KEY (`codBanco`) REFERENCES `banco` (`codigo`);

--
-- Limitadores para a tabela `contaspagar`
--
ALTER TABLE `contaspagar`
  ADD CONSTRAINT `contaspagar_ibfk_1` FOREIGN KEY (`codPessoa`) REFERENCES `pessoa` (`codigo`);

--
-- Limitadores para a tabela `contasreceber`
--
ALTER TABLE `contasreceber`
  ADD CONSTRAINT `fk_pessoa` FOREIGN KEY (`codPessoa`) REFERENCES `pessoa` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `grupoprodutos`
--
ALTER TABLE `grupoprodutos`
  ADD CONSTRAINT `grupoprodutos_ibfk_1` FOREIGN KEY (`codProduto`) REFERENCES `produtos` (`codigo`);

--
-- Limitadores para a tabela `movimento`
--
ALTER TABLE `movimento`
  ADD CONSTRAINT `movto_pagar` FOREIGN KEY (`idcontapagar`,`parcelapagar`) REFERENCES `contaspagar` (`codigo`, `parcela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `movto_receber` FOREIGN KEY (`idcontareceber`,`parcelareceber`) REFERENCES `contasreceber` (`codigo`, `parcela`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `movimentoestoque`
--
ALTER TABLE `movimentoestoque`
  ADD CONSTRAINT `movimentoestoque_ibfk_1` FOREIGN KEY (`codProduto`) REFERENCES `produtos` (`codigo`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`codMarca`) REFERENCES `marcas` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

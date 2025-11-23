-- Schema do Sistema de Reserva de Salas
-- Compatível com MySQL/MariaDB 5.x
-- Cria o banco, as tabelas e as FKs conforme o projeto fornecido

CREATE DATABASE IF NOT EXISTS gestaosalas_ds2m DEFAULT CHARACTER SET utf8;
USE gestaosalas_ds2m;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Reserva;
DROP TABLE IF EXISTS Aluno;
DROP TABLE IF EXISTS Professor;
DROP TABLE IF EXISTS Avaliacao;
DROP TABLE IF EXISTS Usuario;
DROP TABLE IF EXISTS Sala;

SET FOREIGN_KEY_CHECKS = 1;

-- Tabela Sala
CREATE TABLE Sala (
  numero_sala VARCHAR(10) NOT NULL,
  capacidade INTEGER,
  recursos_disponiveis VARCHAR(100),
  horario_funcionamento VARCHAR(50),
  PRIMARY KEY (numero_sala)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela Usuario (super-tipo)
CREATE TABLE Usuario (
   email VARCHAR(250) NOT NULL,
   nome  VARCHAR(150) NOT NULL,
   telefone VARCHAR(20),
   PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela Reserva
CREATE TABLE Reserva (
  codigo_reserva VARCHAR(10) NOT NULL,
  data_reserva VARCHAR(20) NOT NULL,
  horario_inicio VARCHAR(20) NOT NULL,
  horario_termino VARCHAR(20) NOT NULL,
  status VARCHAR(20) NOT NULL,
  numero_sala VARCHAR(10) NOT NULL,
  email_usuario VARCHAR(250) NOT NULL,
  PRIMARY KEY (codigo_reserva),
  CONSTRAINT fk_reserva_sala FOREIGN KEY (numero_sala) REFERENCES Sala(numero_sala)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_reserva_usuario FOREIGN KEY (email_usuario) REFERENCES Usuario(email)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Aluno (especialização)
CREATE TABLE Aluno (
   matricula VARCHAR(10) NOT NULL,
   email_usuario VARCHAR(250) NOT NULL,
   PRIMARY KEY (email_usuario),
   CONSTRAINT fk_aluno_usuario FOREIGN KEY (email_usuario) REFERENCES Usuario(email)
     ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Professor (especialização)
CREATE TABLE Professor (
   siape VARCHAR(10) NOT NULL,
   email_usuario VARCHAR(250) NOT NULL,
   PRIMARY KEY (email_usuario),
   CONSTRAINT fk_professor_usuario FOREIGN KEY (email_usuario) REFERENCES Usuario(email)
     ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Avaliacao (opcional)
CREATE TABLE Avaliacao (
  codigo_avaliacao VARCHAR(10) NOT NULL,
  email_usuario VARCHAR(250) NOT NULL,
  comentario VARCHAR(250),
  nota FLOAT,
  numero_sala VARCHAR(10) NOT NULL,
  PRIMARY KEY (codigo_avaliacao),
  CONSTRAINT fk_avaliacao_sala FOREIGN KEY (numero_sala) REFERENCES Sala(numero_sala)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_avaliacao_usuario FOREIGN KEY (email_usuario) REFERENCES Usuario(email)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Índices úteis
CREATE INDEX idx_reserva_data_sala ON Reserva (data_reserva, numero_sala);
CREATE INDEX idx_reserva_status ON Reserva (status);

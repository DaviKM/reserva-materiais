USE reservamateriais;

DROP TABLE IF EXISTS Emprestimo;
DROP TABLE IF EXISTS Aluno;
DROP TABLE IF EXISTS Material;

CREATE TABLE Aluno (
  matricula VARCHAR(20) PRIMARY KEY UNIQUE,
  nome VARCHAR(100),
  curso VARCHAR(50),
  email VARCHAR(100)
);

CREATE TABLE Material (
  id_material INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  categoria VARCHAR(50),
  quantidade_total INT,
  quantidade_disp INT,
  estado VARCHAR(20),
  descricao varchar(200)
);

CREATE TABLE Emprestimo (
  id_emprestimo INT PRIMARY KEY AUTO_INCREMENT,
  id_aluno VARCHAR(20),
  id_material INT,
  data_emprestimo DATE,
  data_devolucao DATE,
  status VARCHAR(20),
  FOREIGN KEY (id_aluno) REFERENCES Aluno(matricula),
  FOREIGN KEY (id_material) REFERENCES Material(id_material)
);


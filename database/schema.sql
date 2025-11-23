use reservamateriais;


drop table if exists emprestimo;
drop table if exists aluno;
drop table if exists material;


CREATE TABLE aluno (
  matricula VARCHAR(20) PRIMARY KEY  unique,
  nome VARCHAR(100),
  turma VARCHAR(50)
);
CREATE TABLE material (
  id_material INT PRIMARY KEY,
  nome VARCHAR(100) ,
  categoria VARCHAR(50),
  quantidade_total INT ,
  quantidade_disp INT ,
  estado VARCHAR(20)
);
CREATE TABLE emprestimo (
  id_emprestimo INT PRIMARY KEY,
  id_aluno varchar(20),
  id_material INT,
  data_emprestimo DATE,
  data_devolucao DATE,
  status VARCHAR(20),
   FOREIGN KEY (id_aluno) REFERENCES aluno(matricula),
  FOREIGN KEY (id_material) REFERENCES material(id_material)
);


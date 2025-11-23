-- Seleciona o banco
USE reservamateriais;


-- ---- INSERIR DADOS NA TABELA ALUNO ----
INSERT INTO aluno (matricula, nome, turma) VALUES
('2025001', 'Ana Souza', '1º DS'),
('2025002', 'Bruno Silva', '2º DS'),
('2025003', 'Carla Mendes', '3º DS'),
('2025004', 'Daniel Rocha', '1º Info'),
('2025005', 'Eduarda Lima', '2º Info');

-- ---- INSERIR DADOS NA TABELA MATERIAL ----
INSERT INTO material (id_material, nome, categoria, quantidade_total, quantidade_disp, estado) VALUES
(1, 'Notebook Lenovo', 'Informática', 10, 6, 'Disponível'),
(2, 'Projetor Epson', 'Audiovisual', 4, 2, 'Disponível'),
(3, 'Câmera DSLR', 'Fotografia', 3, 1, 'Manutenção'),
(4, 'Multímetro Digital', 'Laboratório', 8, 8, 'Disponível'),
(5, 'Tripé Ajustável', 'Acessórios', 5, 4, 'Disponível');

-- ---- INSERIR DADOS NA TABELA EMPRESTIMO ----
INSERT INTO emprestimo (id_emprestimo, id_aluno, id_material, data_emprestimo, data_devolucao, status) VALUES
(101, '2025001', 1, '2025-03-01', '2025-03-03', 'Devolvido'),
(102, '2025002', 2, '2025-03-05', NULL, 'Em aberto'),
(103, '2025003', 5, '2025-03-10', '2025-03-11', 'Devolvido'),
(104, '2025004', 3, '2025-03-12', NULL, 'Atrasado'),
(105, '2025005', 1, '2025-03-15', NULL, 'Em aberto');

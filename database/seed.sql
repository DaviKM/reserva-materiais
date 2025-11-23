-- INSERIR DADOS NA TABELA ALUNO
INSERT INTO Aluno (matricula, nome, curso, email) VALUES
('2025001', 'Ana Souza', 'Desenvolvimento de Sistemas', 'ana.souza@ifrs.edu.br'),
('2025002', 'Bruno Silva', 'Desenvolvimento de Sistemas', 'bruno.silva@ifrs.edu.br'),
('2025003', 'Carla Mendes', 'Informática', 'carla.mendes@ifrs.edu.br'),
('2025004', 'Daniel Rocha', 'Informática', 'daniel.rocha@ifrs.edu.br'),
('2025005', 'Eduarda Lima', 'Redes de Computadores', 'eduarda.lima@ifrs.edu.br');


-- INSERIR DADOS NA TABELA MATERIAL
INSERT INTO Material (nome, categoria, quantidade_total, quantidade_disp, estado, descricao) VALUES
('Notebook Lenovo', 'Informática', 10, 6, 'Disponível',
 'Notebook Lenovo Intel i5, 8GB RAM, SSD 256GB'),
('Projetor Epson X200', 'Audiovisual', 4, 2, 'Disponível',
 'Projetor Epson resolução Full HD para apresentações'),
('Câmera Canon DSLR', 'Fotografia', 3, 1, 'Manutenção',
 'Câmera Canon DSLR utilizada para gravações e fotos'),
('Multímetro Minipa', 'Laboratório', 8, 8, 'Disponível',
 'Multímetro digital para medições elétricas'),
('Tripé Ajustável PRO', 'Acessórios', 5, 4, 'Disponível',
 'Tripé ajustável 1,60m compatível com câmeras e celulares');


-- INSERIR DADOS NA TABELA EMPRESTIMO
INSERT INTO Emprestimo (id_aluno, id_material, data_emprestimo, data_devolucao, status) VALUES
('2025001', 1, '2025-03-01', '2025-03-03', 'Devolvido'),
('2025002', 2, '2025-03-05', NULL, 'Em aberto'),
('2025003', 5, '2025-03-10', '2025-03-11', 'Devolvido'),
('2025004', 3, '2025-03-12', NULL, 'Atrasado'),
('2025005', 1, '2025-03-15', NULL, 'Em aberto');

-- INSERIR DADOS NA TABELA ALUNO
INSERT INTO Aluno (matricula, nome, curso, email) VALUES
('2025001', 'Ana Souza', 'Educação Física', 'ana.souza@ifrs.edu.br'),
('2025002', 'Bruno Silva', 'Educação Física', 'bruno.silva@ifrs.edu.br'),
('2025003', 'Carla Mendes', 'Esporte e Lazer', 'carla.mendes@ifrs.edu.br'),
('2025004', 'Daniel Rocha', 'Educação Física', 'daniel.rocha@ifrs.edu.br'),
('2025005', 'Eduarda Lima', 'Gestão Esportiva', 'eduarda.lima@ifrs.edu.br'),
('2025006', 'Felipe Costa', 'Gestão Esportiva', 'felipe.costa@ifrs.edu.br'),
('2025007', 'Gabriela Alves', 'Esporte e Lazer', 'gabriela.alves@ifrs.edu.br'),
('2025008', 'Henrique Martins', 'Educação Física', 'henrique.martins@ifrs.edu.br');


-- INSERIR DADOS NA TABELA MATERIAL (EQUIPAMENTOS ESPORTIVOS)
INSERT INTO Material (nome, categoria, quantidade_total, quantidade_disp, estado, descricao) VALUES
('Bola de Futebol', 'Bolas', 20, 12, 'Boa', 'Bola oficial tamanho 5, utilizada em treinos e jogos'),
('Rede de Vôlei', 'Redes', 6, 4, 'Boa', 'Rede de vôlei ajustável para quadras internas e externas'),
('Raquete de Tênis', 'Raquetes', 10, 7, 'Quebrado', 'Raquete de nível intermediário, cordas em bom estado'),
('Coletes Treino', 'Acessórios', 30, 10, 'Ruim', 'Conjunto de coletes coloridos para diferenciação de times'),
('Cones de Treinamento', 'Equipamentos', 50, 35, 'Novo', 'Conjunto de cones para demarcação e exercícios de agilidade'),
('Apito', 'Acessórios', 8, 8, 'Boa', 'Apitos de árbitro, feitos em plástico resistente');


-- INSERIR DADOS NA TABELA EMPRESTIMO
INSERT INTO Emprestimo (id_aluno, id_material, data_emprestimo, data_devolucao, status) VALUES
('2025001', 1, '2025-04-01', '2025-04-03', 'Devolvido'),
('2025002', 2, '2025-04-05', '2025-04-12', 'Em aberto'),
('2025003', 3, '2025-04-10', '2025-04-12', 'Devolvido'),
('2025004', 4, '2025-04-12', '2025-04-19', 'Em aberto'),
('2025005', 5, '2025-04-15', '2025-04-16', 'Devolvido'),
('2025006', 5, '2025-04-18', '2025-04-25', 'Em aberto');

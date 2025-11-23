-- Dados de exemplo (seed) do Sistema de Reserva de Salas
USE gestaosalas_ds2m;

-- Salas
INSERT INTO Sala (numero_sala, capacidade, recursos_disponiveis, horario_funcionamento) VALUES
('101', 40, 'Projetor, Ar-condicionado', '08:00-18:00'),
('102', 30, 'Quadro branco, Wi-Fi', '09:00-17:00'),
('103', 50, 'Projetor, Som', '07:00-19:00'),
('104', 20, 'Computadores, Ar-condicionado', '08:00-20:00'),
('105', 25, 'Quadro branco', '08:00-16:00');

-- Usuários
INSERT INTO Usuario (email, nome, telefone) VALUES
('ana.aluno@example.com', 'Ana Aluno', '11988880001'),
('bruno.aluno@example.com', 'Bruno Aluno', '11988880002'),
('karen.prof@example.com', 'Karen Professor', '11999990001');

-- Alunos
INSERT INTO Aluno (matricula, email_usuario) VALUES
('202301', 'ana.aluno@example.com'),
('202302', 'bruno.aluno@example.com');

-- Professores
INSERT INTO Professor (siape, email_usuario) VALUES
('S1001', 'karen.prof@example.com');

-- Reservas (ativadas)
INSERT INTO Reserva (codigo_reserva, data_reserva, horario_inicio, horario_termino, status, numero_sala, email_usuario) VALUES
('R1', '2025-11-10', '08:00', '10:00', 'ativa', '101', 'ana.aluno@example.com'),
('R2', '2025-11-10', '10:00', '12:00', 'ativa', '101', 'bruno.aluno@example.com');

-- Avaliações
INSERT INTO Avaliacao (codigo_avaliacao, email_usuario, comentario, nota, numero_sala) VALUES
('A1', 'ana.aluno@example.com', 'Boa', 4.5, '101');

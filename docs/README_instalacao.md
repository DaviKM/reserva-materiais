# Sistema de Reserva de Salas — Primeira Versão Funcional

**Tecnologias:** PHP 5.x + PDO, MySQL/MariaDB 5.x, XAMPP

## Pré-requisitos
- XAMPP instalado e rodando (Apache e MySQL).
- PHP 5.x (o PHP do XAMPP é suficiente).
- Navegador web.

## Instalação
1. Copie a pasta `gestaosalas_app/` para o diretório `htdocs/` do XAMPP.
2. Inicie **Apache** e **MySQL** no painel do XAMPP.
3. Crie o banco e as tabelas:
   - Abra o cliente SQL (phpMyAdmin, DBeaver ou mysql cli).
   - Execute o conteúdo de `database/schema.sql`.
   - Execute o conteúdo de `database/seed.sql` para dados de exemplo.
4. Acesse a aplicação em: `http://localhost/gestaosalas_app/public/index.php`.

> Se necessário, ajuste usuário/senha do banco em `config/db.php`.

## Rotas principais
- `?entidade=sala&acao=listar` — CRUD de salas.
- `?entidade=reserva&acao=listar` — CRUD de reservas (criar, editar, excluir, cancelar).
- `?entidade=reserva&acao=por_dia` — consulta de reservas por data (e opcionalmente por sala).

## Regras de negócio implementadas
- **RF01–RF06:** CRUD de Sala e de Reserva, consulta por dia e cancelamento de reservas.
- **RF04 (Conflitos):** verificação de conflito na criação/edição de reserva (sobreposição de intervalo para mesma sala).
- **RNF02 (Segurança):** uso de PDO com prepared statements, escaping com `htmlspecialchars`, e token CSRF mínimo em formulários POST.

## Observações
- Os horários são strings no formato `HH:MM`; a verificação de sobreposição usa comparação lexicográfica, que funciona nesse formato.
- Para demonstrar, foi incluído um seed com reservas no mesmo dia em sequência (sem conflito).
- A exclusão de sala pode falhar se houver reservas associadas (restrição de FK). Use editar/cancelar reservas primeiro.

## Próximos passos sugeridos
- Autenticação por usuário/senha e perfis (aluno/professor/secretaria).
- Paginação e busca nas listagens.
- Exportação CSV da agenda do dia.
- CSS/UX aprimorados (layouts em `views/layout`).


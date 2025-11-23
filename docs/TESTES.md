# Registro de Testes — Versão Funcional

## Ambiente
- XAMPP com Apache e MySQL ativos.
- Base criada via `database/schema.sql` e populada com `database/seed.sql`.

## Casos de teste (amostra)
1. **Criar sala válida**
   - Ação: criar sala 106 com capacidade 35, recursos "Projetor", horário "09:00-18:00"
   - Resultado esperado: aparece na listagem de salas.

2. **Criar reserva válida (sem conflito)**
   - Ação: data `2025-11-11`, 08:00–10:00, sala `101`, usuário `ana.aluno@example.com`
   - Resultado esperado: reserva criada, listada em `Reservas`.

3. **Criar reserva **conflitante** (mesma sala/mesmo dia, intervalo sobreposto)**
   - Pré-condição: existe `R1` 08:00–10:00 em `2025-11-10` na sala `101`.
   - Ação: criar outra 09:00–09:30 no mesmo dia/sala.
   - Resultado esperado: mensagem "Conflito de horário..." e **não** cria.

4. **Editar reserva para horário inválido (início >= término)**
   - Resultado esperado: erro de validação no formulário.

5. **Cancelar reserva ativa**
   - Ação: cancelar uma reserva com status `ativa`.
   - Resultado esperado: status muda para `cancelada` na listagem.

6. **Listar reservas por dia**
   - Ação: informar data existente; opcionalmente filtrar por sala.
   - Resultado esperado: tabela mostra as reservas do dia ordenadas por horário.

## Evidências
- Recomenda-se capturar prints de tela durante execução dos testes.

8. Exclusão de sala com reservas vinculadas — deve exibir mensagem amigável orientando a cancelar/excluir reservas antes.

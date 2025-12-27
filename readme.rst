__________________________________________________________
   |                                                          |
   |   GARAGE 90' PARTS DATABASE MANAGER - VERSION 0.1.0      |
   |   SYSTEM_CORE: CodeIgniter 3 // STICKER: JDM_STYLE       |
   |__________________________________________________________|

##SOBRE O PROJETO##
O GARAGE 90' é um sistema de gerenciamento de estoque (CRUD) especializado em peças de alta performance para veículos japoneses fabricados entre 1970 e 1999. O visual é inspirado em softwares de diagnóstico e catálogos de peças da era de ouro do tuning japonês, utilizando layouts baseados em tabelas HTML puras (sem frameworks modernos).


ESTRUTURA DO SISTEMA (MAPA DE ACESSO)
    AUTHENTICATION: Acesso restrito via Login/Senha (Criptografia Bcrypt).

    ADMIN_PANEL: Gestão de operadores (mecânicos e administradores).

    STOCK_CONTROL: Inventário detalhado de peças (do Motor às Rodas).

    INVOICE_ENTRY: Sistema de entrada de notas (Registro de novos componentes).

    DISPATCH_LOG: Painel de saída de notas com registro de destino.


🏁 STATUS DE DESENVOLVIMENTO
[x] v0.1.0 (AUTHENTICATION): Tela de login JDM Style e proteção de rotas.

[ ] v0.2.0 (OPERATORS): Painel Administrativo para gerir usuários.

[ ] v0.3.0 (PARTS_INV): Implementação do banco de dados de peças.

[ ] v0.4.0 (LOGISTICS): Entrada e Saída de Notas (Invoices).

REQUISITOS TÉCNICOS
PHP: 7.4 ou superior

FRAMEWORK: CodeIgniter 3 (The Raw King)

UI: 100% Table-based (No CSS Frameworks / Retro-Web)
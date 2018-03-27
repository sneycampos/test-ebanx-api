# Teste com API do Ebanx
##### Realizando pagamentos via Cartão de Crédito ou Boleto Bancário

### Instalação do projeto

- Clonar este projeto no GitHub
- Instalar pacotes via composer: `composer update`
- Configurar `.env` para conexão com banco de dados: `cp .env.example .env`
- Criar tabelas com migrations: `php artisan migrate`
- Alimentar tabela de planos com: `php artisan db:seed --class=PlansSeeder`

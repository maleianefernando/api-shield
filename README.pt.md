# API-SHIELD

Uma biblioteca Laravel projetada para adicionar camadas de segurança a APIs, garantindo a integridade e autenticidade dos dados, além de prevenir outros problemas de segurança, como ataques DoS e DDoS, ataques de repetição e ataques de inundação.

## Funcionalidades

* **📦 Middleware integrado**: Dispõe de um middleware nativo que funciona como uma camada unificada de proteção
* **🔐 Validação de assinaturas HMAC**: Utiliza um hash baseado num segredo e os dados da requisição como conteúdo de entrada, garantindo a integridade dos dados
* **✅ Validação do timestamp da requisição**: Cada requisição possui o seu próprio timestamp ou marcação temporal, permitindo ao servidor verificar a atualidade da requisição
* **🔑 Validação do identificador da requisição**: Cada requisição possui um identificador único, permitindo detetar a repetição da mesma
* **🔐 Registo das requisições para auditoria**: Todas as requisições que passam por esta biblioteca são registados em logs
* **🔄 Integração com Laravel**: Integração nativa com o Laravel para funcionar como middleware, incluindo a publicação das configurações


## Instalação

Pode ser instalado via composer seguindo as instruções:
1. Adicionar o repositoro ao ficheiro `composer.json`:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/maleianefernando/api-shield.git"
    }
],
```

2. Instalar a biblioteca atravéz do comando abaixo:
```bash
composer require maleianefernando/api-shield:main-dev
```

## Integração com o Laravel
### Publicar configurações e migrations da base de dados
```bash
php artisan vendor:publish --tag=apishield
```
O comando acima serve para publicar as configurações da biblioteca no projecto, ela aparecem em `config/api-shield.php`. Para alem de configuracoes esse comando publica uma migration da base de dados responsavel pela criacao da tabela para armazenamento de todas informações de rastreabilidade e auditoria.

### Executar a migration

```bash
php artisan migrate
```
O comando acima serve para definitivamente criar a tabela `api_shield_audit_logs` na base de dados.

### Configuração

Para configurar a biblioteca são adicionadas as seguintes variáveis de ambiente ao ficheiro `.env`:

```env
AS_SECRET='sua-chave' #Chave para geraçao do HMAC
AS_NONCE_TTL=900                            # Tempo em segundos para armazenamento do nonce no servidor
# AS_NONCE_PREFIX                           # O prefixo para o nonce no servidor (opcional)
AS_TIMESTAMP_LIMIT=900                      # Intervalo de tempo em segundos no qual uma requisição é válida
AS_SOFT_RATE_LIMIT=60                       # Primeiro limite de requisições por cliente que quando atingido, as requisições são desaceleradas
AS_HARD_RATE_LIMIT=120                      # Segundo limite de requisições que quando atingido o cliente é bloqueado
AS_DECAY_RATE_SECONDS=120                   # Tempo em segundos para validação dos limites acima
AS_REQUEST_BLOCK_PERIOD=900                 # Tempo em segundos de bloqueio de um cliente
```

### Chave / Secret

* Recomenda-se gerar a chave ou secret em [https://randomkeygen.com/encryption-key](https://randomkeygen.com/encryption-key)
* Recomenda-se gerar uma chave de 256-bit (32 bytes) na categoria Encription Keygen

## Utilização

### Utilização básica

```php
Route::get('/perfil', function () {
    // Lógica
})->middleware('api-shield');
```

Ou:

```php
Route::middleware(['api-shield'])->group(function () {
    Route::get('/perfil', function () { ... });
    Route::get('/perfil/editar', function () { ... });
});
```

### Objectos de resposta

Quando a requisição o é reconhecido pela biblioteca como legítimo, não é retornado nenhum resultado. No entanto, quando a biblioteca deteta algum problema ou inconsistência, são retornados erros:

Todas as respostas tem a seguinte estrutura:

```json
{
    "status": "Error",
    "message": "Invalid request timestamp."
}
```


#### Possível ataque de repetição (Replay attack) detectado
1. Quando o servidor reconhece o identificado da requisição de uma requisição antiga, o middleware detecta e retorna:

```json
{
    "status": "Error",
    "message": "Possible replay attack detected."
}
```


#### Segurança do ficheiro comprometida
1. Se existir algum ficheiro na requisição e esse mesmo ficheiro tiver sofrido alguma adulteração durante a requisição, o servidor detectará: 
```json
{
    "status": "Error",
    "message": "Uploaded file integrity compromised."
}
```

#### Possível ataque de manipulação de dados (Data manipulation attack) detectado
1. Quando o HMAC calculado e enviado pelo cliente não coinscide com o  HMAC calculado pelo servidor, o middleware detecta e interpreta o fenômeno como uma ataque de manipulação de dados:

```json
{
    "status": "Error",
    "message": "Possible data manipulation attack detected."
}
```

#### Ataque de inundação (Flood attack)
1. Quando o cliente atinge todos os limites estabelecidos no servidor, o cliente é bloqueado e o middleware retorna:

```json
{
    "status": "Error",
    "message": "Too many requests."
}
```

## Estrutura do projecto
```
src/
├── database/
│   └── 2026_05_20_170626_create_api_shield_audit_logs_table.php
├── Facades/
│   ├── Audit.php
|   ├── Hmac.php
|   ├── Nonce.php
|   ├── RateLimit.php
|   ├── ShieldUtils.php
│   └── Timestamp.php
├── Middleware/
│   └── ApiShieldMiddleware.php
├── Models/
│   └── ApiShieldAuditLog.php
├── Providers/
│   └── ApiShieldServiceProvider.php
├── Services/
│   ├── AuditService.php
|   ├── HmacService.php
|   ├── NonceService.php
|   ├── RateLimitService.php
│   └── TimestampService.php
└── Utilities/
    └── UtilitiesService.php
```

## Testes

```bash
# Executar uma teste especifico
./vendor/bin/phpunit tests/Test/HmacTest.php
./vendor/bin/phpunit tests/Test/HmacTest.php
```

### Executando Testes

```bash
composer install

# Executar tesre
./vendor/bin/phpunit

# executar com output detalhado
./vendor/bin/phpunit --verbose

# Executar um teste especifico
.-vendor/bin/phpunit tests/Test/HmacTest.php
```

### Registro de alterações

Por favor verifique o ficheiro [CHANGELOG](CHANGELOG.md) para informações sobre alterações.

## Contribuições

Por favor veja o ficheiro [CONTRIBUTING](CONTRIBUTING.md) para detalhes.

## Creditos

- [Fernando Maleiane](https://github.com/maleianefernando)
- [Todos os contribuintes](../../contributors)

# Desafio técnico Objective

## Como iniciar
- Faça uma cópia do arquivo `.env.example` para `.env`
- Execute o comando:
```shell
docker compose up -d
```

## Como executar os testes
Execute o comando:
```shell
docker exec php composer test  
```

## Endpoints com as implementações

### 1. Criação de Conta com Saldo de R$ 500,00
```shell
curl -X POST localhost:8081/conta/criacao/bonus
```


### 2. Busca de Conta por Id
```shell
curl "localhost:8081/conta?id=1"
```

### 3. Depósito em Conta
```shell
curl -X POST localhost:8081/conta -H "Content-Type: application/json" -d '{"conta_id": 1, "valor": 200 }'
```

Exemplo de corpo em JSON:

```json
{
  "conta_id": 1,
  "valor": 200
}
```

### 4. Efetuação de compra utilizando Forma de Pagamento
```shell
curl -X POST localhost:8081/transacao -H "Content-Type: application/json" -d '{"conta_id": 1, "valor": 200, "forma_pagamento": "C" }'
```

Exemplo de corpo em JSON:

```json
{
  "conta_id": 1,
  "valor": 200,
  "forma_pagamento": "C"
}
```

### 5. Transferência entre Contas Bancárias
```shell
curl -X POST localhost:8081/transacao/transferencia -H "Content-Type: application/json" -d '{"conta_origem_id": 2, "conta_destino_id": 1, "valor": 200, "forma_pagamento": "P" }'
```

Exemplo de corpo em JSON:

```json
{
  "conta_origem_id": 2,
  "conta_destino_id": 1,
  "valor": 200,
  "forma_pagamento": "P"
}
```
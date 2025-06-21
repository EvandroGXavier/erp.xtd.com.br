# erp.xtd.com.br

Pequeno exemplo de cadastro de contas bancárias.

## Instalação

Requer Python 3.11+. Instale as dependências de teste com:

```bash
pip install pytest
```

## Uso

Crie uma conta e liste contas usando o CLI:

```bash
python -m bank.main create "Alice" --balance 100
python -m bank.main list
```

Os dados são armazenados em `accounts.json` por padrão.

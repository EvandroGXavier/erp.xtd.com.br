#!/usr/bin/env bash

# Caminho do arquivo de view
FILE="/www/wwwroot/erp.xtd.com.br/resources/views/contatos/contato_list.blade.php"

# Cria backup com timestamp
BACKUP="${FILE}.bak_$(date +%Y%m%d%H%M%S)"
cp "$FILE" "$BACKUP"

# 1) No cabeçalho: após CPF/CNPJ, adiciona Nome/Razão
sed -i '/<th style="width: 15%;">CPF\/CNPJ<\/th>/a \                            <th style="width: 20%;">Nome\/Razão<\/th>' "$FILE"

# 2) Remove colunas Tipo e Cidade do <thead>
sed -i '/<th style="width: 10%;">Tipo<\/th>/d' "$FILE"
sed -i '/<th style="width: 10%;">Cidade<\/th>/d' "$FILE"

# 3) No corpo da tabela: após o <td>{{ $contato->cpf_cnpj }}, insere <td>{{ $contato->nome }}</td>
sed -i '/<td>{{ \$contato->cpf_cnpj }}/a \                            <td>{{ \$contato->nome }}</td>' "$FILE"

# 4) Remove os <td> de tipo_pessoa e cidade
sed -i '/<td>{{ \$contato->tipo_pessoa }}<\/td>/d' "$FILE"
sed -i '/<td>{{ \$contato->cidade }}<\/td>/d' "$FILE"

echo "✔ contato_list.blade.php atualizado. Backup salvo em: $BACKUP"

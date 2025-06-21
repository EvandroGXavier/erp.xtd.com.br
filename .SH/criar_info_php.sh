#!/bin/bash
# ================================
# Script: Criar info.php
# Data: 2025-06-12
# Função: Diagnóstico PHP e acesso HTTP
# Execução: chmod +x && ./criar_info_php.sh
# ================================

echo "🧠 Criando arquivo info.php na pasta public/"
cat > public/info.php <<'PHP'
<?php
phpinfo();
PHP

echo "🔐 Corrigindo permissões..."
chown www:www public/info.php
chmod 644 public/info.php

echo "✅ Arquivo criado com sucesso!"
echo "Acesse via navegador: http://erp.xtd.com.br/info.php"

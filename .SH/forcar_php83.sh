#!/bin/bash
# ================================
# Script: Forçar uso do PHP 8.3
# Data: 2025-06-12
# Função: Criar aliases php83 e artisan usando PHP 8.3
# Execução: chmod +x && ./forcar_php83.sh
# ================================

echo "🔧 Criando alias php83 e artisan para terminal..."

if grep -q "alias php83=" ~/.bashrc; then
    echo "⚠️ Alias já existe. Pulando."
else
    echo "alias php83='/www/server/php/83/bin/php'" >> ~/.bashrc
    echo "alias artisan='/www/server/php/83/bin/php artisan'" >> ~/.bashrc
    echo "✅ Alias adicionados ao ~/.bashrc"
fi

echo "♻️ Recarregando terminal para aplicar mudanças..."
source ~/.bashrc

echo "✅ PHP 8.3 pronto para uso com 'php83' e 'artisan'"
echo "Exemplo: php83 -v ou artisan route:list"

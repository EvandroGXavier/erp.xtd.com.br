#!/bin/bash
# ================================
# Script: Verificação do Sistema Laravel
# Data: 2025-06-09
# Função: Validar Laravel, PHP, permissões e conexão .env
# Execução: chmod +x && ./verificar_sistema_laravel.sh
# PHP: 8.3 (forçado via aaPanel)
# ================================

PHP="/www/server/php/83/bin/php"
echo "🔍 Verificando versão do PHP..."
$PHP -v

echo "📦 Verificando Laravel..."
$PHP artisan --version

echo "📁 Corrigindo permissões..."
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "🔑 Validando .env..."
grep -E 'DB_DATABASE|DB_USERNAME|DB_PASSWORD' .env

echo "🔁 Testando conexão com banco de dados..."
$PHP artisan migrate:status || echo "⚠️ Erro na conexão com banco. Verifique .env"

echo "🌐 Verificando rotas disponíveis..."
$PHP artisan route:list

echo "✅ Verificação finalizada!"

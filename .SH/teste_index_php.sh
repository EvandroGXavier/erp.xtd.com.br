#!/bin/bash
# ================================
# Script: teste_index_php.sh
# Data: 2025-06-12
# Função: Inserir teste no public/index.php
# ================================

echo "📁 Criando backup do arquivo original..."
cp public/index.php public/index.php.bak

echo "🔍 Inserindo teste visível no topo do index.php..."
sed -i "1s;^;<?php echo '<div style=\"padding:10px;background:#ffc;color:#000;font-weight:bold;\">✔️ INDEX.PHP ACESSADO DIRETAMENTE</div>'; ?>\n;" public/index.php

echo "✅ Teste adicionado. Acesse http://erp.xtd.com.br e verifique se aparece a mensagem ✔️ INDEX.PHP ACESSADO DIRETAMENTE"
echo "🧼 Para restaurar, execute:"
echo "mv public/index.php.bak public/index.php"

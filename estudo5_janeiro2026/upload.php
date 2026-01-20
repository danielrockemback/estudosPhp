<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arquivo = $_FILES['foto'];

    // Verificar erros
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        die("Erro no upload: " . $arquivo['error']);
    }

    // Validar tipo
    $tiposPermitidos = ['image/jpeg', 'image/png'];

    if (!in_array($arquivo['type'], $tiposPermitidos)) {
        die("Tipo de arquivo não permitido.");
    }

    // Validar tamanho (máx 2MB)
    if ($arquivo['size'] > 2 * 1024 * 1024) {
        die("Arquivo muito grande. Máx 2MB.");
    }

    // Gerar nome único
    $nomeUnico = uniqid() . "-" . basename($arquivo['name']);
    $destino = __DIR__ . "/uploads/" . $nomeUnico;

    // Movendo a foto para um diretório especifíco
    if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
        echo "Upload realizado com sucesso! Arquivo salvo em: $destino";

    } else {
        echo "Erro ao mover arquivo.";
    }
}


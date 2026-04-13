<?php
// Configurações do seu servidor
$dns = "http://playcine.cloud"; 
// Se precisar de porta no futuro, mude para "http://playcine.cloud:8080"

function consultarVencimento($usuario, $senha, $dns) {
    // URL da API do Xtream Codes (padrão da maioria dos painéis)
    $url = $dns . "/player_api.php?username=" . $usuario . "&password=" . $senha;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $resposta = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($resposta, true);

    // Verifica se o login é válido e pega a data
    if (isset($dados['user_info']['exp_date'])) {
        $timestamp = $dados['user_info']['exp_date'];
        
        if ($timestamp == null || $timestamp == "unlimited") {
            return "Vitalício";
        }
        
        return date("d/m/Y", $timestamp);
    } else {
        return "Erro ao consultar";
    }
}
?>

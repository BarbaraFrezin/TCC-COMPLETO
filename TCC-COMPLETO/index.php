<?php
if (isset($_COOKIE['login'])) {
    // O cookie de login existe, redirecione para a página de agendamento
    header("Location: home.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    // Os dados de login foram enviados pelo formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifique as credenciais aqui (substitua isso pelo seu sistema de autenticação)
    if ($username == 'seu_nome_de_usuario' && $password == 'sua_senha') {
        // Credenciais corretas, defina o cookie de login
        setcookie('login', $username, time() + 3600, '/'); // Define o cookie por 1 hora
        header("Location: home.php");
        exit;
    } else {
        // Credenciais incorretas, exiba uma mensagem de erro ou redirecione para a página de login novamente
        echo "Credenciais incorretas. <a href='login.html'>Tente novamente</a>";
    }
} else {
    // Nenhum cookie e nenhum envio de dados de login, redirecione para a página de login
    header("Location: login.html");
    exit;
}
?>

<?php
// Inclua o arquivo de configuração do banco de dados
include('config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minha Página Inicial</title>
  <link rel="stylesheet" href="estilo.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      display: flex;
      align-items: stretch;
    }

    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      color: #ecf0f1;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      z-index: 1;
      transition: width 0.3s;
    }

    .sidebar:hover {
      width: 300px;
    }

    .sidebar h2 {
      text-align: center;
      color: #ecf0f1;
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .sidebar ul li a {
      display: block;
      padding: 10px;
      margin-bottom: 5px;
      border-radius: 4px;
      text-decoration: none;
      color: #ecf0f1;
      transition: background-color 0.3s;
    }

    .sidebar ul li a:hover {
      background-color: #34495e;
    }

    .content {
      flex: 1;
      padding: 20px;
    }

    h1 {
      color: #2c3e50;
    }

    canvas {
      width: 100%;
      max-width: 800px;
      margin: 35px auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .submenu {
    display: none;
  }
  </style>
</head>

<body>

<div class="container">
    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
      <h2>SERVIÇOS</h2>
      <ul>
        <li>
          <a href="#" onclick="toggleSubMenu('financeiro')">Financeiro</a>
          <ul id="financeiro" class="submenu">
            <li><a href="banco.php">Bancos</a></li>
            <li><a href="contaspagar.php">Contas a Pagar</a></li>
            <li><a href="contasreceber.php">Contas a Receber</a></li>
            <li><a href="movimentoPagar.php">Movimento Pagar</a></li>
            <li><a href="movimentoReceber.php">Movimento Receber</a></li>
            <li><a href="contascorrentes.php">Contas Corrente</a></li>
            <!-- Adicione outros itens do menu financeiro conforme necessário -->
          </ul>
        </li>
        <br>
        <li>
          <a href="#" onclick="toggleSubMenu('estoque')">Estoque</a>
          <ul id="estoque" class="submenu">
            <li><a href="marcas.php">Marcas</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="grupoprodutos.php">Grupo Produtos</a></li>
            <li><a href="movimentoEstoque.php">Movimento do Estoque</a></li>
            <!-- Adicione outros itens do menu financeiro conforme necessário -->
          </ul>
        </li>

        <li>
            <li><a href="pessoa.php">Pessoas</a></li>
            
            <!-- Adicione outros itens do menu financeiro conforme necessário -->
        </li>
        <li>
            <li><a href="agendamento.php">Agendamentos</a></li>
            
            <!-- Adicione outros itens do menu financeiro conforme necessário -->
        </li>

      </ul>
    </div>

    <!-- Conteúdo da página -->
    <div class="content">
      <h1>Bem-vindo</h1>
      <p>Explore os serviços disponíveis na barra lateral. Aqui está um gráfico representando as contas a pagar e a receber.</p>
      <!-- Gráfico de barras empilhadas -->
      <canvas id="myChart"></canvas>

      <?php
      // Conecte-se ao banco de dados
      if (!$con) {
        die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
      }

      // Calcular o total de contas a pagar
      $queryContasPagar = "SELECT SUM(valor) AS total FROM contaspagar";
      $resultContasPagar = mysqli_query($con, $queryContasPagar);
      $rowContasPagar = mysqli_fetch_assoc($resultContasPagar);
      $totalContasPagar = $rowContasPagar['total'];

      // Calcular o total de contas a receber
      $queryContasReceber = "SELECT SUM(valor) AS total FROM contasreceber";
      $resultContasReceber = mysqli_query($con, $queryContasReceber);
      $rowContasReceber = mysqli_fetch_assoc($resultContasReceber);
      $totalContasReceber = $rowContasReceber['total'];

      mysqli_close($con);
      ?>
    <style>
    .btn-whatsapp {
        background-color: #286090;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E;
    }
</style>

<div style="position: fixed; top: 10px; right: 10px;">
    <a class="btn btn-whatsapp" href="https://contate.me/eaglesystem" target="_blank">Dúvidas</a>
</div>


      <script>

        

function toggleSubMenu(submenuId) {
    var submenu = document.getElementById(submenuId);

    // Verifica se o estilo atual é 'none' (invisível)
    if (submenu.style.display === 'block' || submenu.style.display === '') {
        // Se invisível, torna visível
        submenu.style.display = 'none';
    } else {
        // Se visível, torna invisível
        submenu.style.display = 'block';
    }
}
        // Dados dos valores (substitua esses dados com consultas ao banco de dados)
        const totalContasPagar = <?php echo $totalContasPagar; ?>;
        const totalContasReceber = <?php echo $totalContasReceber; ?>;

        // Crie um gráfico de barras
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Contas a Pagar', 'Contas a Receber'],
            datasets: [{
              label: 'Total a pagar',
              data: [totalContasPagar, totalContasReceber],
              backgroundColor: ['#e74c3c', '#32CD32'],
              borderColor: ['#c0392b', '#32CD32'],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>

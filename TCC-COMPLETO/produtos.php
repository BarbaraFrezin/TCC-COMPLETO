<?php
include('config.php');
include('auth.php');

//------- pesquisa marcas
$sql_marcas = "SELECT codigo,nome FROM marcas";
$res_marcas = mysqli_query($con,$sql_marcas);

//------- pesquisa grupoprodutos


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo       = $_POST['codigo'];
  $nome         = $_POST['nome'];
  $descricao    = $_POST['descricao'];
  $saldoInicial = $_POST['saldoInicial'];
  $saldoAtual   = $_POST['saldoAtual'];
  $codMarca     = $_POST['codMarca'];
  

    if (isset($_POST['cadastrar'])) {
        // Query para cadastrar no banco de dados
        $sql_cadastrar = "INSERT INTO produtos (codigo, nome, descricao, saldoInicial, saldoAtual, codMarca) VALUES ('$codigo', '$nome', '$descricao', '$saldoInicial', '$saldoAtual', '$codMarca')";
        $res_cadastrar = mysqli_query($con,$sql_cadastrar);

        if ($res_cadastrar) {
            echo '<script>alert("Registro cadastrado com sucesso!");</script>';
            echo '<script>window.location="produtos.php";</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar registro!");</script>';
        }
    }

    if (isset($_POST['alterar'])) {
        // Query para alterar no banco de dados
        $sql_alterar = "UPDATE produtos SET nome='$nome', descricao='$descricao', saldoInicial='$saldoInicial', saldoAtual='$saldoAtual', codMarca='$codMarca' WHERE codigo='$codigo'";
        $res_alterar = mysqli_query($con,$sql_alterar);

        if ($res_alterar) {
            echo '<script>alert("Registro alterado com sucesso!");</script>';
            echo '<script>window.location="produtos.php";</script>';
        } else {
            echo '<script>alert("Erro ao alterar registro!");</script>';
        }
    }

    if (isset($_POST['excluir'])) {
        // Query para excluir no banco de dados
        $sql_excluir = "DELETE FROM produtos WHERE codigo='$codigo'";
        $res_excluir = mysqli_query($con,$sql_excluir);

        if ($res_excluir) {
            echo '<script>alert("Registro excluído com sucesso!");</script>';
            echo '<script>window.location="produtos.php";</script>';
        } else {
            echo '<script>alert("Erro ao excluir registro!");</script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylo.css">
  <script defer src="script.js"></script>
  <title>Barra de Navegação com Logo</title>
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo3.png.png" alt="Logo da empresa">
    </div>
  
  </header>
</body>
</html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>PRODUTOS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
    <script>
        
        /*
        document.getElementById('cod').value vira simplesmente $("#cod").val()
        */

        function obterDadosModal(valor) {

            var retorno = valor.split("*");

            document.getElementById('codigo').value   = retorno[0];
            document.getElementById('nome').value  = retorno[1];
            document.getElementById('descricao').value  = retorno[2];
            document.getElementById('saldoInicial').value  = retorno[3];
            document.getElementById('saldoAtual').value  = retorno[4];
            document.getElementById('codMarca').value  = retorno[5];
            
        }

    </script>

    <!-- Modal Cadastrar -->
    <div class="modal fade" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>CADASTRAR PRODUTO</h1>
                </div>
                <div class="modal-body">
                    <!-- Modal com form para se fazer cadastro  -->
                    <form class="form-group well" action="produtos.php" method="POST">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="saldoInicial">Saldo Inicial</label>
                            <input type="text" name="saldoInicial" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="saldoAtual">Saldo Atual</label>
                            <input type="text" name="saldoAtual" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="codMarca">Código Marca</label>
                            <select name="codMarca" id="codMarca" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                while ($resultado = mysqli_fetch_array($res_marcas)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' . utf8_encode($resultado['nome']) . '</option>';
}
                                ?>
                            </select>
                        </div>


                        <button type="submit" class="btn btn-success btn-block" name="cadastrar">Cadastrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alterar -->
    <div class="modal fade" id="myModalAlterar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>ALTERAR REGISTRO</h1>
                </div>
                <div class="modal-body">
                    <!-- Modal com form para se fazer alteracao -->
                    <form class="form-group well" action="produtos.php" method="POST">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="saldoInicial">Saldo Inicial</label>
                            <input type="text" name="saldoInicial" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="saldoAtual">Saldo Atual</label>
                            <input type="text" name="saldoAtual" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="codMarca">Código Marca</label>
                            <select name="codMarca" id="codMarca" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                while ($resultado = mysqli_fetch_array($res_pessoa)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' .
                                        utf8_encode($resultado['nome']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                      
                        <button type="submit" class="btn btn-success btn-block" name="alterar">Alterar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="myModalExcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>EXCLUIR REGISTRO</h1>
                </div>
                <div class="modal-body">
                    <!-- Modal com form para excluir -->
                    <form class="form-group well" action="produtos.php" method="POST">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input id="codigo" type="text" name="codigo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block" name="excluir">Excluir</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h2 class="text-center">TABELA DE PRODUTOS</h2>
            <form action="produtos.php" method="POST" class="form-inline">
                <div class="form-group">
                    <input type="text" name="codigo" placeholder="PESQUISA POR CÓDIGO" class="form-control" style="margin-bottom: 10px;">
                </div><br>
                <button type="submit" name="pesquisar" class="btn btn-primary">Pesquisar</button>
                <button type="button" name="cadastrar" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Cadastrar</button>
            </form><br><br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Descricao</th>
                    <th>Saldo Inicial</th>
                    <th>Saldo Atual</th>
                    <th>Cod Marca</th>
                    <th>Operacao</th>
                </tr>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['pesquisar'])) {
                        $codigo = strtoupper($_POST['codigo']);
                        $consulta = "SELECT codigo, nome, descricao, saldoInicial, saldoAtual, codMarca FROM produtos WHERE UPPER(codigo) LIKE '%$codigo%'";
                        $resultado = mysqli_query($con, $consulta);
                    
                        if (!$resultado) {
                            echo "Erro na pesquisa: " . mysqli_error($con);
                        }
                    } else {
                        $consulta = "SELECT codigo, nome, descricao, saldoInicial, saldoAtual, codMarca FROM produtos";
                        $resultado = mysqli_query($con, $consulta);
                    }

                    while ($dados = mysqli_fetch_array($resultado)) {
                        $strdados = $dados['codigo'] . "*" . $dados['nome'] . "*" . $dados['descricao'] . "*" . $dados['saldoInicial'] . "*" . $dados['saldoAtual'] . "*" . $dados['codMarca'];
                    ?>
                        <tr>
                        <td><?php echo $dados['codigo']; ?></td>
                        <td><?php echo $dados['nome']; ?></td>
                        <td><?php echo $dados['descricao']; ?></td>
                        <td><?php echo $dados['saldoInicial']; ?></td>
                        <td><?php echo $dados['saldoAtual']; ?></td>
                        <td><?php echo $dados['codMarca']; ?></td>
                       
                            <td>
                                <a href="#myModalExcluir" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                    <button type='button' id='excluir' name='excluir' class='btn btn-danger' data-toggle='modal' data-target='#myModalExcluir'>Excluir</button>
                                </a>
                                <a href="#myModalAlterar" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                    <button type='button' id='alterar' name='alterar' class='btn btn-primary' data-toggle='modal' data-target='#myModalAlterar'>Alterar</button>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    mysqli_close($con);
                    ?>
                </tbody>
            </table>
            <div style="margin-top: 10px;">
    <button class="btn btn-primary" onclick="window.location.href='home.php'">Voltar</button>
</div>

        </div>
       
    </div>
    <style>
  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #2c3e50;
    color: #ffffff;
    text-align: center;
    padding: 5px;
  }
</style>

<footer>
  Desenvolvido por Eagle System
</footer>

    <!-- Bibliotecas JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>

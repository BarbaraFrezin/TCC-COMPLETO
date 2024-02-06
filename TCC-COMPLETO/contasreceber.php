<?php
include('config.php');
include('auth.php');


$sql_pessoa = "SELECT codigo, nome FROM pessoa";
$res_pessoa = mysqli_query($con,$sql_pessoa);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $parcela = $_POST['parcela'];
    $codPessoa = $_POST['codPessoa'];
    $valor = $_POST['valor'];
    $status = $_POST['status'];
    $vencimento = $_POST['vencimento'];
    $dataConta = $_POST['dataConta'];

    if (isset($_POST['cadastrar'])) {
        // Query para cadastrar no banco de dados
        $sql_cadastrar = "INSERT INTO contasreceber (codigo, parcela, codPessoa, valor, status, vencimento, dataConta) VALUES ('$codigo', '$parcela', '$codPessoa', '$valor', '$status', '$vencimento', '$dataConta')";
        $res_cadastrar = mysqli_query($con,$sql_cadastrar);

        if ($res_cadastrar) {
            echo '<script>alert("Registro cadastrado com sucesso!");</script>';
            echo '<script>window.location="contasreceber.php";</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar registro!");</script>';
        }
    }

    if (isset($_POST['alterar'])) {
        // Query para alterar no banco de dados
        $sql_alterar = "UPDATE contasreceber SET parcela='$parcela', codPessoa='$codPessoa', valor='$valor', status='$status', vencimento='$vencimento', dataConta='$dataConta' WHERE codigo='$codigo'";
        $res_alterar = mysqli_query($con,$sql_alterar);

        if ($res_alterar) {
            echo '<script>alert("Registro alterado com sucesso!");</script>';
            echo '<script>window.location="contasreceber.php";</script>';
        } else {
            echo '<script>alert("Erro ao alterar registro!");</script>';
        }
    }

    if (isset($_POST['excluir'])) {
        // Query para excluir no banco de dados
        $sql_excluir = "DELETE FROM contasreceber WHERE codigo='$codigo'";
        $res_excluir = mysqli_query($con,$sql_excluir);

        if ($res_excluir) {
            echo '<script>alert("Registro excluído com sucesso!");</script>';
            echo '<script>window.location="contasreceber.php";</script>';
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
    <title>CONTAS A RECEBER</title>
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
            document.getElementById('parcela').value  = retorno[1];
            document.getElementById('codPessoa').value  = retorno[2];
            document.getElementById('valor').value  = retorno[3];
            document.getElementById('status').value  = retorno[4];
            document.getElementById('vencimento').value  = retorno[5];
            document.getElementById('dataConta').value  = retorno[6];
        }

    </script>

    <!-- Modal Cadastrar -->
    <div class="modal fade" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>CADASTRAR CONTA</h1>
                </div>
                <div class="modal-body">
                    <!-- Modal com form para se fazer cadastro  -->
                    <form class="form-group well" action="contasreceber.php" method="POST">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="parcela">Parcela</label>
                            <input type="text" name="parcela" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="codPessoa">Código Pessoa</label>
                            <select name="codPessoa" id="codPessoa" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                while ($resultado = mysqli_fetch_array($res_pessoa)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' .
                                        utf8_encode($resultado['nome']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input type="text" name="valor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" name="status" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="vencimento">Vencimento</label>
                            <input type="date" name="vencimento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dataConta">Data da Conta</label>
                            <input type="date" name="dataConta" class="form-control" required>
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
                    <form class="form-group well" action="contasreceber.php" method="POST">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input id="codigo" type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="parcela">Parcela</label>
                            <input id="parcela" type="text" name="parcela" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="codPessoa">Código Pessoa</label>
                            <select name="codPessoa" id="codPessoa" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                $res_pessoa = mysqli_query($con,$sql_pessoa);
                                while ($resultado = mysqli_fetch_array($res_pessoa)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' .
                                        utf8_encode($resultado['nome']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input id="valor" type="text" name="valor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input id="status" type="text" name="status" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="vencimento">Vencimento</label>
                            <input id="vencimento" type="date" name="vencimento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dataConta">Data</label>
                            <input id="dataConta" type="date" name="dataConta" class="form-control" required>
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
                    <form class="form-group well" action="contasreceber.php" method="POST">
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
            <h2 class="text-center">CONTAS A RECEBER</h2>
            <form action="contasreceber.php" method="POST" class="form-inline">
                <div class="form-group">
                    <input type="text" name="codigo" placeholder="PESQUISA POR CÓDIGO" class="form-control" style="margin-bottom: 10px;">
                </div><br>
                <button type="submit" name="pesquisar" class="btn btn-primary">Pesquisar</button>
                <button type="button" name="cadastrar" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Cadastrar</button>
            </form><br><br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Parcela</th>
                        <th>Código Pessoa</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Vencimento</th>
                        <th>Data da Conta</th>
                        <th>Operação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['pesquisar'])) {
                        $codigo = strtoupper($_POST['codigo']);
                        $consulta = "SELECT codigo, parcela, codPessoa, valor, status, vencimento, dataConta FROM contasreceber WHERE UPPER(codigo) LIKE '%$codigo%'";
                        $resultado = mysqli_query($con,$consulta);

                        if (!$resultado) {
                            echo "Erro na pesquisa: " . mysqli_error();
                        }
                    } else {
                        $consulta = "SELECT codigo, parcela, codPessoa, valor, status, vencimento, dataConta FROM contasreceber";
                        $resultado = mysqli_query($con,$consulta);
                    }

                    while ($dados = mysqli_fetch_array($resultado)) {
                        $strdados = $dados['codigo'] . "*" . $dados['parcela'] . "*" . $dados['codPessoa'] . "*" . $dados['valor'] . "*" . $dados['status'] . "*" . $dados['vencimento'] . "*" . $dados['dataConta'];
                    ?>
                        <tr>
                            <td><?php echo $dados['codigo']; ?></td>
                            <td><?php echo $dados['parcela']; ?></td>
                            <td><?php echo $dados['codPessoa']; ?></td>
                            <td><?php echo $dados['valor']; ?></td>
                            <td><?php echo $dados['status']; ?></td>
                            <td><?php echo $dados['vencimento']; ?></td>
                            <td><?php echo $dados['dataConta']; ?></td>
                            <td>
                                <a href="#myModalExcluir" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                    <button type='button' id='excluir' name='excluir' class='btn btn-danger' data-toggle='modal' data-target='#myModalExcluir'>Excluir</button>
                                </a>
                                <a href="#myModalAlterar" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                    <button type='button' id='alterar' name='alterar' class='btn btn-primary' data-toggle='modal' data-target='#myModalAlterar'>Alterar</button>
                                </a>
                                <a href="movimentoReceber.php?codigoConta=<?php echo $dados['codigo']; ?>&valorConta=<?php echo $dados['valor'] / $dados['parcela']; ?>&redirected_from_contasreceber=true" class="btn btn-info btnMovimentar">
                                    Movimentar
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    mysqli_close($conectar);
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
© Desenvolvido por Eagle System
</footer>

    <!-- Bibliotecas JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>

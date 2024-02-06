<?php
include('config.php');
include('auth.php');


$sql_produtos = "SELECT codigo,nome FROM produtos";
$res_produtos = mysqli_query($con,$sql_produtos);



if (isset($_POST['cadastrar'])) {
    $codigo = $_POST['codigo'];
    $codProduto = $_POST['codProduto'];
    $origem = $_POST['origem'];
    $dataMovimento = $_POST['dataMovimento'];
    $quantidade = $_POST['quantidade'];

    // Obter o saldo atual antes de cadastrar o movimento
    $sqlSaldoAtual = "SELECT saldoAtual FROM produtos WHERE codigo = '$codProduto'";
    $resultadoSaldoAtual = mysqli_query($con, $sqlSaldoAtual);
    $saldoAtualOriginal = mysqli_fetch_assoc($resultadoSaldoAtual)['saldoAtual'];

    // Adiciona a quantidade ao estoque
    if ($origem == 'entrada') {
        $sqlEntrada = "UPDATE produtos SET saldoAtual = saldoAtual + $quantidade WHERE codigo = '$codProduto'";
        $resultadoEntrada = mysqli_query($con, $sqlEntrada);
    } elseif ($origem == 'saida') {
        // Verifica se há estoque suficiente para a saída
        $sqlVerificaEstoque = "SELECT saldoAtual FROM produtos WHERE codigo = '$codProduto'";
        $resultadoVerificaEstoque = mysqli_query($con, $sqlVerificaEstoque);
        $estoqueAtual = mysqli_fetch_assoc($resultadoVerificaEstoque)['saldoAtual'];

        if ($estoqueAtual >= $quantidade) {
            // Subtrai a quantidade do estoque se houver estoque suficiente
            $sqlSaida = "UPDATE produtos SET saldoAtual = saldoAtual - $quantidade WHERE codigo = '$codProduto'";
            $resultadoSaida = mysqli_query($con, $sqlSaida);
        } else {
            // Se não houver estoque suficiente, exibe mensagem de erro
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Estoque insuficiente para a saída.",
                        text: "Por favor, verifique o saldo atual do produto.",
                    });
                  </script>';
            exit();
        }
    }

    // Insere o movimento no estoque
    $sql = "INSERT INTO movimentoEstoque (codigo, codProduto, origem, dataMovimento, quantidade)
            VALUES ('$codigo','$codProduto','$origem','$dataMovimento','$quantidade')";
    $resultado = mysqli_query($con, $sql);

    // Exibir mensagem de sucesso ou erro
    if ($resultado) {
        // Exibe mensagem de sucesso
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Movimento cadastrado com sucesso!",
                    showConfirmButton: false,
                    timer: 1500
                });
              </script>';
    } else {
        // Exibe mensagem de erro se falhar o cadastro do movimento
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Erro ao cadastrar o movimento.",
                    text: "Por favor, tente novamente.",
                });
              </script>';
    }
}

if (isset($_POST['alterar'])) {
    $codigo = $_POST['codigo'];
    $codProduto = $_POST['codProduto'];
    $origem = $_POST['origem'];
    $dataMovimento = $_POST['dataMovimento'];
    $quantidade = $_POST['quantidade'];

    // Recupera os dados antigos do movimento
    $sqlMovimentoAntigo = "SELECT * FROM movimentoEstoque WHERE codigo = '$codigo'";
    $resultadoMovimentoAntigo = mysqli_query($con, $sqlMovimentoAntigo);
    $dadosAntigos = mysqli_fetch_assoc($resultadoMovimentoAntigo);

    // Reverte a ação anterior
    if ($dadosAntigos['origem'] == 'entrada') {
        $sqlReverter = "UPDATE produtos SET saldoAtual = saldoAtual - {$dadosAntigos['quantidade']} WHERE codigo = '$codProduto'";
        $resultadoReverter = mysqli_query($con, $sqlReverter);
    } elseif ($dadosAntigos['origem'] == 'saida') {
        $sqlReverter = "UPDATE produtos SET saldoAtual = saldoAtual + {$dadosAntigos['quantidade']} WHERE codigo = '$codProduto'";
        $resultadoReverter = mysqli_query($con, $sqlReverter);
    }

    // Aplica a alteração no movimento
    if ($origem == 'entrada') {
        $sqlEntrada = "UPDATE produtos SET saldoAtual = saldoAtual + $quantidade WHERE codigo = '$codProduto'";
        $resultadoEntrada = mysqli_query($con, $sqlEntrada);
    } elseif ($origem == 'saida') {
        // Verifica se há estoque suficiente para a nova saída
        $sqlVerificaEstoqueNova = "SELECT saldoAtual FROM produtos WHERE codigo = '$codProduto'";
        $resultadoVerificaEstoqueNova = mysqli_query($con, $sqlVerificaEstoqueNova);
        $estoqueAtualNova = mysqli_fetch_assoc($resultadoVerificaEstoqueNova)['saldoAtual'];

        if ($estoqueAtualNova >= $quantidade) {
            // Subtrai a quantidade do estoque se houver estoque suficiente
            $sqlSaidaNova = "UPDATE produtos SET saldoAtual = saldoAtual - $quantidade WHERE codigo = '$codProduto'";
            $resultadoSaidaNova = mysqli_query($con, $sqlSaidaNova);
        } else {
            // Se não houver estoque suficiente, exibe mensagem de erro
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Estoque insuficiente para a nova saída.",
                        text: "Por favor, verifique o saldo atual do produto.",
                    });
                  </script>';
            exit();
        }
    }

    // Atualiza o movimento no estoque
    $sqlAtualizarMovimento = "UPDATE movimentoEstoque SET codProduto = '$codProduto', origem = '$origem', dataMovimento = '$dataMovimento', quantidade = '$quantidade' WHERE codigo = '$codigo'";
    $resultadoAtualizarMovimento = mysqli_query($con, $sqlAtualizarMovimento);
}

if (isset($_POST['excluir'])) {
    $codigo = $_POST['codigo'];
    $codProduto = $_POST['codProduto'];
    $origem = $_POST['origem'];

    // Obter a quantidade do movimento a ser excluído
    $sqlObterQuantidade = "SELECT quantidade FROM movimentoEstoque WHERE codigo = '$codigo'";
    $resultadoObterQuantidade = mysqli_query($con, $sqlObterQuantidade);

    if ($resultadoObterQuantidade) {
        $quantidade = mysqli_fetch_assoc($resultadoObterQuantidade)['quantidade'];

        // Reverter ação dependendo da origem do movimento
        if ($origem == 'entrada') {
            // Subtrai a quantidade do estoque
            $sqlReverterEntrada = "UPDATE produtos SET saldoAtual = saldoAtual - $quantidade WHERE codigo = '$codProduto'";
            $resultadoReverterEntrada = mysqli_query($con, $sqlReverterEntrada);
        } elseif ($origem == 'saida') {
            // Adiciona a quantidade de volta ao estoque
            $sqlReverterSaida = "UPDATE produtos SET saldoAtual = saldoAtual + $quantidade WHERE codigo = '$codProduto'";
            $resultadoReverterSaida = mysqli_query($con, $sqlReverterSaida);
        }

        // Excluir o movimento do estoque
        $sqlExcluirMovimento = "DELETE FROM movimentoEstoque WHERE codigo = '$codigo'";
        $resultadoExcluirMovimento = mysqli_query($con, $sqlExcluirMovimento);

        // Exibir mensagem de sucesso ou erro
        if ($resultadoExcluirMovimento) {
            // Exibe mensagem de sucesso
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Movimento excluído com sucesso!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                  </script>';
        } else {
            // Exibe mensagem de erro se falhar a exclusão do movimento
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Erro ao excluir o movimento.",
                        text: "Por favor, tente novamente.",
                    });
                  </script>';
        }
    } else {
        // Exibir mensagem de erro se falhar ao obter a quantidade do movimento
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Erro ao obter a quantidade do movimento.",
                    text: "Por favor, tente novamente.",
                });
              </script>';
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
    <title>MOVIMENTO DO ESTOQUE</title>
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
            document.getElementById('codProduto').value  = retorno[1];
            document.getElementById('origem').value   = retorno[2];
            document.getElementById('dataMovimento').value  = retorno[3];
            document.getElementById('quantidade').value  = retorno[4];
        }

    </script>

    <!-- Modal Cadastrar -->
    <div class="modal fade" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>CADASTRAR MOVIMENTO</h1>
                </div>
                <div class="modal-body">
                    <!-- Modal com form para se fazer cadastro  -->
                    <form class="form-group well" action="movimentoEstoque.php" method="POST">
                        <div class="form-group">

                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="codProduto">Código Produto</label>
                            <select name="codProduto" id="codProduto" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                while ($resultado = mysqli_fetch_array($res_produtos)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' .
                                        utf8_encode($resultado['nome']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="origem">Origem</label>
                            <select name="origem" id="origem" class="form-control" required>
                            <option value=0 selected="selected">Origem</option>
                                <option value="entrada">entrada</option>
                                <option value="saida">saida</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dataMovimento">Data do Movimento</label>
                            <input type="date" name="dataMovimento" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="text" name="quantidade" class="form-control" required>
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
                    <form class="form-group well" action="movimentoEstoque.php" method="POST">
                        <div class="form-group">
                           
                        <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="codProduto">Código Produto</label>
                            <select name="codProduto" id="codProduto" class="form-control" required>
                                <option value="" selected disabled></option>
                                <?php
                                $sql_produtos = "SELECT codigo,nome FROM produtos";
                                $res_produtos = mysqli_query($con,$sql_produtos);
                                while ($resultado = mysqli_fetch_array($res_produtos)) {
                                    echo '<option value="' . $resultado['codigo'] . '">' .
                                        utf8_encode($resultado['nome']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="origem">Origem</label>
                            <select name="origem" id="origem" class="form-control" required>
                            <option value=0 selected="selected">Origem</option>
                                <option value="entrada">entrada</option>
                                <option value="saida">saida</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dataMovimento">Data do Movimento</label>
                            <input type="date" name="dataMovimento" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="text" name="quantidade" class="form-control" required>
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
                    <form class="form-group well" action="movimentoEstoque.php" method="POST">
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
            <h2 class="text-center">MOVIMENTO DO ESTOQUE</h2>
            <form action="movimentoEstoque.php" method="POST" class="form-inline">
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
                        <th>Codigo Produto</th>
                        <th>Origem</th>
                        <th>Data Movimento</th>
                        <th>Quantidade</th>
                        <th>Operação</th>   
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['pesquisar'])) {
                        $codigo = strtoupper($_POST['codigo']);
                        $consulta = "SELECT codigo, codProduto, origem, dataMovimento, quantidade FROM movimentoEstoque WHERE UPPER(codigo) LIKE '%$codigo%'";
                        $resultado = mysqli_query($con,$consulta);

                        if (!$resultado) {
                            echo "Erro na pesquisa: " . mysqli_error();
                        }
                    } else {
                        $consulta = "SELECT codigo, codProduto, origem, dataMovimento, quantidade FROM movimentoEstoque";
                        $resultado = mysqli_query($con,$consulta);
                    }

                    while ($dados = mysqli_fetch_array($resultado)) {
                        $strdados = $dados['codigo'] . "*" . $dados['codProduto'] . "*" . $dados['origem'] . "*" . $dados['dataMovimento'] . "*" . $dados['quantidade'];
                    ?>
                        <tr>
                        <td><?php echo $dados['codigo']; ?></td>
                        <td><?php echo $dados['codProduto']; ?></td>
                        <td><?php echo $dados['origem']; ?></td>
                        <td><?php echo $dados['dataMovimento']; ?></td>
                        <td><?php echo $dados['quantidade']; ?></td>
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

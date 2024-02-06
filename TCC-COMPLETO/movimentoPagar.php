<?php
include('config.php');
include('auth.php');

//------- pesquisa contaspagar
$sql_contaspagar = "SELECT codigo FROM contaspagar";
$res_contaspagar = mysqli_query($con,$sql_contaspagar);

//------- pesquisa contascorrente
$sql_contascorrente = "SELECT codigo, descricao FROM contascorrente";
$res_contascorrente = mysqli_query($con,$sql_contascorrente);

?>

<?php
session_start();

if (isset($_GET['redirected_from_contaspagar']) && $_GET['redirected_from_contaspagar'] == 'true') {
    // A variável de sessão será usada para garantir que o popup seja exibido apenas uma vez
    $_SESSION['redirected_from_contaspagar'] = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylo.css">
  <script defer src="script.js"></script>
  <title>Contas a Pagar</title>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Movimento Contas a Pagar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">

</head>

<body>
    <script>
        
        /*
        document.getElementById('cod').value vira simplesmente $("#cod").val()
        */

        function obterDadosModal(valor) {

            var retorno = valor.split("*");

            document.getElementById('idmovimento').value   = retorno[0];
            document.getElementById('codigo').value  = retorno[1];
            document.getElementById('dataMovimento').value   = retorno[2];
            document.getElementById('parcela').value  = retorno[3];
            document.getElementById('valor').value  = retorno[4];
            document.getElementById('juros').value  = retorno[5];
            document.getElementById('total').value  = retorno[6];
            document.getElementById('codContaCorrente').value  = retorno[7];
        }

    </script>

    <!--Modal Cadastrar-->
    <div class="modal fade" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Realizar movimentação de conta a pagar...</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para se fazer cadastro  -->
                    <form class="form-group well" action="movimentoPagar.php" method="POST">
                        <input type="numeric" name="idmovimento" class="span3" value="" required placeholder="Codigo" style=" margin-bottom: -2px; height: 25px;">
                        <select name="codigo" id="codigo"   class="span3" style=" margin-bottom: -2px; height: 25px;">
                                     <option value=0 selected="selected">Código Conta</option>
                                     <?php
                                        while($resultado = mysqli_fetch_array($res_contaspagar))
                                        {
                                                echo '<option value="'.$resultado['codigo'].'">'.$resultado['codigo'].'</option>';
                                        }
                                     ?>
                                     </select><br><br>
                        <input type="date" name="dataMovimento" class="span3" value="" required placeholder="Data Movimento" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        <input type="numeric" name="parcela" class="span3" value="" required placeholder="Parcela" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        <input type="numeric" name="valor" class="span3" value="" required placeholder="Valor" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        <input type="numeric" name="juros" class="span3" value="" required placeholder="Juros" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        <select name="codContaCorrente" id="codContaCorrente"   class="span3" style=" margin-bottom: -2px; height: 25px;">
                                     <option value=0 selected="selected">Código conta corrente</option>
                                     <?php
                                        while ($resultado = mysqli_fetch_array($res_contascorrente)) {
                                            echo '<option value="' . $resultado['codigo'] . '">' .
                                                utf8_encode($resultado['descricao']) . '</option>';
                                        }
                                     ?>
                                     </select><br><br>
                        <!-- <input type="numeric" name="total" class="span3" value="" required placeholder="Total" style=" margin-bottom: -2px; height: 25px;"><br><br> -->
                        <button type="submit" class="btn btn-success btn-large" name="cadastrar" style="height: 35px">Cadastrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!--Modal Alterar-->
    <div class="modal fade" id="myModalAlterar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h1>Alterar Registro...</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para se fazer alteracao -->
                    <form class="form-group well" action="movimentoPagar.php" method="POST">
                    <div class="form-group">
                        <label for="idmovimento">Código</label>
                        <input type="text" name="idmovimento" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="codigoConta">Código da Conta</label>
                        <select name="codigoConta" id="codigo"   class="form-control">
                                     <option value=0 selected="selected">Código Conta</option>
                                     <?php
                                     $sql_contaspagar = "SELECT codigo FROM contaspagar";
                                     $res_contaspagar = mysqli_query($con,$sql_contaspagar);
                                        while($resultado = mysqli_fetch_array($res_contaspagar))
                                        {
                                                echo '<option value="'.$resultado['codigo'].'">'.$resultado['codigo'].'</option>';
                                        }
                                     ?>
                                     </select>
                    </div>
                    <div class="form-group">
                        <label for="dataMovimento">Data do Movimento</label>
                        <input type="date" name="dataMovimento" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="parcela">Número de parcelas</label>
                        <input type="numeric" name="parcela" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>    
                        <input type="numeric" name="valor" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="juros">Juros</label> 
                        <input type="numeric" name="juros" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="codContaCorrente">Código da Conta Corrente</label> 
                        <select name="codContaCorrente" id="codContaCorrente"   class="form-control">
                                     <option value=0 selected="selected">Código conta corrente</option>
                                     <?php
                                     $sql_contascorrente = "SELECT codigo, descricao FROM contascorrente";
                                     $res_contascorrente = mysqli_query($con,$sql_contascorrente);
                                        while ($resultado = mysqli_fetch_array($res_contascorrente)) {
                                            echo '<option value="' . $resultado['codigo'] . '">' .
                                                utf8_encode($resultado['descricao']) . '</option>';
                                        }
                                     ?>
                                     </select>
                    </div>
                        <button type="submit" class="btn btn-success btn-large" name="alterar" style="height: 35px">Alterar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!--Modal Excluir-->
    <div class="modal fade" id="myModalExcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h1>Excluir Registro...</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para excluir -->
                    <form class="form-group well" action="movimentoPagar.php" method="POST">
                    <div class="form-group">
                        <label for="idovimento">Codigo</label>
                        <input id="idmovimento" type="text" name="idmovimento" class="form-control" required>
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

        <h2 class="text-center">MOVIMENTO CONTAS A PAGAR</h2><br>
            <form action="movimentoPagar.php" method="POST" class="form-inline">
            <div class="form-group">
                <input type="number" name="idmovimento" placeholder="CÓDIGO" class="form-control">
     
                <input type="date" name="dataMovimento" class="form-control"> 
            </div> <br><br>
                <button type="submit" name="pesquisar" class="btn btn-primary">Pesquisar</button>
                <button type="button" name="cadastrar" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Cadastrar</button>
            </form><br><br>
            <table border="1px" bordercolor="gray" class="table table-stripped">
                <tr>
                    <td><b>Codigo</b></td>
                    <td><b>Codigo Conta</b></td>
                    <td><b>Data Movimento</b></td>
                    <td><b>Parcela</b></td>
                    <td><b>Valor</b></td>
                    <td><b>Juros</b></td>
                    <td><b>Total</b></td>
                    <td><b>Codigo Conta Corrente</b></td>
                    <td><b>Operação</b></td>
                </tr>
                <?php
                  
                  if (isset($_POST['cadastrar'])) {
                    $idmovimento = $_POST['idmovimento'];
                    $codigoConta = $_POST['codigoConta'];
                    $dataMovimento = $_POST['dataMovimento'];
                    $parcela = $_POST['parcela'];
                    $valor = $_POST['valor'];
                    $juros = $_POST['juros'];
                    $total = $_POST['total'];
                    $codContaCorrente = $_POST['codContaCorrente'];

                    // Calcule o valor total
                    $total = ($valor + ($valor * ($juros / 100))) * $parcela;
                
                    $sql = "insert into movimentopagar (idmovimento, codigoConta, dataMovimento, parcela, valor, juros, total, codContaCorrente)
                            values ('$idmovimento','$codigoConta','$dataMovimento','$parcela','$valor','$juros','$total','$codContaCorrente')";
                    $resultado = mysqli_query($con,$sql);

                    $resultado = mysqli_query($con, $sql);
                    $atualizarSql = "UPDATE contaspagar SET valor = valor - '$total', parcela = parcela - '$parcela' WHERE codigo = '$codigoConta'";
                    $atualizarResultado = mysqli_query($con, $atualizarSql);

                    // Atualiza a tabela contascorrente
                    $atualizarSql_contascorrente = "UPDATE contascorrente SET saldoAtual = saldoAtual - '$total' WHERE codigo = '$codContaCorrente'";
                    $atualizarResultado_contascorrente = mysqli_query($con, $atualizarSql_contascorrente);

                    if ($atualizarResultado) {
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
                    // Receber as variáveis do HTML
                    $idmovimento = $_POST['idmovimento'];
                    $codigoConta = $_POST['codigoConta'];
                    $dataMovimento = $_POST['dataMovimento'];
                    $parcela = $_POST['parcela'];
                    $valor = $_POST['valor'];
                    $juros = $_POST['juros'];
                    $total = $_POST['total'];
                    $codContaCorrente = $_POST['codContaCorrente'];
                
                    // Recuperar os dados antigos do movimentoreceber
                    $consultaAntiga = mysqli_query($con, "SELECT * FROM movimentopagar WHERE idmovimento = '$idmovimento'");
                    $dadosAntigos = mysqli_fetch_assoc($consultaAntiga);
                
                    // Recalcular o valor total
                    $total = $valor + ($valor * ($juros / 100));
                
                    // Iniciar transação
                    mysqli_begin_transaction($con);
                
                    try {
                        // Reverter os valores antigos em "contareceber"
                        $sqlReverterContareceber = "UPDATE contaspagar SET valor = valor + {$dadosAntigos['total']}, parcela = parcela + '{$dadosAntigos['parcela']}' WHERE codigo = '$codigoConta'";
                        $resultadoReverterContareceber = mysqli_query($con, $sqlReverterContareceber);
                
                        if (!$resultadoReverterContareceber) {
                            throw new Exception(mysqli_error($con));
                        }
                
                        // Reverter os valores antigos em "contacorrente"
                        $sqlReverterContacorrente = "UPDATE contascorrente SET saldoatual = saldoatual + {$dadosAntigos['total']} WHERE codigo = '$codContaCorrente'";
                        $resultadoReverterContacorrente = mysqli_query($con, $sqlReverterContacorrente);

                
                        if (!$resultadoReverterContacorrente) {
                            throw new Exception(mysqli_error($con));
                        }
                 
                        // Atualizar dados na tabela "movimentoreceber"
                        $sql = "UPDATE movimentopagar SET  dataMovimento = '$dataMovimento', valor = '$valor', juros = '$juros', total = '$total'
                                WHERE idmovimento = '$idmovimento'";
                        $resultado = mysqli_query($con, $sql);
                
                        if (!$resultado) {
                            throw new Exception(mysqli_error($con));
                        }
                
                        // Atualizar dados em "contareceber"
                        $sqlContareceber = "UPDATE contaspagar SET valor = valor - $total, parcela = parcela - '$parcela' WHERE codigo = '$codigoConta'";
                        $resultadoContareceber = mysqli_query($con, $sqlContareceber);
                
                        if (!$resultadoContareceber) {
                            throw new Exception(mysqli_error($con));
                        }
                

                        // Calcular a diferença entre os valores total antigo e novo
$diferencaTotal = $total - $dadosAntigos['total'];

// Atualizar dados em "contacorrente"
$sqlContacorrente = "UPDATE contascorrente SET saldoatual = saldoatual + $diferencaTotal WHERE codigo = '$codContaCorrente'";
$resultadoContacorrente = mysqli_query($con, $sqlContacorrente);
                
                        if (!$resultadoContacorrente) {
                            throw new Exception(mysqli_error($con));
                        } 
                
                        // Confirmar a transação
                        mysqli_commit($con);
                
                        $mensagem = "Dados alterados com sucesso.";
                        $classe_mensagem = "mensagem-sucesso";
                    } catch (Exception $e) {
                        // Desfazer a transação em caso de erro
                        mysqli_rollback($con);
                
                        $mensagem = "Erro ao alterar os dados: " . $e->getMessage();
                        $classe_mensagem = "mensagem-erro";
                    }

                    if ($resultadoContareceber) {
                        // Exibe mensagem de sucesso
                        echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Movimento alterado com sucesso!",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                              </script>';
                    } else {
                        // Exibe mensagem de erro se falhar o cadastro do movimento
                        echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Erro ao alterar o movimento.",
                                    text: "Por favor, tente novamente.",
                                });
                              </script>';
                    }
                
                }
                
                                                                                                                                                                

                
                if (isset($_POST['excluir'])) {
                    // Recupera o ID do movimento a ser excluído
                    $idmovimento = $_POST['idmovimento'];
                
                    // Query para excluir no banco de dados
                    $sql_excluir = "DELETE FROM movimentopagar WHERE idmovimento='$idmovimento'";
                    $res_excluir = mysqli_query($con, $sql_excluir);
                
                    if ($res_excluir) {
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
                        // Exibe mensagem de erro se falhar o cadastro do movimento
                        echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Erro ao excluir o movimento.",
                                    text: "Por favor, tente novamente.",
                                });
                              </script>';
                    }
                    
                }                                             
                
                             
                if (isset($_POST['pesquisar'])) {
                    $idmovimento = mysqli_real_escape_string($con, $_POST['idmovimento']);
                    $dataMovimento = mysqli_real_escape_string($con, $_POST['dataMovimento']);
                
                    // Construir a consulta base
                    $consulta = "SELECT idmovimento, codigoConta, dataMovimento, parcela, valor, juros, total, codContaCorrente
                                FROM movimentopagar
                                WHERE 1";
                
                    // Adicionar condição para código, se foi preenchido
                    if (!empty($idmovimento)) {
                        $consulta .= " AND idmovimento = '$idmovimento'";
                    }
                
                    // Adicionar condição para data, se foi preenchida
                    if (!empty($dataMovimento)) {
                        // Formata a data no formato do banco de dados (Y-m-d)
                        $dataMovimentoFormatada = date('Y-m-d', strtotime($dataMovimento));
                        $consulta .= " AND dataMovimento = '$dataMovimentoFormatada'";
                    }
                
                    // Executar a consulta
                    $resultado = mysqli_query($con, $consulta);
                } else {
                    // Consulta padrão sem filtros
                    $consulta = "SELECT idmovimento, codigoConta, dataMovimento, parcela, valor, juros, total, codContaCorrente
                                FROM movimentopagar";
                    $resultado = mysqli_query($con, $consulta);
                }
                

                while ($dados = mysqli_fetch_array($resultado))
                {
                    $strdados = $dados['idmovimento'] . "*" .  $dados['codigoConta'] . "*" .  $dados['dataMovimento'] . "*" .  $dados['parcela'] . "*" .  $dados['valor'] . "*" .  $dados['juros'] . "*" .  $dados['total'] . "*" .  $dados['codContaCorrente'];
                ?>
                    <tr>
                        <td><?php echo $dados['idmovimento']; ?></td>
                        <td><?php echo $dados['codigoConta']; ?></td>
                        <td><?php echo $dados['dataMovimento']; ?></td>
                        <td><?php echo $dados['parcela']; ?></td>
                        <td><?php echo $dados['valor']; ?></td>
                        <td><?php echo $dados['juros']; ?></td>
                        <td><?php echo $dados['total']; ?></td>
                        <td><?php echo $dados['codContaCorrente']; ?></td>
                        <td>
                            <a href="#myModalExcluir" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                <button type='button' id='excluir' name='excluir' class='btn btn-danger' data-toggle='modal' data-target='#myModalExcluir'>Excluir</button>

                            <a href="#myModalAlterar" onclick="obterDadosModal('<?php echo $strdados ?>')">
                                <button type='button' id='alterar' name='alterar' class='btn btn-primary' data-toggle='modal' data-target='#myModalAlterar'>Alterar</button>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                mysqli_close($conectar);
                ?>
            </table>

            <a href="contaspagar.php"> 
                <button type="button" class="btn btn-info">Voltar</button>
            </a>
            <a href="home.php"> 
                <button type="button" class="btn btn-info">Home</button>
            </a>

        </div>
    </div>

    <div class="modal fade" id="myModalMovimento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Movimentar Conta</h1>
            </div>
            <div class="modal-body">
                <!-- Modal com formulário -->
                <form class="form-group well" action="movimentoPagar.php" method="POST">
                    <div class="form-group">
                        <label for="idmovimento">Código</label>
                        <input type="text" name="idmovimento" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="codigoConta">Código da Conta</label>
                        <input id="codigoConta" type="text" name="codigoConta" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="dataMovimento">Data do movimento</label>
                        <input type="date" name="dataMovimento" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="parcela">Número de parcelas</label>
                        <input type="text" name="parcela" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input id="valor" type="text" name="valor" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="juros">Juros</label>
                        <input type="text" name="juros" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="codContaCorrente">Código conta corrente</label>
                        <select name="codContaCorrente" id="codContaCorrente"   class="form-control">
                                     <option value=0 selected="selected">Código conta corrente</option>
                                     <?php
                                     $sql_contascorrente = "SELECT codigo, descricao FROM contascorrente";
                                     $res_contascorrente = mysqli_query($con,$sql_contascorrente);
                                        while ($resultado = mysqli_fetch_array($res_contascorrente)) {
                                            echo '<option value="' . $resultado['codigo'] . '">' .
                                                utf8_encode($resultado['descricao']) . '</option>';
                                        }
                                     ?>
                                     </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-block" name="cadastrar">Movimentar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
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


   <!-- Biblioteca jQuery -->
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<!-- Biblioteca Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>


<script>
$(document).ready(function() {
    // Obtém os parâmetros da URL
    var urlParams = new URLSearchParams(window.location.search);
    var codigoConta = urlParams.get('codigoConta');
    var valorConta = urlParams.get('valorConta');

    // Verifica se foi redirecionado da página contaspagar
    if ('<?php echo isset($_SESSION['redirected_from_contaspagar']) ? $_SESSION['redirected_from_contaspagar'] : '' ?>' == '1') {
        // Abre o modal apenas se foi redirecionado da página contaspagar
        $('#myModalMovimento').modal('show');

        // Preenche os campos do modal
        $('#codigoConta').val(codigoConta);
        $('#valor').val(valorConta);

        // Reseta a variável de sessão para não exibir o popup novamente após recarregar
        <?php unset($_SESSION['redirected_from_contaspagar']); ?>;
    }
});
</script>


</body>


</html>

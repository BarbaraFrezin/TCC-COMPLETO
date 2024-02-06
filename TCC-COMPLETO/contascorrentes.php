<?php
include('config.php');
include('auth.php');

$sql_banco = "SELECT codigo, nome FROM banco";
$res_banco = mysqli_query($con,$sql_banco);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylo.css">
  <script defer src="script.js"></script>
  <title>Contas Correntes</title>
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
    <title>Contas CORRENTES</title>
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
            document.getElementById('descricao').value  = retorno[1];
            document.getElementById('codBanco').value  = retorno[2];
            document.getElementById('agencia').value  = retorno[3];
            document.getElementById('digitoagencia').value  = retorno[4];
            document.getElementById('contacorrente').value  = retorno[5];
            document.getElementById('digito').value  = retorno[6];
            document.getElementById('saldoInicial').value  = retorno[7];
            document.getElementById('saldoAtual').value  = retorno[8];
        }

    </script>
    <!--Modal Cadastrar-->
    <div class="modal fade" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>CADASTRAR CONTA</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para se fazer cadastro  -->
                    <form class="form-group well" action="contascorrentes.php" method="POST">
                        Codigo <input type="text" name="codigo" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
                        Descrição <input type="text" name="descricao" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Codigo Banco <select name="codBanco" id="codBanco"   class="span3" style=" margin-bottom: -2px; height: 25px;">
                                     <option value=0 selected="selected"></option>
                                     <?php
                                        while($resultado = mysqli_fetch_array($res_banco))
                                        {
                                                 echo '<option value="'.$resultado['codigo'].'">'.
                                                            utf8_encode($resultado['nome']).'</option>';
                                        }
                                     ?>
                                     </select>
                        Agência <input type="text" name="agencia" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Dígito agência <input type="text" name="digitoagencia" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Conta corrente <input type="text" name="contacorrente" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Dígito <input type="text" name="digito" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
                        Saldo Inicial <input type="text" name="saldoInicial" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Saldo Atual <input type="text" name="saldoAtual" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
            
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
                    <h1>ALTERAR REGISTRO</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para se fazer alteracao -->
                    <form class="form-group well" action="contascorrentes.php" method="POST">
                        Codigo <input type="text" name="codigo" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
                        Descrição <input type="text" name="descricao" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Codigo Banco <select name="codBanco" id="codBanco"   class="span3" style=" margin-bottom: -2px; height: 25px;">
                                     <option value=0 selected="selected"></option>
                                     <?php
                                     $sql_banco = "SELECT codigo,nome FROM banco";
                                     $res_banco = mysqli_query($con,$sql_banco);

                                        while($resultado = mysqli_fetch_array($res_banco))
                                        {
                                                 echo '<option value="'.$resultado['codigo'].'">'.
                                                            utf8_encode($resultado['nome']).'</option>';
                                        }
                                     ?>
                                     </select>
                        Agência <input type="text" name="agencia" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Dígito agência <input type="text" name="digitoagencia" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Conta corrente <input type="text" name="contacorrente" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Dígito <input type="text" name="digito" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
                        Saldo Inicial <input type="text" name="saldoInicial" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;"><br><br>
                        Saldo Atual <input type="text" name="saldoAtual" class="span3" value="" required placeholder="" style=" margin-bottom: -2px; height: 25px;">
                        
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
                    <h1>EXCLUIR REGISTRO</h1>
                </div>
                <div class="modal-body">
                    <!--- Modal com form para excluir -->
                    <form class="form-group well" action="contascorrentes.php" method="POST">
                    Codigo   <input id="codigo" type="text" name="codigo" value="" required>
                   
                    <button type="submit" class="btn btn-success btn-large" name="excluir" style="height: 35px">Excluir</button>
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

        <h2 class="text-center">CONTAS CORRENTES</h2><br>
            <form action="contascorrentes.php" method="POST" class="form-inline">
            <div class="form-group">
                <input type="text" name="codigo" placeholder="PESQUISAS POR CODIGO" class="form-control">
            </div><br><br>
                <button type="submit" name="pesquisar" class="btn btn-primary">Pesquisar</button>

                <button type="button" name="cadastrar" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Cadastrar</button>
            </form><br><br>
            <table border="1px" bordercolor="gray" class="table table-stripped">
                <tr>
                    <td><b>Codigo</b></td>
                    <td><b>Descrição</b></td>
                    <td><b>Cod Banco</b></td>
                    <td><b>Agência</b></td>
                    <td><b>Dígito Agência</b></td>
                    <td><b>Conta Corrente</b></td>
                    <td><b>Dígito</b></td>
                    <td><b>Saldo Inicial</b></td>
                    <td><b>Saldo Atual</b></td>
                    <td><b>Operacao</b></td>
                </tr>
                <?php
                  
                  if (isset($_POST['cadastrar']))
                {
                    $codigo   = $_POST['codigo'];
                    $descricao  = $_POST['descricao'];
                    $codBanco   = $_POST['codBanco'];
                    $agencia  = $_POST['agencia'];
                    $digitoagencia = $_POST['digitoagencia'];
                    $contacorrente  = $_POST['contacorrente'];
                    $digito   = $_POST['digito'];
                    $saldoInicial  = $_POST['saldoInicial'];
                    $saldoAtual   = $_POST['saldoAtual'];
                   

                    $sql = "insert into contascorrente (codigo, descricao, codBanco, agencia, digitoagencia, contacorrente, digito, saldoInicial, saldoAtual)
                            values ('$codigo','$descricao','$codBanco','$agencia','$digitoagencia','$contacorrente','$digito','$saldoInicial','$saldoAtual')";
                     $resultado = mysqli_query($con,$sql);
                }
                if (isset($_POST['alterar']))
                {
                    $codigo   = $_POST['codigo'];
                    $descricao  = $_POST['descricao'];
                    $codBanco   = $_POST['codBanco'];
                    $agencia  = $_POST['agencia'];
                    $digitoagencia = $_POST['digitoagencia'];
                    $contacorrente  = $_POST['contacorrente'];
                    $digito   = $_POST['digito'];
                    $saldoInicial  = $_POST['saldoInicial'];
                    $saldoAtual   = $_POST['saldoAtual'];
                

                    $sql = "update contascorrente set descricao = '$descricao', codBanco = '$codBanco', agencia = '$agencia', digitoagencia = '$digitoagencia', contacorrente = '$contacorrente', digito = '$digito', saldoInicial = '$saldoInicial', saldoAtual = '$saldoAtual'
                            where codigo = '$codigo'";
                    $resultado = mysqli_query($con,$sql);
                }
                if (isset($_POST['excluir']))
                {
                    $codigo   = $_POST['codigo'];
                
                    $sql = "delete from contascorrente where codigo = '$codigo'";
                    $resultado = mysqli_query($con,$sql);
                }

                if (isset($_POST['pesquisar']))
                {
                   $codigo   = strtoupper($_POST['codigo']);    // converter maiuscula

                   $consulta = "select codigo, descricao, codBanco, agencia, digitoagencia, contacorrente, digito, saldoInicial, saldoAtual from contascorrente
                                where UPPER(codigo) like '%$codigo%'";

                   $resultado = mysqli_query($con,$consulta);
                }
                else
                {
                    $consulta = "select codigo, descricao, codBanco, agencia, digitoagencia, contacorrente, digito, saldoInicial, saldoAtual from contascorrente";
                    $resultado = mysqli_query($con,$consulta);
                }

                while ($dados = mysqli_fetch_array($resultado))
                {
                    $strdados = $dados['codigo'] . "*" .  $dados['descricao'] . "*" .  $dados['codBanco'] . "*" .  $dados['agencia'] . "*" .  $dados['digitoagencia'] . "*" .  $dados['contacorrente'] . "*" .  $dados['digito'] . "*" .  $dados['saldoInicial'] . "*" .  $dados['saldoAtual'];
                ?>
                    <tr>
                        <td><?php echo $dados['codigo']; ?></td>
                        <td><?php echo $dados['descricao']; ?></td>
                        <td><?php echo $dados['codBanco']; ?></td>
                        <td><?php echo $dados['agencia']; ?></td>
                        <td><?php echo $dados['digitoagencia']; ?></td>
                        <td><?php echo $dados['contacorrente']; ?></td>
                        <td><?php echo $dados['digito']; ?></td>
                        <td><?php echo $dados['saldoInicial']; ?></td>
                        <td><?php echo $dados['saldoAtual']; ?></td>
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
    <!-- Biblioteca requerida -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>

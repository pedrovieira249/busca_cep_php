<?php include('class/class-address.php'); $address = new Address();?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Calcula Cep</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="_css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="jumbotron mt-5">
						<h2 class="display-4 mb-4">Informações de endereço por CEP</h2>
						<form action="index.php" method="post">
							<div class="input-group">
							 <input type="text" id="cep" class="cep form-control" name="cep" placeholder="Ex: 31910-660" required="required">
							  <div class="input-group-prepend">
							    <button type="btn" class="btn btn-outline-secondary">Buscar</button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<?php
						if(isset($_POST['cep']) && !empty($_POST['cep'])){
							if(strlen($_POST['cep']) == 9 && preg_match('#^\d{5}-\d{3}$#',$_POST['cep'])){
								$address->get_address($_POST['cep']);
								if($address->getError() == 'errorCep'){
									echo "<br><br><div class='alert alert-danger'>CEP Informado: '".$_POST['cep']."' - Não Existe!</div><br>";
								}elseif($address->getError() == 'errorServer'){
									echo "<br><br><div class='alert alert-danger'>Falha ao calcular cep, tente novamente</div><br>";
								}else{ ?>
									<ul class="list-group">
									  <li class="list-group-item list-group-item-dark">CEP Informado: <?php echo $address->getCep();?></li>
									  <li class="list-group-item list-group-item-secondary">Endereço: <?php echo $address->getLogradouro();?></li>
									  <li class="list-group-item list-group-item-secondary">Bairro: <?php echo $address->getBairro();?></li>
									  <li class="list-group-item list-group-item-secondary">Cidade: <?php echo $address->getLocalidade();?></li>
									  <li class="list-group-item list-group-item-secondary">Estado: <?php echo $address->getUf();?></li>
									</ul>
								<?php } ?>
						<?php }else{
							echo "<br><br><div class='alert alert-danger'>CEP Informado: '".$_POST['cep']."' - É invalido!</div><br>";
							}
						}elseif(isset($_POST['cep']) && empty($_POST['cep'])){ 
							echo "<br><br><div class='alert alert-danger'>Nenhum cep foi informado!</div><br>";
					    } ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="jumbotron mt-5">
						<h2 class="display-4 mb-4">Informações de endereço por CEP - Via Ajax</h2>
						<div class="input-group">
							<input type="text" id="cepajax" class="cep form-control" name="cepajax" placeholder="Ex: 31910-660" required="required">
							<div class="input-group-prepend">
								<button type="btn" id="seatchAddressByCep" class="btn btn-outline-secondary">Buscar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div id="loading" style="display:none;">
						<img class="img-responsive d-block mx-auto" src='gif/loading.gif' />
					</div>
					<div id="infoCep" style="display:none;">
						<ul class="list-group info-address">
							<li class="list-group-item list-group-item-dark info-address-cep">CEP Informado: </li>
							<li class="list-group-item list-group-item-secondary info-address-endereco">Endereço: </li>
							<li class="list-group-item list-group-item-secondary info-address-bairro">Bairro: </li>
							<li class="list-group-item list-group-item-secondary info-address-estado">Estado: </li>
							<li class="list-group-item list-group-item-secondary info-address-cidade">cidade: </li>
						</ul>
					</div>
					<br><br><div class='alert alert-danger error-cep' style="display:none;"></div><br>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<form action="index.php" method="post">
						<div class="jumbotron mt-5">
							<h2 class="display-4 mb-5">Calcular preços, prazos e tipo de entrega</h2>
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="cep_ori">Cep de Origem</label>
										<input type="cep_ori" class="cep form-control" id="cep_ori" name="cep_ori" aria-describedby="Cep de Origem" placeholder="">
									</div>
									<div class="form-group">
										<label for="cep_dest">Cep de Destino</label>
										<input type="cep_dest" class="cep form-control" id="cep_dest" name="cep_dest" aria-describedby="Cep de Destino" placeholder="">
									</div>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="servico">Serviços de postagem</label>
										<select name="servico" class="form-control" >
											<!-- <option value="40215">SEDEX10</option>
											<option value="40045">SEDEXACOBRAR</option> -->
											<option value="40010">SEDEX</option>
											<option value="41106">PAC</option>
										</select>
									</div>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="">Serviços adicionais</label><br>
										<input type="checkbox" id="MaoPropria" name="MaoPropria" value="MaoPropria">
										<label for="MaoPropria">Mão própria</label><br>

										<input type="checkbox" id="avisoRecebimento" name="avisoRecebimento" value="avisoRecebimento">
										<label for="avisoRecebimento">Aviso de recebimento - AR</label><br>

										<input type="checkbox" id="ckValorDeclarado" name="ckValorDeclarado" value="ckValorDeclarado" onchange="mostraValorDeclarado(this.value);">
										<label for="ckValorDeclarado">Declaração de Valor</label><br><br>
										<script type="text/javascript">
											function mostraValorDeclarado(val){
												var valid = document.getElementById('ckValorDeclarado').checked;
												var valorDeclarado = document.getElementById('valorDeclarado');
												if(val == 'ckValorDeclarado' && valid){
													valorDeclarado.style.display = "block";
												}else if(val == 'ckValorDeclarado' && !valid){
													valorDeclarado.style.display = "none";
												}
											}
										</script>
									</div>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="peso">Peso <span class="col-form-label-sm"><b>Em gramas (caixa + produto)</b></span></label>
										<input type="peso" class="form-control" id="peso" name="peso" aria-describedby="peso" placeholder="Ex: 0.5">
									</div>
									<div class="form-group" id="valorDeclarado" style="display:none;">
										<label for="valorDeclarado">Valor Declarado</label>
										<input type="valorDeclarado" class="form-control" id="valorDeclarado" name="valorDeclarado" aria-describedby="valorDeclarado">
									</div>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="row">
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="form-group">
												<label for="altura">Altura</label>
												<input type="altura" class="form-control" id="altura"  name="altura" aria-describedby="altura">
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="form-group">
												<label for="lagura">Largura</label>
												<input type="lagura" class="form-control" id="lagura"  name="lagura" aria-describedby="lagura">
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="form-group">
												<label for="comprimento">Comprimento</label>
												<input type="comprimento" class="form-control" id="comprimento"  name="comprimento" aria-describedby="comprimento">
											</div>
										</div>
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="form-group">
												<button class="btn btn-success d-block mx-auto">Calcular Frete</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<?php
					$cep_origem = trim($_POST['cep_ori']);
					$cep_destino = trim($_POST['cep_dest']);
					$peso = trim($_POST['peso']);
					$comprimento = trim($_POST['comprimento']);
					$altura = trim($_POST['altura']);
					$largura = trim($_POST['lagura']);
					$valor_declarado = '0';
					$cod_servico = trim($_POST['servico']);
					// if( $cod_servico == '40215' ) $cod_servico_name = 'SEDEX10'; 
					// if( $cod_servico == '40045' ) $cod_servico_name = 'SEDEXACOBRAR' ; 
					if( $cod_servico == '40010' ) $cod_servico_name = 'SEDEX'; 
					if( $cod_servico == '41106' ) $cod_servico_name = 'PAC' ;
					$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";
					$xml = simplexml_load_file($correios);
					if($xml->cServico->Erro == '0'){ ?>
						<ul class="list-group">
							<li class="list-group-item list-group-item-dark">Seviço: <?php echo $cod_servico_name;?></li>
							<li class="list-group-item list-group-item-dark">Valor: <?php echo $xml->cServico->Valor;?></li>
							<li class="list-group-item list-group-item-dark">Prazo de Entrega: <?php echo $xml->cServico->PrazoEntrega;?> dia(s)</li>
						</ul>
			  <?php }else{
					echo "<br><br><div class='alert alert-danger'>Não foi possivel calcular a entrega</div><br>";
					} ?>
				</div>
			</div>
		</div><br><br><br>
	</body>
	<script type="text/javascript" src="_js/jquery.min.js"></script>
	<script type="text/javascript" src="_js/popper.min.js"></script>
	<script type="text/javascript" src="_js/bootstrap.min.js"></script>
	<script type="text/javascript" src="_js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="_js/functions.js"></script>
</html>
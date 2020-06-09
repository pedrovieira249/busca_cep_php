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
						<h1 class="display-4 mb-4">Informações de endereço por CEP</h1>
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
						<h1 class="display-4 mb-4">Informações de endereço por CEP - Via Ajax</h1>
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
	</body>
	<script type="text/javascript" src="_js/jquery.min.js"></script>
	<script type="text/javascript" src="_js/popper.min.js"></script>
	<script type="text/javascript" src="_js/bootstrap.min.js"></script>
	<script type="text/javascript" src="_js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="_js/functions.js"></script>
</html>
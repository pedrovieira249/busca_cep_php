<?php

	class Address {
		private $cep;
		private $logradouro;
		private $bairro;
		private $localidade;
		private $uf;
		private $error;

		public function getCep()
		{
			return $this->cep;
		}
		public function setCep($cep)
		{
			$this->cep = (string) $cep;
		}

		public function getLogradouro()
		{
			return $this->logradouro;
		}
		public function setLogradouro($logradouro)
		{
			$this->logradouro = (string) $logradouro;
		}

		public function getBairro()
		{
			return $this->bairro;
		}
		public function setBairro($bairro)
		{
			$this->bairro = (string) $bairro;
		}

		public function getLocalidade()
		{
			return $this->localidade;
		}
		public function setLocalidade($localidade)
		{
			$this->localidade = (string) $localidade;
		}

		public function getUf()
		{
			return $this->uf;
		}
		public function setUf($uf)
		{
			$this->uf = (string) $uf;
		}

		public function getError()
		{
			return $this->error;
		}
		public function setError($error)
		{
			$this->error = (string) $error;
		}

		function get_address($cep = null){
			$cep = preg_replace("/[^0-9]/", "", $cep);
			$url = "http://viacep.com.br/ws/$cep/xml/";
			$file_headers = @get_headers($url);
			if(!$file_headers || $file_headers[0] == 'HTTP/1.1 200 OK') {
				$xml = simplexml_load_file($url);
				if($xml->erro == 'true'){
					$this->setError('errorCep');
				}else{
					$this->setCep($xml->cep);
					$this->setLogradouro($xml->logradouro);
					$this->setBairro($xml->bairro);
					$this->setLocalidade($xml->localidade);
					$this->setUf($this->ufFormat($xml->uf));
					$this->setError(false);
				}
			}else{
				$this->setError('errorServer');
			}
		}
		
		// Função que converte a Sigla do estado para o nome do estado
		function ufFormat($uf) {
			$a = array("AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA","PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE","TO", "EX", );
			$b = array("Acre", "Alagoas", "Amapá", "Amazonas", "Bahia", "Ceará", "Distrito Federal", "Espírito Santo", "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Pará", "Paraíba", "Paraná", "Pernambuco", "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul", "Rondônia", "Roraima", "Santa Catarina", "São Paulo", "Sergipe", "Tocantins", "Estrangeiro");
			return (string) str_replace($a, $b, $uf);
		}
		
	}
?>
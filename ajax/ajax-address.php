<?php

    /**
     * Fiz a utilização de dois webservide diferentes, só para ter mais uma opção caso uma não funcione pode utilizar a outra.
     * 
     */

    // Função que converte a Sigla do estado para o nome do estado
    function ufFormat($uf) {
        $a = array("AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA","PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE","TO", "EX", );
        $b = array("Acre", "Alagoas", "Amapá", "Amazonas", "Bahia", "Ceará", "Distrito Federal", "Espírito Santo", "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Pará", "Paraíba", "Paraná", "Pernambuco", "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul", "Rondônia", "Roraima", "Santa Catarina", "São Paulo", "Sergipe", "Tocantins", "Estrangeiro");
        return (string) str_replace($a, $b, $uf); 
    }

    // Para exibir informações via get
    if(isset($_GET['cep']) && !empty($_GET['cep']) && (strlen($_GET['cep']) == 9 || strlen($_GET['cep']) == 8)){
        $cep = preg_replace("/[^0-9]/", "", $_GET['cep']);
        $webservice = 'http://cep.republicavirtual.com.br/web_cep.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webservice . '?cep=' . urlencode($cep) . '&formato=json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $return = curl_exec($ch);
        echo $return;
    }

    // Para exibir informações via post
    if(isset($_POST['cep']) && !empty($_POST['cep']) && strlen($_POST['cep']) == 9){
        
        $cep = preg_replace("/[^0-9]/", "", $_POST['cep']);
        $url = "http://viacep.com.br/ws/$cep/xml/";

        $file_headers = @get_headers($url);

        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 200 OK') {
            $xml = simplexml_load_file($url);

            if($xml->erro == 'true'){
                echo "{error: 'errorCep'}";
            }else{
                echo "{cep: '".$xml->cep."', ";
                echo "logradouro: '".$xml->logradouro."', ";
                echo "bairro: '".$xml->bairro."', ";
                echo "localidade: '".$xml->localidade."', ";
                echo "uf: '".ufFormat($xml->uf)."'}";
            }

        }else{
            echo "{error: 'errorServer'}";
        }

    }elseif(!empty($_POST)){
        echo "{error: 'null'}";
    }

?>
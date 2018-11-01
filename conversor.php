<?php
$valor_post = $_POST["valor"];
$de_post = $_POST["de"];
$para_post = $_POST["para"];

class Conversor{
    public $valor = 0;
    public $de = "";
    public $para = "";
    public $cotacao_dolar = "";
    public $cotacao_euro = "";
    public $moeda = "";
    public $dolar = "";
    public $euro = "";
    public $resposta = "";

    // Construtor
    public function __construct($valor, $de, $para) {
    	$this->set_valor($valor);
    	$this->set_de($de);
    	$this->set_para($para);
    	$this->set_cotacao_dolar('https://economia.awesomeapi.com.br/USD-BRLT/1');
    	$this->set_cotacao_euro('https://economia.awesomeapi.com.br/EUR-BRL/1');
  	}

  	// SET
  	public function set_cotacao_dolar($url){
    	$this->cotacao_dolar = file_get_contents($url);
    }
    public function set_cotacao_euro($url){
    	$this->cotacao_euro = file_get_contents($url);
    }

    public function set_valor($valor){
    	$this->valor = $valor;
    }
    public function set_de($de){
    	$this->de = $de;
    }
    public function set_para($para){
    	$this->para = $para;
    }
    public function set_moeda($moeda){
    	$this->moeda = $moeda;
    }
    public function set_dolar($dolar){
    	$this->dolar = round($dolar, 2);
    }
    public function set_euro($euro){
    	$this->euro = round($euro, 2);
    }
    public function set_resposta($resposta){
    	$this->resposta = $resposta;
    }

    // GET
    public function get_resposta(){
    	return $this->resposta;
    }
    public function get_valor(){
    	return $this->valor;
    }
    public function get_de(){
    	return $this->de;
    }
    public function get_para(){
    	return $this->para;
    }
    public function get_cotacao_dolar(){
    	$json = json_decode($this->cotacao_dolar);
    	return $json;
    }
    public function get_cotacao_euro(){
    	$json = json_decode($this->cotacao_euro);
    	return $json;
    }
    public function get_moeda(){
    	return $this->moeda;
    }
    public function get_dolar(){
    	return $this->dolar;
    }
    public function get_euro(){
    	return $this->euro;
    }

    public function formata_resposta($total){
    	if ($total == '0') {
    		return "Conversão <strong>não</strong> autorizada!";
    	} else {
    		return "Valor convertido: <strong>".$total."</strong></h1>";
    	}
    }

    // FUNÇÃO CONVERTER
    public function set_conversor(){

    	$valor = $this->get_valor();
    	$de = $this->get_de();
    	$para = $this->get_para();
    	$cotacao_dolar = $this->get_cotacao_dolar();
    	$cotacao_euro = $this->get_cotacao_euro();

    	$this->set_dolar($cotacao_dolar[0]->high);
    	$this->set_euro($cotacao_euro[0]->high);

    	$dolar = $this->get_dolar();
    	$euro = $this->get_euro();

		
    	if ($de == "BR" and $para == "USD") {
			$total = $valor/$dolar;
			$total = '$' . number_format($total, 2, '.', '.');
		} elseif ($de == "USD" and $para == "BR") {
			$total = $valor*$dolar;
			$total = 'R$' . number_format($total, 2, ',', '.');
		} elseif ($de == "BR" and $para == "EUR") {
			$total = $valor/$euro;
			$total = '€' . number_format($total, 2, '.', '.');
		} elseif ($de == "EUR" and $para == "BR") {
			$total = $valor*$euro;
			$total = 'R$' . number_format($total, 2, ',', '.');
		} else {
			$total = 0;
		}
		$this->set_resposta($this->formata_resposta($total));
    }

}

$conversor = new Conversor($valor_post, $de_post, $para_post);
$conversor->set_conversor();
echo $conversor->get_resposta();






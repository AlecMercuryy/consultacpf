<?php
session_start();
error_reporting(0);
set_time_limit(0);
function dados($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
$ch = curl_init();

curl_setopt_array($ch, [
   CURLOPT_URL => 'http://api.trackear.com.br/basepv/cpf/'.$cpf.'/noip',
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_COOKIEJAR => getcwd() . "/cookie_" . rand(999, 999) . ".txt",
    CURLOPT_COOKIEFILE => getcwd() . "/cookie_" . rand(999, 999) . ".txt",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_ENCODING => "gzip",
    CURLOPT_HTTPHEADER => [
    'Host: api.trackear.com.br',
    'User-Agent: RootBot',
    'Accept-Encoding: gzip, deflate',
    'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7'

],]);

$resposta = curl_exec($ch);

// echo $resposta;

// Config
$array = [
    ',' => ''
];

// Codes, Returns
$code = dados($resposta,'code": ','"');
$message = dados($resposta,'msg": "','"');
$delay = dados($resposta,'delay": "','"');

// Dados Pessoais
$cpf = dados($resposta,'cpf": "','"');
$nome = dados($resposta,'nome": "','"');
$sexo = dados($resposta,'sexo": "','"');
$sexo_sigla = dados($resposta,'sexoSig": "','"');
$data_nascimento = dados($resposta,'dtNascimento": "','"');
$idade = dados($resposta,'idade": ','"');
$data_consulta = dados($resposta,'dtConsulta": "','"');

$char = $cpf;

$one = substr_replace($char, '.', 3, -8);

$two = substr_replace($one, '.', 7, -5);

$three = substr_replace($two, '-', 11, -2);

$array2 = str_split($three, 3);

$cpf = $array2[0].$array2[1].$array2[2].$array2[3].$array2[4];

if (isset($_GET['cpf']))
{
    if (strtr($code,$array) == 200)
    {
        if ($_SESSION['usuario'] === "" || $_SESSION['usuario'] === "")
        {
            $dadosCopiar = "Nome: ".$nome."\nCPF: ".$cpf."\nData de Nascimento: ".$data_nascimento."\nIdade: ".$idade."\nSexo: ".$sexo_sigla." - ".$sexo."\nData da Consulta: ".$data_consulta."\nTempo de Resposta: ".$delay."\nCode: ".strtr($code,$array)."";

            $dadosResultado = "CONSULTA REALIZADA PELA GALAXY CENTER<br /><br /> Nome: ".$nome." <br /> CPF: ".$cpf." <br /> Data de Nascimento: ".$data_nascimento." <br /> Idade: ".strtr($idade,$array)." <br /> Sexo: ".$sexo_sigla." - ".$sexo." <br /><br /> INFORMAÇÕES DA CONSULTA <br /><br /> Data da Consulta: ".$data_consulta." <br /> Tempo de Resposta: ".$delay." <br /> Código: ".strtr($code,$array)."";

            echo $dadosResultado;
        }

        else
        {
            sleep(10);
            $dadosCopiar = "Nome: ".$nome."\nCPF: ".$cpf."\nData de Nascimento: ".$data_nascimento."\nIdade: ".$idade."\nSexo: ".$sexo_sigla." - ".$sexo."\nData da Consulta: ".$data_consulta."\nTempo de Resposta: ".$delay."\nCode: ".strtr($code,$array)."";

            $dadosResultado = "CONSULTA REALIZADA PELA GALAXY CENTER<br /><br /> Nome: ".$nome." <br /> CPF: ".$cpf." <br /> Data de Nascimento: ".$data_nascimento." <br /> Idade: ".strtr($idade,$array)." <br /> Sexo: ".$sexo_sigla." - ".$sexo." <br /><br /> INFORMAÇÕES DA CONSULTA <br /><br /> Data da Consulta: ".$data_consulta." <br /> Tempo de Resposta: ".$delay." <br /> Código: ".strtr($code,$array)."";

            echo $dadosResultado;
        }
    }

    else if (strtr($code,$array) == 404)
    {
        echo "✦ INFORMAÇÕES DA CONSULTA ✦<br /><br />➠ Código: ".strtr($code,$array)."<br />➠ Mensagem: ".$message."";
    }

    else
    {
        echo "✦ INFORMAÇÕES DA CONSULTA ✦<br /><br />➠ Retorno desconhecido!";
    }
}

?>
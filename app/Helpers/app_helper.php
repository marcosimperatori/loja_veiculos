<?php

function checkError($field, $erros)
{
  if (!empty($erros) && key_exists($field, $erros)) {
    return '<div class="alert alert-danger p-1 mt-1">' . $erros[$field] . '</div>';
  }
  return '';
}

/**
 * Esta função é responsável por encriptar um ID para tornar a aplicação mais segura, pois quando usada nas rotinas de ediçõa e exclusão
 * o ID ficará embaralhado. A cada renderização da página o número é alterado.
 *
 * @param [type] $value
 * @return void
 */
function encrypt($value)
{
  $enc = \Config\Services::encrypter();
  return bin2hex($enc->encrypt($value));
}

function decrypt($value)
{
  try {
    $enc = \Config\Services::encrypter();
    return $enc->decrypt(hex2bin($value));
  } catch (\Exception $e) {
    return false;
  }
}


/**
 * Esta função recebe uma imagem no formato png e a converte para base64.
 * Ela muito útil quando existe a necessidade de passar essa imagem png para ser 
 * criado um pdf utilizando-se a biblioteca dompdf.
 *
 * @param string $pathImagem Caminho absoluto da imagem e nome da imagem
 * @return string Retorna a imagem convertida em base64
 */
//function convertePngToBase64(string $pathImagem = '../public_html/adcert/img/logotipo.png'): string

function convertePngToBase64(string $pathImagem = '/public/img/logotipo.png'): string
{
  $path = $pathImagem;
  $imageData = file_get_contents(ROOTPATH . $path);
  $base64Image = base64_encode($imageData);
  $base64ImageUrl = 'data:image/png;base64,' . $base64Image;
  return $base64ImageUrl;
}

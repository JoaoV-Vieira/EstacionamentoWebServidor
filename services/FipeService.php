<?php

class FipeService
{
    private $baseUrl = 'https://parallelum.com.br/fipe/api/v1';

    public function getTipos()
    {
        return [
            'carros' => 'Carro',
            'motos' => 'Moto',
            'caminhoes' => 'Caminhão'
        ];
    }

    public function getMarcas($tipo)
    {
        $endpoint = "{$this->baseUrl}/{$tipo}/marcas";
        return $this->fetchApi($endpoint);
    }

    public function getModelos($tipo, $codigoMarca)
    {
        $endpoint = "{$this->baseUrl}/{$tipo}/marcas/{$codigoMarca}/modelos";
        return $this->fetchApi($endpoint);
    }

    private function fetchApi($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true);
        }
        return [];
    }
}
?>
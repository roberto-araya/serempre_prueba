<?php

namespace Drupal\serempre_prueba\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\csv_serialization\Encoder\CsvEncoder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controlador Serempre consulta registro usuario.
 */
class ConsultaControllerExcel extends ControllerBase {

  /**
   * Retorna un listado de los usuario registrados.
   */
  public function csvBuild() {
    $db = \Drupal::database();
    $result = $db->select('myusers', 'u')->fields('u')->execute()->fetchAll();
    $data = array_map(function ($row) {
      return (array) $row;
    }, $result);

    $encoder = new CsvEncoder();
    $csv = $encoder->encode($data, 'csv');

    $response = new Response();

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="registro-usuarios.csv"');

    $response->setContent($csv);

    return $response;
  }

}

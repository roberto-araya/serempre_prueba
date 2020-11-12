<?php

namespace Drupal\serempre_prueba\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controlador Serempre consulta registro usuario.
 */
class ConsultaController extends ControllerBase {

  /**
   * Retorna un listado de los usuario registrados.
   */
  public function content() {
    $query = \Drupal::database()->select('myusers', 'u');

    $count_query = clone $query;
    $count_query->addExpression('Count(u.id)');

    $paged_query = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $paged_query->limit(50);
    $paged_query->setCountQuery($count_query);

    $result = $paged_query->fields('u')->execute()->fetchAll();

    $render = [
      'table' => [
        '#theme' => 'table',
        '#header' => [
          'id' => ['data' => $this->t('ID'), 'field' => 'id'],
          'name' => ['data' => $this->t('Nombre'), 'field' => 'name'],
        ],
        '#rows' => array_map(function ($row) {
          return (array) $row;
        }, $result),
        '#sticky' => TRUE,
        '#empty' => $this->t('No hay usuarios registrados aun.'),
      ],
      'pager' => ['#theme' => 'pager'],
      '#cache' => ['max-age' => 30],
    ];

    return $render;
  }

}

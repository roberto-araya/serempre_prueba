<?php

namespace Drupal\serempre_prueba\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class ImportacionForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'importacion_usuarios_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $validators = [
      'file_validate_extensions' => ['csv'],
    ];

    $form['csv_file'] = [
      '#type' => 'managed_file',
      '#name' => 'csv_file',
      '#title' => $this->t('Seleccionar archivo a importar:'),
      '#size' => 20,
      '#description' => $this->t('Formato CSV'),
      '#upload_validators' => $validators,
      '#upload_location' => 'public://',
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Importar'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('csv_file') == NULL) {
      $form_state->setErrorByName('csv_file', $this->t('File.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file = \Drupal::entityTypeManager()->getStorage('file')
      ->load($form_state->getValue('csv_file')[0]);

    $file_uri = $file->get('uri')->value;
    $f = fopen($file_uri, "r");

    while (!feof($f)) {
      $user_name = fgetcsv($f);

      $existe = db_select('myusers', 'u')
        ->fields('u')
        ->condition('name', $user_name, '=')
        ->execute()
        ->fetchAssoc();

      if (!$existe) {
        \Drupal::database()->insert('myusers')
          ->fields(['name' => $user_name[0]])
          ->execute();
      }
    }

    fclose($file);
  }

}

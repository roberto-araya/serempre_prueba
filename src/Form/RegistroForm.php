<?php

namespace Drupal\serempre_prueba\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\bootstrap4_modal\Ajax\OpenBootstrap4ModalDialogCommand;
// Uuse Symfony\Component\DependencyInjection\ContainerInterface;.
use Drupal\user\Entity\User;

/**
 * Implements an example form.
 */
class RegistroForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'usuario_registro_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'] = [
      'serempre_prueba/registro.usuario.validate',
      'bootstrap4_modal/bs4_modal.dialog.ajax',
      'serempre_prueba/bootstrap',
    ];

    $form['nombre'] = [
      '#id' => 'nombre',
      '#type' => 'textfield',
      '#title' => $this->t('Nombre usuario'),
      '#required' => TRUE,
      '#attributes' => [
        'name' => "nombre",
        'minlength' => 5,
        'accept' => "[a-zA-Z]+",
      ],
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Registrar'),
      '#ajax' => [
        'callback' => '::ajaxSubmitForm',
        'event' => 'click',
      ],
    ];
    return $form;
  }

  /**
   * Helper method so we can have consistent dialog options.
   *
   * @return string[]
   *   An array of jQuery UI elements to pass on to our dialog form.
   */
  protected static function getDataDialogOptions() {
    return [
      'width' => '40%',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('nombre')) < 5) {
      $form_state->setErrorByName('nombre', $this->t('El nombre debe terner al menos 5 letras.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * Ajax submit form callback.
   */
  public function ajaxSubmitForm(array $form, FormStateInterface $form_state) {
    $name = $form_state->getValue('nombre');

    $existe = db_select('myusers', 'u')
      ->fields('u')
      ->condition('name', $name, '=')
      ->execute()
      ->fetchAssoc();

    if (!$existe && strlen($name) >= 5) {
      $fields = ['name' => $name];
      $id = db_insert('myusers')->fields($fields)->execute();

      $user = User::create();
      $user->setPassword("pass_" . $name);
      $user->enforceIsNew();
      $user->setEmail("prueba_" . $name . "@serempre.com");
      $user->setUsername($name);
      $user->save();

      $response = new AjaxResponse();
      $response->addCommand(
      new OpenBootstrap4ModalDialogCommand(
         $this->t('Nuevo registro de usuario.'), $this->t('Tu ID es: @id', ['@id' => $id]), static::getDataDialogOptions()));

      return $response;
    }
    else {
      if (strlen($name) < 5) {
        $response = new AjaxResponse();
        $response->addCommand(
        new OpenBootstrap4ModalDialogCommand(
           $this->t('ERROR.'), $this->t('Debe tener al menos 5 caráteres'), static::getDataDialogOptions()));

        return $response;
      }
      if ($existe) {
        $response = new AjaxResponse();
        $response->addCommand(
        new OpenBootstrap4ModalDialogCommand(
           $this->t('ERROR.'), $this->t('El usuario @name ya existe.', ['@name' => $name]), static::getDataDialogOptions()));

        return $response;
      }
    }
  }

}

<?php

namespace App\Core;

abstract class AbstractController
{
  protected function render($view, $parameters)
  {
    /*foreach ($parameters AS $key => $value) {
      ${$key} = $value;
    }*/
    extract($parameters);
    include __DIR__ . "/../../views/{$view}.php";
  }


}


 ?>

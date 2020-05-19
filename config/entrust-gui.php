<?php
return [
  //"layout" => "entrust-gui::app",
  "layout" => "plantillas.admin_template",
  "route-prefix" => "seguridad",
  "pagination" => [
    "users" => 250,
    "roles" => 15,
    "permissions" => 15,
  ],
  "middleware" => ['web', 'entrust-gui.admin'],
  "unauthorized-url" => '/login',
  "middleware-role" => array('ADMINISTRACION EMPLEADOS Y PUESTOS', 'superadmin'),
  "confirmable" => false,
  "users" => [
    'fieldSearchable' => ['name'],
  ],
];

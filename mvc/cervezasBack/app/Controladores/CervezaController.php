<?php
require_once __DIR__ . '/controladorBase.php';
require_once __DIR__ . '/../modelos/cervezasModel.php';

class CervezaController extends controladorBase {
    public function __construct() {
        parent::__construct(model: new cervezasModel());
    }
}

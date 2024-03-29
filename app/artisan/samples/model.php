<?php

namespace {NAMESPACE};

class {CLASSNAME}
{
  use \Core\Model;
  protected $table = '{TABLENAME}';
  protected $allowedColumns = [
    'name',
    'email',
    'password',
    'updated_at'
  ];

  protected $validationRules = [];
}

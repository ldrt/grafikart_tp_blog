<?php
namespace App;
use Valitron\Validator as ValidatronValidator;

class Validator extends ValidatronValidator {
    protected static $_lang = "fr";

    protected function checkAndSetLabel($field, $message, $params)
    {
        return str_replace('{field}', '', $message);
    }
}

?>
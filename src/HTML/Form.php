<?php
namespace App\HTML;

class Form {
    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label) : string
    {
        $value = $this->getValue($key);
        $inputClass = $this->getInputClass($key);
        $invalidFeedback = $this->getErrorFeedback($key);
        return <<<HTML
            <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <input id="field{$key}" type="text" class="{$inputClass}" name="{$key}" value="{$value}">
            </div>
            {$invalidFeedback}
        HTML;
    }

    public function textarea(string $key, string $label) : string
    {
        $value = $this->getValue($key);
        $inputClass = $this->getInputClass($key);
        $invalidFeedback = $this->getErrorFeedback($key);
        return <<<HTML
            <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <textarea id="field{$key}" type="text" class="{$inputClass}" name="{$key}">{$value}</textarea>
            </div>
            {$invalidFeedback}
        HTML;
    }

    private function getValue(string $key) : ?string
    {
        if(is_array($this->data)) {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value =  $this->data->$method();
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass(string $key) : string
    {
        $inputClass = 'form-control';
        if(isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorFeedback(string $key) : string
    {
        if(isset($this->errors[$key])) {
            return '<div class="invalid-feeback">' . implode('<br>', $this->errors[$key]) . '</div>';
        }
        return '';
    }
}
?>
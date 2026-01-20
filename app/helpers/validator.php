<?php

function validate(array $data, array $rules, array $messages = []): array
{
    $errors = [];
    $clean  = [];

    foreach ($rules as $field => $fieldRules) {
        $value = $data[$field] ?? null;

        if (is_string($value)) {
            $value = trim($value);
        }

        $clean[$field] = $value;

        foreach ($fieldRules as $rule) {
            [$name, $param] = parse_rule($rule);

            $failed = match ($name) {
                'required' => ($value === null || $value === ''),
                'email'    => ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)),
                'min'      => (is_string($value) && mb_strlen($value) < (int)$param),
                'max'      => (is_string($value) && mb_strlen($value) > (int)$param),
                'in'       => !in_array($value, explode(',', (string)$param), true),
                'date'     => ($value !== null && $value !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$value)),
                'money'    => (floatval($value) <= 0 || (abs(floatval($value) * 100 - round(floatval($value) * 100)) > 0 )),
                default    => false,
            };

            if ($failed) {
                $errors[$field] = $messages["$field.$name"] ?? default_message($field, $name, $param);
                break; // pro Feld: nur erste Fehlermeldung (einfacher fürs UI)
            }
        }
    }

    return [$clean, $errors];
}

function parse_rule(string $rule): array
{
    $parts = explode(':', $rule, 2);
    $name  = $parts[0];
    $param = $parts[1] ?? null;
    return [$name, $param];
}

function default_message(string $field, string $rule, $param): string
{
    return match ($rule) {
        'required' => 'Dieses Feld ist erforderlich.',
        'email'    => 'Bitte gib eine gültige E-Mail-Adresse ein.',
        'min'      => "Mindestens {$param} Zeichen.",
        'max'      => "Maximal {$param} Zeichen.",
        'in'       => 'Ungültige Auswahl.',
        'date'     => 'Ungültiges Datum.',
        'money'    => 'Ungültiger Geldbetrag',
        default    => 'Ungültiger Wert.',
    };
}

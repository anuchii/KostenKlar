<?php

/**
 * Prüft on Formularfeld einen Validierungsfehler hat
 */
function field_invalid_class(array $errors, string $key): string
{
    return isset($errors[$key]) ? 'is-invalid' : '';
}

/**
 * Gibt die passende Fehlermeldung als HTML zurück, nur wenn es für das Feld einen Fehler gibt
 */
function field_error(array $errors, string $key, string $extraClass = ''): string
{
    return isset($errors[$key])
        ? '<div class="invalid-feedback ' . $extraClass . '">'
        . htmlspecialchars($errors[$key]) . '</div>'
        : '';
}

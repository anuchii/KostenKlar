<?php

function render($view, $viewData = []) {
    extract($viewData);

    require_once PAGES_PATH . "/{$view}.php";
}
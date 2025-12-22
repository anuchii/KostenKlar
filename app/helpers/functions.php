<?php

function getLoggedUserData() {
    return $_SESSION["user_data"] ?? null;
}
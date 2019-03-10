<?php

\classes\helpers\Twig::render("pages/start", [
        "verified" => $_COOKIE['verified'],
]);
<?php

function redirect($location = '') {
    header('Location: '.URL_ROOT.$location);
}
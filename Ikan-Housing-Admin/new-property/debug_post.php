<?php
file_put_contents('debug.log', "--- POST ---\n" . print_r($_POST, true) . "\n--- FILES ---\n" . print_r($_FILES, true) . "\n", FILE_APPEND);

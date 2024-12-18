<?php
/**
 * Sanitize input for HTML output
 * 
 * @param string $arg_input The input string to sanitize
 * @return string The sanitized string
 */
function str2html(string $arg_input) :string {
    return htmlspecialchars($arg_input, ENT_QUOTES, 'UTF-8');
}
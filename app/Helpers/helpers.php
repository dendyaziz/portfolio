<?php

function escape_like(string $value, string $char = '\\'): string
{
    return str_replace(
        [$char, '%', '_'],
        [$char.$char, $char.'%', $char.'_'],
        $value
    );
}


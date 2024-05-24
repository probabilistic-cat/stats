<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('bin')
    ->exclude('public')
    ->exclude('var')
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'braces_position' => [
            'allow_single_line_anonymous_functions' => true,
            'allow_single_line_empty_anonymous_classes' => true,
            'functions_opening_brace' => 'same_line',
        ],
        'cast_spaces' => ['space' => 'none'],
        'list_syntax' => ['syntax' => 'short'],
        'phpdoc_separation' => false,
        'phpdoc_summary' => false,
        'single_line_empty_body' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;

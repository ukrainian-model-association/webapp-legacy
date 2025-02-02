<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(
                [
                    __DIR__.'/src',
                ]
            )
    )
    ->setRules(
        [
            '@Symfony'                            => true,
            '@Symfony:risky'                      => true,
            '@PSR1'                               => false,
            '@PhpCsFixer'                         => false,
            '@PhpCsFixer:risky'                   => false,

            // PHP arrays should be declared using the configured syntax.
            'array_syntax'                        => [
                'syntax' => 'short',
            ],

            // Binary operators should be surrounded by space as configured.
            'binary_operator_spaces'              => [
                'align_double_arrow' => true,
                'align_equals'       => true,
            ],

            // Replaces `dirname(__FILE__)` expression with equivalent `__DIR__` constant.
            'dir_constant'                        => true,

            // Add, replace or remove header comment.
            'header_comment'                      => [
                'header'       => 'This file is part of the modelsua/modelsua package.',
                'comment_type' => 'PHPDoc',
            ],

            // Removes extra blank lines and/or blank lines following configuration.
            'no_extra_blank_lines'                => [
                'tokens' => [
                    'extra',
                    'default',
                    'curly_brace_block',
                    'parenthesis_brace_block',
                    'square_brace_block',
                ],
            ],

            // PHPDoc should contain `@param` for all params.
            'phpdoc_add_missing_param_annotation' => [
                'only_untyped' => false,
            ],

            // Annotations in PHPDoc should be ordered so that `@param` annotations come first, then `@throws` annotations, then `@return` annotations.
            'phpdoc_order'                        => true,
            
            // Annotations in PHPDoc should be grouped together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line.
            'phpdoc_separation'                   => true,

            // Single line `@var` PHPDoc should have proper spacing.
            'phpdoc_single_line_var_spacing'      => true,

            // Sorts PHPDoc types.
            'phpdoc_types_order'                  => [
                'null_adjustment' => 'always_first',
                'sort_algorithm'  => 'none',
            ],

            // Comparisons should be strict.
            'strict_comparison'                   => true,

            // Removes extra spaces between colon and case value.
            'switch_case_space'                   => true,

            // Write conditions in Yoda style (`true`), non-Yoda style (`false`) or ignore those conditions (`null`) based on configuration.
            'yoda_style'                          => true,
        ]
    );

<?php

function htmltodocx_styles_example() {

    $styles['default'] =
        array (
            'size' => 11,
        );

    $styles['elements'] =
        array (
            'h1' => array (
                'bold' => TRUE,
                'size' => 20,
            ),
            'h2' => array (
                'bold' => TRUE,
                'size' => 15,
                'spaceAfter' => 150,
            ),
            'h3' => array (
                'size' => 12,
                'bold' => TRUE,
                'spaceAfter' => 100,
            ),
            'li' => array (
            ),
            'ol' => array (
                'spaceBefore' => 200,
            ),
            'ul' => array (
                'spaceAfter' => 150,
            ),
            'b' => array (
                'bold' => TRUE,
            ),
            'em' => array (
                'italic' => TRUE,
            ),
            'i' => array (
                'italic' => TRUE,
            ),
            'strong' => array (
                'bold' => TRUE,
            ),
            'b' => array (
                'bold' => TRUE,
            ),
            'sup' => array (
                'superScript' => TRUE,
                'size' => 6,
            ), // Superscript not working in PHPWord
            'u' => array (
                'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE,
            ),
            'a' => array (
                'color' => '0000FF',
                'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE,
            ),
            'table' => array (
                'borderColor' => '000000',
                'borderSize' => 10,
            ),
            'th' => array (
                'borderColor' => '000000',
                'borderSize' => 10,
            ),
            'td' => array (
                'borderColor' => '000000',
                'borderSize' => 10,
            ),

        );

    $styles['classes'] =
        array (
            'underline' => array (
                'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE,
            ),
            'purple' => array (
                'color' => '901391',
            ),
            'green' => array (
                'color' => '00A500',
            ),
        );

    $styles['inline'] =
        array(
            'text-decoration: underline' => array (
                'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE,
            ),
            'vertical-align: left' => array (
                'align' => 'left',
            ),
            'vertical-align: middle' => array (
                'align' => 'center',
            ),
            'vertical-align: right' => array (
                'align' => 'right',
            )
        );
    return $styles;
}
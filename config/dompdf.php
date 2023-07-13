<?php

return [
    'font_dir' => config_path('dompdf_font.php'),
    'font_cache' => storage_path('fonts/'),
    'font_family' => 'Arial',
    'default_font_size' => '12',
    'default_font' => 'sans-serif',
    'dpi' => 96,
    'enable_css_float' => true,
    'enable_html5_parser' => true,
    'enable_remote' => true,
    'temp_dir' => storage_path('temp/'),
    'chroot' => realpath(base_path()),
    'unicode_enabled' => true,
    'pdf_a' => false,
    'pdf_aauto' => false,
    'debug_png' => false,
    'debug_keep_temp' => false,
    'debug_css' => false,
    'debug_layout' => false,
    'debug_layout_lines' => false,
    'debug_layout_blocks' => false,
    'debug_layout_inline' => false,
    'debug_layout_padding_box' => false,
    'isHtml5ParserEnabled' => true,
    'isRemoteEnabled' => true,
    'isJavascriptEnabled' => true,
    'enable_html5_parser' => true,
    'enable_remote' => true,
];

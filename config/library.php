<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Library Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for loan duration, fine calculation, and default
    | library operating rules.
    |
    */

    'default_loan_days' => env('LIBRARY_DEFAULT_LOAN_DAYS', 7),
    'fine_per_day' => env('LIBRARY_FINE_PER_DAY', 2000), // Default IDR 2000 per day late
    'enable_fines' => env('LIBRARY_ENABLE_FINES', true),
    'max_books_per_member' => env('LIBRARY_MAX_BOOKS_PER_MEMBER', 3),
];

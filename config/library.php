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
    'fine_per_day' => env('LIBRARY_FINE_PER_DAY', 2000),
    'enable_fines' => env('LIBRARY_ENABLE_FINES', true),
    'max_books_per_member' => env('LIBRARY_MAX_BOOKS_PER_MEMBER', 3),

    // Fine calculation based on price
    'late_fine_percentage' => env('LIBRARY_LATE_FINE_PERCENTAGE', 1), // 1% per day
    'default_daily_fine' => env('LIBRARY_DEFAULT_DAILY_FINE', 5000), // Rp 5,000 fallback per day
    'default_lost_book_fee' => env('LIBRARY_DEFAULT_LOST_BOOK_FEE', 50000), // Rp 50,000 fallback lost fee
];

<?php

return [
    'DATA_PER_PAGE' => 10,
    'AUTOCOMPLETE_MIN' => 3,
    'PAYMENT_STATUS' => [
        'PENDING' => 0,
        'COMPLETED' => 1,
        'FAILED' => 2
    ],
    'WAQF_STATUS' => [
        0 => 'Menunggu Pembayaran',
        1 => 'Pembayaran Sukses',
        2 => 'Dana Diproses',
        3 => 'Selesai',
        4 => 'Pembayaran Kadaluarsa'
    ],

    'PAYMENT_CATEGORY' => [
        'transfer' => 'Transfer Bank',
        'va' => 'Virtual Account',
        'kredit' => 'Kartu Kredit/Debit',
        'ewallet' => 'E-Wallets',
        'retail' => 'Bayar di Gerai Retail',
        'paylater' => 'PayLater'
    ],
    'PAYMENT_CODES' => [
        'transfer' => 'account_number',
        'va' => 'account_number',
        'kredit' => 'account_number',
        'ewallet' => 'business_id',
        'retail' => 'payment_code',
        'paylater' => 'business_id'
    ],
    'EXTERNAL_IDS' => [
        'transfer' => 'external_id',
        'va' => 'external_id',
        'kredit' => 'external_id',
        'ewallet' => 'reference_id',
        'retail' => 'external_id',
        'paylater' => 'reference_id'
    ],
    'LOGIN' => [
        'GUEST' => 0,
        'ADMIN' => 1,
        'USER' => 2
    ],
    'REQUIRED' => [
        'YA' => 1,
        'TIDAK' => 0,
    ],
    'STATUS' => [
        'ACTIVE' => 1,
        'INACTIVE' => 0,
    ],
    'HAS_WARNING' => [
        'YA' => 1,
        'TIDAK' => 0,
    ],
    'CHOICE' => [
        'YA' => 1,
        'TIDAK' => 0,
    ],
    'DITERIMA' => [
        'YA' => 1,
        'BELUM' => NULL,
        'TIDAK' => 0,
    ],
    'USEDBY' => [
        'ARTICLE' => 1,
        'MEDIA' => 2,
    ],
    'APPROVE' => [
        'YA' => 1,
        'TIDAK' => 0,
    ]
];

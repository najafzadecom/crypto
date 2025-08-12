<?php

return [
    'sortable_fields' => [
        'accounts' => [
            'id', 'name', 'email', 'current_amount', 'blocked_amount',
            'api_status', 'last_sync_date', 'status'
        ],
        'users' => [
            'id', 'name', 'email', 'telegram', 'created_at', 'updated_at', 'status'
        ],
        'merchants' => [
            'id', 'name', 'email', 'created_at', 'status'
        ],
        'transactions' => [
            'id', 'sender', 'amount', 'created_at', 'status', 'receiver'
        ],
        'withdrawals' => [
            'id', 'amount', 'created_at', 'status', 'receiver', 'operation_id'
        ],
        'wallets' => [
            'id', 'current_account', 'iban', 'total_amount', 'blocked_amount', 'last_sync_date', 'bank', 'status', 'description', 'currency'
        ],
        'providers' => [
            'id', 'name', 'code', 'status'
        ],
        'banks' => [
            'id', 'name', 'priority', 'status', 'created_at', 'updated_at'
        ],
        'permissions' => [
            'id', 'name', 'guard_name', 'created_at', 'updated_at'
        ],
        'roles' => [
            'id', 'name', 'guard_name', 'created_at', 'updated_at'
        ],
        'activity-logs' => [
            'id', 'log_name', 'description', 'subject_type', 'subject_id', 'causer_id', 'created_at'
        ]
    ]
];

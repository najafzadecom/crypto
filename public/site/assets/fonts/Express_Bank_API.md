# Express Bank API Documentation

``` json
{
    "info": {
        "_postman_id": "3a6258b2-b919-4cc4-8d98-12aa8de1d907",
        "name": "Express Bank",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
        "_exporter_id": "1198390"
    },
    "item": [
        {
            "name": "Bank",
            "item": [
                {
                    "name": "Transaction Enable Bank List",
                    "request": {
                        "auth": {
                            "type": "bearer",
                            "bearer": [
                                {
                                    "key": "token",
                                    "value": "{{token}}",
                                    "type": "string"
                                }
                            ]
                        },
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "{{api_url}}bank/transaction",
                            "host": [
                                "{{api_url}}bank"
                            ],
                            "path": [
                                "transaction"
                            ]
                        }
                    },
                    "response": [
                        {
                            "name": "Bank List",
                            "originalRequest": {
                                "method": "GET",
                                "header": [],
                                "url": {
                                    "raw": "https://bankexpress1.com/api/v1/bank",
                                    "protocol": "https",
                                    "host": [
                                        "bankexpress1",
                                        "com"
                                    ],
                                    "path": [
                                        "api",
                                        "v1",
                                        "bank"
                                    ]
                                }
                            },
                            "status": "OK",
                            "code": 200,
                            "_postman_previewlanguage": null,
                            "header": [
                                {
                                    "key": "Server",
                                    "value": "nginx/1.18.0 (Ubuntu)"
                                },
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                },
                                {
                                    "key": "Transfer-Encoding",
                                    "value": "chunked"
                                },
                                {
                                    "key": "Connection",
                                    "value": "keep-alive"
                                },
                                {
                                    "key": "Cache-Control",
                                    "value": "no-cache, private"
                                },
                                {
                                    "key": "Date",
                                    "value": "Thu, 07 Aug 2025 00:01:57 GMT"
                                },
                                {
                                    "key": "Access-Control-Allow-Origin",
                                    "value": "*"
                                },
                                {
                                    "key": "X-Frame-Options",
                                    "value": "SAMEORIGIN"
                                },
                                {
                                    "key": "X-XSS-Protection",
                                    "value": "1; mode=block"
                                },
                                {
                                    "key": "X-Content-Type-Options",
                                    "value": "nosniff"
                                }
                            ],
                            "cookie": [],
                            "body": "{\n    \"success\": true,\n    \"message\": \"Banks retrieved successfully\",\n    \"code\": 200,\n    \"total\": 25,\n    \"data\": [\n        {\n            \"id\": 1,\n            \"name\": \"Bank Express\",\n            \"image\": \"https://95.217.97.119/storage/uploads/banks/1754504765_68939e3d830df.png\"\n        },\n        {\n            \"id\": 3,\n            \"name\": \"Cremin, Stehr and Larson\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0000aa?text=business+Bank+culpa\"\n        },\n        {\n            \"id\": 4,\n            \"name\": \"Mohr, Bruen and Schroeder\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/008800?text=business+Bank+placeat\"\n        },\n        {\n            \"id\": 7,\n            \"name\": \"Heaney Inc\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/009999?text=business+Bank+id\"\n        },\n        {\n            \"id\": 14,\n            \"name\": \"Wisoky, Botsford and Gibson\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00cc55?text=business+Bank+molestiae\"\n        },\n        {\n            \"id\": 20,\n            \"name\": \"Eichmann, Bernier and Torp\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/008822?text=business+Bank+hic\"\n        },\n        {\n            \"id\": 26,\n            \"name\": \"Denesik, Altenwerth and Schimmel\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0044dd?text=business+Bank+tempora\"\n        },\n        {\n            \"id\": 5,\n            \"name\": \"Dooley, Wintheiser and Gerhold\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00ff99?text=business+Bank+laudantium\"\n        },\n        {\n            \"id\": 9,\n            \"name\": \"Hills-Kub\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0011cc?text=business+Bank+quam\"\n        },\n        {\n            \"id\": 22,\n            \"name\": \"Windler and Sons\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00ffcc?text=business+Bank+omnis\"\n        },\n        {\n            \"id\": 29,\n            \"name\": \"Kuvalis LLC\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00ff55?text=business+Bank+nemo\"\n        },\n        {\n            \"id\": 2,\n            \"name\": \"Moen Inc\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/007788?text=business+Bank+adipisci\"\n        },\n        {\n            \"id\": 15,\n            \"name\": \"Harvey-Grimes\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/001155?text=business+Bank+porro\"\n        },\n        {\n            \"id\": 17,\n            \"name\": \"Hilpert-Homenick\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0000cc?text=business+Bank+quis\"\n        },\n        {\n            \"id\": 6,\n            \"name\": \"Koelpin and Sons\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0088dd?text=business+Bank+dolorum\"\n        },\n        {\n            \"id\": 11,\n            \"name\": \"Turner, White and Wintheiser\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/008855?text=business+Bank+fugiat\"\n        },\n        {\n            \"id\": 8,\n            \"name\": \"Farrell and Sons\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/006688?text=business+Bank+error\"\n        },\n        {\n            \"id\": 12,\n            \"name\": \"Jast, Schuster and Senger\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00ee55?text=business+Bank+quasi\"\n        },\n        {\n            \"id\": 13,\n            \"name\": \"Hickle Inc\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0011aa?text=business+Bank+odit\"\n        },\n        {\n            \"id\": 10,\n            \"name\": \"Bogan, Osinski and Hermann\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/00ff22?text=business+Bank+cum\"\n        },\n        {\n            \"id\": 24,\n            \"name\": \"Kunze, Waelchi and Zemlak\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/009977?text=business+Bank+inventore\"\n        },\n        {\n            \"id\": 25,\n            \"name\": \"Boyle, Russel and Sauer\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/007755?text=business+Bank+aspernatur\"\n        },\n        {\n            \"id\": 23,\n            \"name\": \"Bailey, Heathcote and Cole\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/001155?text=business+Bank+optio\"\n        },\n        {\n            \"id\": 30,\n            \"name\": \"Kirlin-Blanda\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/006688?text=business+Bank+et\"\n        },\n        {\n            \"id\": 21,\n            \"name\": \"Considine, Littel and Fadel\",\n            \"image\": \"https://95.217.97.119/storage/https://via.placeholder.com/640x480.png/0088ee?text=business+Bank+at\"\n        }\n    ]\n}"
                        }
                    ]
                },
                {
                    "name": "Withdrawal Enable Bank List",
                    "request": {
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "{{api_url}}bank/withdrawal",
                            "host": [
                                "{{api_url}}bank"
                            ],
                            "path": [
                                "withdrawal"
                            ]
                        }
                    },
                    "response": []
                }
            ]
        },
        {
            "name": "Transaction",
            "item": [
                {
                    "name": "Request",
                    "request": {
                        "method": "PUT",
                        "header": [],
                        "url": {
                            "raw": "{{api_url}}transaction/ff8511fd-9912-4846-a9ef-585d2a2032e1\"",
                            "host": [
                                "{{api_url}}transaction"
                            ],
                            "path": [
                                "ff8511fd-9912-4846-a9ef-585d2a2032e1\""
                            ]
                        }
                    },
                    "response": [
                        {
                            "name": "Response",
                            "originalRequest": {
                                "method": "PUT",
                                "header": [],
                                "url": {
                                    "raw": "https://bankexpress1.com/api/v1/transaction/ff8511fd-9912-4846-a9ef-585d2a2032e1",
                                    "protocol": "https",
                                    "host": [
                                        "bankexpress1",
                                        "com"
                                    ],
                                    "path": [
                                        "api",
                                        "v1",
                                        "transaction",
                                        "ff8511fd-9912-4846-a9ef-585d2a2032e1"
                                    ]
                                }
                            },
                            "status": "OK",
                            "code": 200,
                            "_postman_previewlanguage": null,
                            "header": [
                                {
                                    "key": "Server",
                                    "value": "nginx/1.18.0 (Ubuntu)"
                                },
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                },
                                {
                                    "key": "Transfer-Encoding",
                                    "value": "chunked"
                                },
                                {
                                    "key": "Connection",
                                    "value": "keep-alive"
                                },
                                {
                                    "key": "Cache-Control",
                                    "value": "no-cache, private"
                                },
                                {
                                    "key": "Date",
                                    "value": "Thu, 28 Aug 2025 03:26:33 GMT"
                                },
                                {
                                    "key": "Access-Control-Allow-Origin",
                                    "value": "*"
                                },
                                {
                                    "key": "X-Frame-Options",
                                    "value": "SAMEORIGIN"
                                },
                                {
                                    "key": "X-XSS-Protection",
                                    "value": "1; mode=block"
                                },
                                {
                                    "key": "X-Content-Type-Options",
                                    "value": "nosniff"
                                }
                            ],
                            "cookie": [],
                            "body": "{\n    \"success\": true,\n    \"code\": 201,\n    \"message\": \"Transaction paid request successfully\",\n    \"data\": {\n        \"id\": 2,\n        \"uuid\": \"ff8511fd-9912-4846-a9ef-585d2a2032e1\",\n        \"user_id\": 1,\n        \"first_name\": \"Kamran\",\n        \"last_name\": \"Najafzade\",\n        \"sender\": \"Kamran Najafzade\",\n        \"phone\": \"+994501234567\",\n        \"amount\": 100.5,\n        \"currency\": \"TRY\",\n        \"receiver_iban\": \"TR55198931504VWBC60BU7UZSK\",\n        \"receiver_name\": \"Collin Hayes\",\n        \"receiver\": \"Collin Hayes (TR55198931504VWBC60BU7UZSK)\",\n        \"bank_id\": 1,\n        \"bank_name\": \"Ziraat Bank\",\n        \"status\": 1,\n        \"paid_status\": false,\n        \"client_ip\": \"192.168.1.1\",\n        \"created_at\": \"2025-08-28T03:26:15.000000Z\",\n        \"updated_at\": \"2025-08-28T03:26:33.000000Z\"\n    }\n}"
                        }
                    ]
                },
                {
                    "name": "Check Status",
                    "request": {
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "{{api_url}}transaction/ff8511fd-9912-4846-a9ef-585d2a2032e1/status",
                            "host": [
                                "{{api_url}}transaction"
                            ],
                            "path": [
                                "ff8511fd-9912-4846-a9ef-585d2a2032e1",
                                "status"
                            ]
                        }
                    },
                    "response": [
                        {
                            "name": "Response",
                            "originalRequest": {
                                "method": "GET",
                                "header": [],
                                "url": {
                                    "raw": "https://bankexpress1.com/api/v1/transaction/ff8511fd-9912-4846-a9ef-585d2a2032e1/status",
                                    "protocol": "https",
                                    "host": [
                                        "bankexpress1",
                                        "com"
                                    ],
                                    "path": [
                                        "api",
                                        "v1",
                                        "transaction",
                                        "ff8511fd-9912-4846-a9ef-585d2a2032e1",
                                        "status"
                                    ]
                                }
                            },
                            "status": "OK",
                            "code": 200,
                            "_postman_previewlanguage": null,
                            "header": [
                                {
                                    "key": "Server",
                                    "value": "nginx/1.18.0 (Ubuntu)"
                                },
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                },
                                {
                                    "key": "Transfer-Encoding",
                                    "value": "chunked"
                                },
                                {
                                    "key": "Connection",
                                    "value": "keep-alive"
                                },
                                {
                                    "key": "Cache-Control",
                                    "value": "no-cache, private"
                                },
                                {
                                    "key": "Date",
                                    "value": "Thu, 28 Aug 2025 03:26:57 GMT"
                                },
                                {
                                    "key": "Access-Control-Allow-Origin",
                                    "value": "*"
                                },
                                {
                                    "key": "X-Frame-Options",
                                    "value": "SAMEORIGIN"
                                },
                                {
                                    "key": "X-XSS-Protection",
                                    "value": "1; mode=block"
                                },
                                {
                                    "key": "X-Content-Type-Options",
                                    "value": "nosniff"
                                }
                            ],
                            "cookie": [],
                            "body": "{\n    \"success\": true,\n    \"code\": 201,\n    \"message\": \"Transaction details\",\n    \"data\": {\n        \"id\": 2,\n        \"uuid\": \"ff8511fd-9912-4846-a9ef-585d2a2032e1\",\n        \"user_id\": 1,\n        \"first_name\": \"Kamran\",\n        \"last_name\": \"Najafzade\",\n        \"sender\": \"Kamran Najafzade\",\n        \"phone\": \"+994501234567\",\n        \"amount\": 100.5,\n        \"currency\": \"TRY\",\n        \"receiver_iban\": \"TR55198931504VWBC60BU7UZSK\",\n        \"receiver_name\": \"Collin Hayes\",\n        \"receiver\": \"Collin Hayes (TR55198931504VWBC60BU7UZSK)\",\n        \"bank_id\": 1,\n        \"bank_name\": \"Ziraat Bank\",\n        \"status\": 1,\n        \"paid_status\": false,\n        \"client_ip\": \"192.168.1.1\",\n        \"created_at\": \"2025-08-28T03:26:15.000000Z\",\n        \"updated_at\": \"2025-08-28T03:26:33.000000Z\"\n    }\n}"
                        }
                    ]
                }
            ]
        },
        {
            "name": "Withdrawal",
            "item": [
                {
                    "name": "Create Withdrawal Request",
                    "request": {
                        "method": "POST",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"user_id\": 1,\n    \"first_name\": \"Kamran\",\n    \"last_name\": \"Najafzade\",\n    \"amount\": 100.50,\n    \"bank_id\": 1,\n    \"iban\": \"AZ21NABZ00000000137010001944\",\n    \"order_id\": \"12345\"\n}",
                            "options": {
                                "raw": {
                                    "language": "json"
                                }
                            }
                        },
                        "url": {
                            "raw": "{{api_url}}withdrawal",
                            "host": [
                                "{{api_url}}withdrawal"
                            ]
                        }
                    },
                    "response": [
                        {
                            "name": "Response",
                            "originalRequest": {
                                "method": "POST",
                                "header": [],
                                "body": {
                                    "mode": "raw",
                                    "raw": "{\n    \"user_id\": 1,\n    \"first_name\": \"Kamran\",\n    \"last_name\": \"Najafzade\",\n    \"amount\": 100.50,\n    \"bank_id\": 1,\n    \"iban\": \"AZ21NABZ00000000137010001944\",\n    \"order_id\": \"12345\"\n}",
                                    "options": {
                                        "raw": {
                                            "language": "json"
                                        }
                                    }
                                },
                                "url": {
                                    "raw": "https://bankexpress1.com/api/v1/withdrawal",
                                    "protocol": "https",
                                    "host": [
                                        "bankexpress1",
                                        "com"
                                    ],
                                    "path": [
                                        "api",
                                        "v1",
                                        "withdrawal"
                                    ]
                                }
                            },
                            "status": "OK",
                            "code": 200,
                            "_postman_previewlanguage": null,
                            "header": [
                                {
                                    "key": "Server",
                                    "value": "nginx/1.18.0 (Ubuntu)"
                                },
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                },
                                {
                                    "key": "Transfer-Encoding",
                                    "value": "chunked"
                                },
                                {
                                    "key": "Connection",
                                    "value": "keep-alive"
                                },
                                {
                                    "key": "Cache-Control",
                                    "value": "no-cache, private"
                                },
                                {
                                    "key": "Date",
                                    "value": "Thu, 28 Aug 2025 03:42:20 GMT"
                                },
                                {
                                    "key": "Access-Control-Allow-Origin",
                                    "value": "*"
                                },
                                {
                                    "key": "X-Frame-Options",
                                    "value": "SAMEORIGIN"
                                },
                                {
                                    "key": "X-XSS-Protection",
                                    "value": "1; mode=block"
                                },
                                {
                                    "key": "X-Content-Type-Options",
                                    "value": "nosniff"
                                }
                            ],
                            "cookie": [],
                            "body": "{\n    \"success\": true,\n    \"code\": 201,\n    \"message\": \"Withdrawal created successfully\",\n    \"data\": {\n        \"id\": 10,\n        \"uuid\": \"17c160bc-1829-49f3-b7a1-9e3812dd7812\",\n        \"first_name\": \"Kamran\",\n        \"last_name\": \"Najafzade\",\n        \"receiver\": \"Kamran Najafzade\",\n        \"iban\": \"AZ21NABZ00000000137010001944\",\n        \"bank_id\": 1,\n        \"bank_name\": \"Ziraat Bank\",\n        \"amount\": 100.5,\n        \"order_id\": \"12345\",\n        \"site_id\": 1,\n        \"site_name\": \"1xbet\",\n        \"sender_name\": null,\n        \"sender_iban\": null,\n        \"status\": 0,\n        \"paid_status\": false,\n        \"created_at\": \"2025-08-28T03:42:20.000000Z\",\n        \"updated_at\": \"2025-08-28T03:42:20.000000Z\"\n    }\n}"
                        }
                    ]
                },
                {
                    "name": "Check Status",
                    "protocolProfileBehavior": {
                        "disableBodyPruning": true
                    },
                    "request": {
                        "method": "GET",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"user_id\": 1,\n    \"first_name\": \"Kamran\",\n    \"last_name\": \"Najafzade\",\n    \"amount\": 100.50,\n    \"bank_id\": 1,\n    \"iban\": \"AZ21NABZ00000000137010001944\",\n    \"order_id\": \"12345\"\n}"
                        },
                        "url": {
                            "raw": "{{api_url}}withdrawal/36ba075f-ef1a-4e07-bec4-a7043e5a3d29/status",
                            "host": [
                                "{{api_url}}withdrawal"
                            ],
                            "path": [
                                "36ba075f-ef1a-4e07-bec4-a7043e5a3d29",
                                "status"
                            ]
                        }
                    },
                    "response": [
                        {
                            "name": "Response",
                            "originalRequest": {
                                "method": "GET",
                                "header": [],
                                "body": {
                                    "mode": "raw",
                                    "raw": "{\n    \"user_id\": 1,\n    \"first_name\": \"Kamran\",\n    \"last_name\": \"Najafzade\",\n    \"amount\": 100.50,\n    \"bank_id\": 1,\n    \"iban\": \"AZ21NABZ00000000137010001944\",\n    \"order_id\": \"12345\"\n}"
                                },
                                "url": {
                                    "raw": "https://bankexpress1.com/api/v1/withdrawal/a80b7294-fe03-459b-9772-231892f0b5cf/status",
                                    "protocol": "https",
                                    "host": [
                                        "bankexpress1",
                                        "com"
                                    ],
                                    "path": [
                                        "api",
                                        "v1",
                                        "withdrawal",
                                        "a80b7294-fe03-459b-9772-231892f0b5cf",
                                        "status"
                                    ]
                                }
                            },
                            "status": "OK",
                            "code": 200,
                            "_postman_previewlanguage": null,
                            "header": [
                                {
                                    "key": "Server",
                                    "value": "nginx/1.18.0 (Ubuntu)"
                                },
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                },
                                {
                                    "key": "Transfer-Encoding",
                                    "value": "chunked"
                                },
                                {
                                    "key": "Connection",
                                    "value": "keep-alive"
                                },
                                {
                                    "key": "Cache-Control",
                                    "value": "no-cache, private"
                                },
                                {
                                    "key": "Date",
                                    "value": "Thu, 28 Aug 2025 03:04:34 GMT"
                                },
                                {
                                    "key": "Access-Control-Allow-Origin",
                                    "value": "*"
                                },
                                {
                                    "key": "X-Frame-Options",
                                    "value": "SAMEORIGIN"
                                },
                                {
                                    "key": "X-XSS-Protection",
                                    "value": "1; mode=block"
                                },
                                {
                                    "key": "X-Content-Type-Options",
                                    "value": "nosniff"
                                }
                            ],
                            "cookie": [],
                            "body": "{\n    \"success\": true,\n    \"code\": 201,\n    \"message\": \"Withdrawal created successfully\",\n    \"data\": {\n        \"id\": 3,\n        \"uuid\": \"a80b7294-fe03-459b-9772-231892f0b5cf\",\n        \"first_name\": \"Kamran\",\n        \"last_name\": \"Najafzade\",\n        \"receiver\": \"Kamran Najafzade\",\n        \"iban\": \"AZ21NABZ00000000137010001944\",\n        \"bank_id\": 1,\n        \"bank_name\": \"Ziraat Bank\",\n        \"amount\": 100.5,\n        \"order_id\": \"12345\",\n        \"site_id\": 1,\n        \"site_name\": \"1xbet\",\n        \"sender_name\": null,\n        \"sender_iban\": null,\n        \"status\": 0,\n        \"created_at\": \"2025-08-28T03:01:42.000000Z\",\n        \"updated_at\": \"2025-08-28T03:01:42.000000Z\"\n    }\n}"
                        }
                    ]
                }
            ]
        }
    ],
    "auth": {
        "type": "bearer",
        "bearer": [
            {
                "key": "token",
                "value": "{{token}}",
                "type": "string"
            }
        ]
    },
    "event": [
        {
            "listen": "prerequest",
            "script": {
                "type": "text/javascript",
                "packages": {},
                "exec": [
                    ""
                ]
            }
        },
        {
            "listen": "test",
            "script": {
                "type": "text/javascript",
                "packages": {},
                "exec": [
                    ""
                ]
            }
        }
    ]
}
```

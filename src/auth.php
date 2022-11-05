<?php
declare(strict_types=1);

return [
    'user1@test.com' => [
        'name' => 'John',
        'password' => "$2y$10$8vvlJOdZv/scnV3hnflwSeDUjQnJ3qrExsN4Hzl5Xqnx1B5M2MZ1W", // use password_hash() to generate
    ],
    'user2@test.com' => [
        'name' => 'Jane',
        'password' => "$2y$10$4yR2JTUhoQxoTrRxKFcV0udBh4/0y4xwrh7JJgfCg02s0Tf8A4qLy", // use password_hash() to generate
    ],
];

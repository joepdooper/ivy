<?php

return [
    'rules' => [
        'username' => ':field must be 3–20 characters long, start with a letter, and may only contain letters, numbers, dots, underscores, or dashes.',
        'password' => ':field must be 16+ characters, incl. 1 uppercase, 1 number, 1 special character.',
        'name' => 'The field :field contains invalid characters.',
        'unique' => 'The field :field must be unique.',
        'image' => 'The field :field must contain an image.'
        ]
];

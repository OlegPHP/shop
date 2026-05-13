<?php

return [

    'required' => 'Поле :attribute обязательно для заполнения.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'min' => [
        'string' => 'Поле :attribute должно содержать минимум :min символов.',
    ],
    'max' => [
        'string' => 'Поле :attribute не должно превышать :max символов.',
    ],

    'attributes' => [
        'content' => 'комментарий',
        'rating' => 'оценка',
        'email' => 'email',
        'password' => 'пароль',
        'password_confirmation' => 'подтверждение пароля',
    ],
];

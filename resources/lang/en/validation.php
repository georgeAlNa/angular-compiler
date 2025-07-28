<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Field must be accepted.',
    'accepted_if' => 'Field must be accepted when :other is :value.',
    'active_url' => 'Field must be a valid URL.',
    'after' => 'Field must be a date after :date.',
    'after_or_equal' => 'Field must be a date after or equal to :date.',
    'alpha' => 'Field must only contain letters.',
    'alpha_dash' => 'Field must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Field must only contain letters and numbers.',
    'array' => 'Field must be an array.',
    'ascii' => 'Field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'Field must be a date before :date.',
    'before_or_equal' => 'Field must be a date before or equal to :date.',
    'between' => [
        'array' => 'Field must have between :min and :max items.',
        'file' => 'Field must be between :min and :max kilobytes.',
        'numeric' => 'Field must be between :min and :max.',
        'string' => 'Field must be between :min and :max characters.',
    ],
    'boolean' => 'Field must be true or false.',
    'can' => 'Field contains an unauthorized value.',
    'confirmed' => 'Field confirmation does not match.',
    'current_password' => 'Password is incorrect.',
    'date' => 'Field must be a valid date.',
    'date_equals' => 'Field must be a date equal to :date.',
    'date_format' => 'Field must match the format :format.',
    'decimal' => 'Field must have :decimal decimal places.',
    'declined' => 'Field must be declined.',
    'declined_if' => 'Field must be declined when :other is :value.',
    'different' => 'Field and :other must be different.',
    'digits' => 'Field must be :digits digits.',
    'digits_between' => 'Field must be between :min and :max digits.',
    'dimensions' => 'Field has invalid image dimensions.',
    'distinct' => 'Field has a duplicate value.',
    'doesnt_end_with' => 'Field must not end with one of the following: :values.',
    'doesnt_start_with' => 'Field must not start with one of the following: :values.',
    'email' => 'Field must be a valid email address.',
    'ends_with' => 'Field must end with one of the following: :values.',
    'enum' => 'Selected field is invalid.',
    'exists' => 'Selected field is invalid.',
    'extensions' => 'Field must have one of the following extensions: :values.',
    'file' => 'Field must be a file.',
    'filled' => 'Field must have a value.',
    'gt' => [
        'array' => 'Field must have more than :value items.',
        'file' => 'Field must be greater than :value kilobytes.',
        'numeric' => 'Field must be greater than :value.',
        'string' => 'Field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'Field must have :value items or more.',
        'file' => 'Field must be greater than or equal to :value kilobytes.',
        'numeric' => 'Field must be greater than or equal to :value.',
        'string' => 'Field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'Field must be a valid hexadecimal color.',
    'image' => 'Field must be an image.',
    'in' => 'Selected field is invalid.',
    'in_array' => 'Field must exist in :other.',
    'integer' => 'Field must be an integer.',
    'ip' => 'Field must be a valid IP address.',
    'ipv4' => 'Field must be a valid IPv4 address.',
    'ipv6' => 'Field must be a valid IPv6 address.',
    'json' => 'Field must be a valid JSON string.',
    'lowercase' => 'Field must be lowercase.',
    'lt' => [
        'array' => 'Field must have less than :value items.',
        'file' => 'Field must be less than :value kilobytes.',
        'numeric' => 'Field must be less than :value.',
        'string' => 'Field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'Field must not have more than :value items.',
        'file' => 'Field must be less than or equal to :value kilobytes.',
        'numeric' => 'Field must be less than or equal to :value.',
        'string' => 'Field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'Field must be a valid MAC address.',
    'max' => [
        'array' => 'Field must not have more than :max items.',
        'file' => 'Field must not be greater than :max kilobytes.',
        'numeric' => 'Field must not be greater than :max.',
        'string' => 'Field must not be greater than :max characters.',
    ],
    'max_digits' => 'Field must not have more than :max digits.',
    'mimes' => 'Field must be a file of type: :values.',
    'mimetypes' => 'Field must be a file of type: :values.',
    'min' => [
        'array' => 'Field must have at least :min items.',
        'file' => 'Field must be at least :min kilobytes.',
        'numeric' => 'Field must be at least :min.',
        'string' => 'Field must be at least :min characters.',
    ],
    'min_digits' => 'Field must have at least :min digits.',
    'missing' => 'Field must be missing.',
    'missing_if' => 'Field must be missing when :other is :value.',
    'missing_unless' => 'Field must be missing unless :other is :value.',
    'missing_with' => 'Field must be missing when :values is present.',
    'missing_with_all' => 'Field must be missing when :values are present.',
    'multiple_of' => 'Field must be a multiple of :value.',
    'not_in' => 'Selected field is invalid.',
    'not_regex' => 'Field format is invalid.',
    'numeric' => 'Field must be a number.',
    'password' => [
        'letters' => 'Field must contain at least one letter.',
        'mixed' => 'Field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'Field must contain at least one number.',
        'symbols' => 'Field must contain at least one symbol.',
        'uncompromised' => 'Field has appeared in a data leak. Please choose a different field.',
    ],
    'present' => 'Field must be present.',
    'present_if' => 'Field must be present when :other is :value.',
    'present_unless' => 'Field must be present unless :other is :value.',
    'present_with' => 'Field must be present when :values is present.',
    'present_with_all' => 'Field must be present when :values are present.',
    'prohibited' => 'Field is prohibited.',
    'prohibited_if' => 'Field is prohibited when :other is :value.',
    'prohibited_unless' => 'Field is prohibited unless :other is in :values.',
    'prohibits' => 'Field prohibits :other from being present.',
    'regex' => 'Field format is invalid.',
    'required' => 'Field is required.',
    'required_array_keys' => 'Field must contain entries for: :values.',
    'required_if' => 'Field is required when :other is :value.',
    'required_if_accepted' => 'Field is required when :other is accepted.',
    'required_unless' => 'Field is required unless :other is in :values.',
    'required_with' => 'Field is required when :values is present.',
    'required_with_all' => 'Field is required when :values are present.',
    'required_without' => 'Field is required when :values is not present.',
    'required_without_all' => 'Field is required when none of :values are present.',
    'same' => 'Field must match :other.',
    'size' => [
        'array' => 'Field must contain :size items.',
        'file' => 'Field must be :size kilobytes.',
        'numeric' => 'Field must be :size.',
        'string' => 'Field must be :size characters.',
    ],
    'starts_with' => 'Field must start with one of the following: :values.',
    'string' => 'Field must be a string.',
    'timezone' => 'Field must be a valid timezone.',
    'unique' => 'Field has already been taken.',
    'uploaded' => 'Field failed to upload.',
    'uppercase' => 'Field must be uppercase.',
    'url' => 'Field must be a valid URL.',
    'ulid' => 'Field must be a valid ULID.',
    'uuid' => 'Field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
];
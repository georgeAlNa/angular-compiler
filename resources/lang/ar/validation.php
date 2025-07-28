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

    'accepted' => 'يجب قبول الحقل.',
    'accepted_if' => 'يجب قبول الحقل عندما يكون :other هو :value.',
    'active_url' => 'يجب أن يكون الحقل رابطاً صحيحاً.',
    'after' => 'يجب أن يكون الحقل تاريخاً بعد :date.',
    'after_or_equal' => 'يجب أن يكون الحقل تاريخاً بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي الحقل على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي الحقل على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي الحقل على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون الحقل مصفوفة.',
    'ascii' => 'يجب أن يحتوي الحقل على أحرف ورموز أحادية البايت فقط.',
    'before' => 'يجب أن يكون الحقل تاريخاً قبل :date.',
    'before_or_equal' => 'يجب أن يكون الحقل تاريخاً قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي الحقل على عناصر بين :min و :max.',
        'file' => 'يجب أن يكون الحقل بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل بين :min و :max.',
        'string' => 'يجب أن يكون الحقل بين :min و :max حرف.',
    ],
    'boolean' => 'يجب أن يكون الحقل صحيح أو خطأ.',
    'can' => 'يحتوي الحقل على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد الحقل غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'يجب أن يكون الحقل تاريخاً صحيحاً.',
    'date_equals' => 'يجب أن يكون الحقل تاريخاً يساوي :date.',
    'date_format' => 'يجب أن يطابق الحقل التنسيق :format.',
    'decimal' => 'يجب أن يحتوي الحقل على :decimal منازل عشرية.',
    'declined' => 'يجب رفض الحقل.',
    'declined_if' => 'يجب رفض الحقل عندما يكون :other هو :value.',
    'different' => 'يجب أن يكون الحقل و :other مختلفين.',
    'digits' => 'يجب أن يكون الحقل :digits أرقام.',
    'digits_between' => 'يجب أن يكون الحقل بين :min و :max أرقام.',
    'dimensions' => 'الحقل له أبعاد صورة غير صحيحة.',
    'distinct' => 'الحقل له قيمة مكررة.',
    'doesnt_end_with' => 'يجب ألا ينتهي الحقل بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ الحقل بأحد القيم التالية: :values.',
    'email' => 'يجب أن يكون الحقل عنوان بريد إلكتروني صحيح.',
    'ends_with' => 'يجب أن ينتهي الحقل بأحد القيم التالية: :values.',
    'enum' => 'الحقل المحدد غير صحيح.',
    'exists' => 'الحقل المحدد غير صحيح.',
    'extensions' => 'يجب أن يحتوي الحقل على أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون الحقل ملف.',
    'filled' => 'يجب أن يحتوي الحقل على قيمة.',
    'gt' => [
        'array' => 'يجب أن يحتوي الحقل على أكثر من :value عنصر.',
        'file' => 'يجب أن يكون الحقل أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل أكبر من :value.',
        'string' => 'يجب أن يكون الحقل أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي الحقل على :value عنصر أو أكثر.',
        'file' => 'يجب أن يكون الحقل أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل أكبر من أو يساوي :value.',
        'string' => 'يجب أن يكون الحقل أكبر من أو يساوي :value حرف.',
    ],
    'hex_color' => 'يجب أن يكون الحقل لون سادس عشري صحيح.',
    'image' => 'يجب أن يكون الحقل صورة.',
    'in' => 'الحقل المحدد غير صحيح.',
    'in_array' => 'يجب أن يوجد الحقل في :other.',
    'integer' => 'يجب أن يكون الحقل رقم صحيح.',
    'ip' => 'يجب أن يكون الحقل عنوان IP صحيح.',
    'ipv4' => 'يجب أن يكون الحقل عنوان IPv4 صحيح.',
    'ipv6' => 'يجب أن يكون الحقل عنوان IPv6 صحيح.',
    'json' => 'يجب أن يكون الحقل نص JSON صحيح.',
    'lowercase' => 'يجب أن يكون الحقل بأحرف صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي الحقل على أقل من :value عنصر.',
        'file' => 'يجب أن يكون الحقل أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل أقل من :value.',
        'string' => 'يجب أن يكون الحقل أقل من :value حرف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي الحقل على أكثر من :value عنصر.',
        'file' => 'يجب أن يكون الحقل أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل أقل من أو يساوي :value.',
        'string' => 'يجب أن يكون الحقل أقل من أو يساوي :value حرف.',
    ],
    'mac_address' => 'يجب أن يكون الحقل عنوان MAC صحيح.',
    'max' => [
        'array' => 'يجب ألا يحتوي الحقل على أكثر من :max عنصر.',
        'file' => 'يجب ألا يكون الحقل أكبر من :max كيلوبايت.',
        'numeric' => 'يجب ألا يكون الحقل أكبر من :max.',
        'string' => 'يجب ألا يكون الحقل أكبر من :max حرف.',
    ],
    'max_digits' => 'يجب ألا يحتوي الحقل على أكثر من :max رقم.',
    'mimes' => 'يجب أن يكون الحقل ملف من نوع: :values.',
    'mimetypes' => 'يجب أن يكون الحقل ملف من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي الحقل على الأقل :min عنصر.',
        'file' => 'يجب أن يكون الحقل على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل على الأقل :min.',
        'string' => 'يجب أن يكون الحقل على الأقل :min حرف.',
    ],
    'min_digits' => 'يجب أن يحتوي الحقل على الأقل :min رقم.',
    'missing' => 'يجب أن يكون الحقل مفقود.',
    'missing_if' => 'يجب أن يكون الحقل مفقود عندما يكون :other هو :value.',
    'missing_unless' => 'يجب أن يكون الحقل مفقود إلا إذا كان :other هو :value.',
    'missing_with' => 'يجب أن يكون الحقل مفقود عندما يكون :values موجود.',
    'missing_with_all' => 'يجب أن يكون الحقل مفقود عندما تكون :values موجودة.',
    'multiple_of' => 'يجب أن يكون الحقل مضاعف لـ :value.',
    'not_in' => 'الحقل المحدد غير صحيح.',
    'not_regex' => 'تنسيق الحقل غير صحيح.',
    'numeric' => 'يجب أن يكون الحقل رقم.',
    'password' => [
        'letters' => 'يجب أن يحتوي الحقل على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي الحقل على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن يحتوي الحقل على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي الحقل على رمز واحد على الأقل.',
        'uncompromised' => 'ظهر الحقل في تسريب بيانات. يرجى اختيار حقل مختلف.',
    ],
    'present' => 'يجب أن يكون الحقل موجود.',
    'present_if' => 'يجب أن يكون الحقل موجود عندما يكون :other هو :value.',
    'present_unless' => 'يجب أن يكون الحقل موجود إلا إذا كان :other هو :value.',
    'present_with' => 'يجب أن يكون الحقل موجود عندما يكون :values موجود.',
    'present_with_all' => 'يجب أن يكون الحقل موجود عندما تكون :values موجودة.',
    'prohibited' => 'الحقل محظور.',
    'prohibited_if' => 'الحقل محظور عندما يكون :other هو :value.',
    'prohibited_unless' => 'الحقل محظور إلا إذا كان :other في :values.',
    'prohibits' => 'الحقل يمنع :other من الوجود.',
    'regex' => 'تنسيق الحقل غير صحيح.',
    'required' => 'الحقل مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي الحقل على إدخالات لـ: :values.',
    'required_if' => 'الحقل مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'الحقل مطلوب عندما يتم قبول :other.',
    'required_unless' => 'الحقل مطلوب إلا إذا كان :other في :values.',
    'required_with' => 'الحقل مطلوب عندما يكون :values موجود.',
    'required_with_all' => 'الحقل مطلوب عندما تكون :values موجودة.',
    'required_without' => 'الحقل مطلوب عندما لا يكون :values موجود.',
    'required_without_all' => 'الحقل مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'يجب أن يطابق الحقل :other.',
    'size' => [
        'array' => 'يجب أن يحتوي الحقل على :size عنصر.',
        'file' => 'يجب أن يكون الحقل :size كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل :size.',
        'string' => 'يجب أن يكون الحقل :size حرف.',
    ],
    'starts_with' => 'يجب أن يبدأ الحقل بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون الحقل نص.',
    'timezone' => 'يجب أن يكون الحقل منطقة زمنية صحيحة.',
    'unique' => 'الحقل مأخوذ بالفعل.',
    'uploaded' => 'فشل في رفع الحقل.',
    'uppercase' => 'يجب أن يكون الحقل بأحرف كبيرة.',
    'url' => 'يجب أن يكون الحقل رابط صحيح.',
    'ulid' => 'يجب أن يكون الحقل ULID صحيح.',
    'uuid' => 'يجب أن يكون الحقل UUID صحيح.',

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
            'rule-name' => 'رسالة مخصصة',
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
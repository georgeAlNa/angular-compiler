<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various messages that we need
    | to display to the user. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    // Success Messages
    'success' => [
        'created' => 'تم إنشاء :item بنجاح.',
        'updated' => 'تم تحديث :item بنجاح.',
        'deleted' => 'تم حذف :item بنجاح.',
        'retrieved' => 'تم استرداد :item بنجاح.',
        'operation_completed' => 'تمت العملية بنجاح.',
        'saved' => 'تم حفظ البيانات بنجاح.',
        'uploaded' => 'تم رفع الملف بنجاح.',
        'sent' => 'تم الإرسال بنجاح.',
        'processed' => 'تمت المعالجة بنجاح.',
    ],

    // Error Messages
    'error' => [
        'general' => 'حدث خطأ غير متوقع.',
        'not_found' => 'العنصر المطلوب غير موجود.',
        'unauthorized' => 'غير مصرح لك بالوصول.',
        'forbidden' => 'ممنوع الوصول.',
        'validation_failed' => 'فشل في التحقق من البيانات.',
        'server_error' => 'خطأ في الخادم.',
        'service_unavailable' => 'الخدمة غير متاحة حالياً.',
        'too_many_requests' => 'طلبات كثيرة جداً.',
        'method_not_allowed' => 'الطريقة غير مسموحة.',
        'invalid_request' => 'طلب غير صحيح.',
        'operation_failed' => 'فشلت العملية.',
        'database_error' => 'خطأ في قاعدة البيانات.',
        'connection_failed' => 'فشل في الاتصال.',
    ],

    // Authentication Messages
    'auth' => [
        'login_success' => 'تم تسجيل الدخول بنجاح.',
        'logout_success' => 'تم تسجيل الخروج بنجاح.',
        'invalid_credentials' => 'بيانات الاعتماد غير صحيحة.',
        'account_locked' => 'الحساب مقفل.',
        'account_disabled' => 'الحساب معطل.',
        'token_expired' => 'انتهت صلاحية الرمز المميز.',
        'token_invalid' => 'الرمز المميز غير صحيح.',
        'unauthorized_access' => 'وصول غير مصرح به.',
        'session_expired' => 'انتهت صلاحية الجلسة.',
        'registration_success' => 'تم التسجيل بنجاح.',
        'verification_required' => 'التحقق مطلوب.',
        'already_verified' => 'تم التحقق بالفعل.',
    ],

    // Validation Messages
    'validation' => [
        'required' => 'الحقل مطلوب.',
        'email' => 'الحقل يجب أن يكون بريد إلكتروني صحيح.',
        'unique' => 'الحقل مأخوذ بالفعل.',
        'min' => 'الحقل يجب أن يكون على الأقل :min أحرف.',
        'max' => 'الحقل يجب ألا يتجاوز :max أحرف.',
        'confirmed' => 'تأكيد الحقل غير متطابق.',
        'numeric' => 'الحقل يجب أن يكون رقم.',
        'integer' => 'الحقل يجب أن يكون رقم صحيح.',
        'boolean' => 'الحقل يجب أن يكون صحيح أو خطأ.',
        'array' => 'الحقل يجب أن يكون مصفوفة.',
        'string' => 'الحقل يجب أن يكون نص.',
        'date' => 'الحقل يجب أن يكون تاريخ صحيح.',
        'exists' => 'الحقل المحدد غير صحيح.',
        'in' => 'الحقل المحدد غير صحيح.',
        'image' => 'الحقل يجب أن يكون صورة.',
        'file' => 'الحقل يجب أن يكون ملف.',
        'url' => 'الحقل يجب أن يكون رابط صحيح.',
        'regex' => 'تنسيق الحقل غير صحيح.',
        'alpha' => 'الحقل يجب أن يحتوي على أحرف فقط.',
        'alpha_num' => 'الحقل يجب أن يحتوي على أحرف وأرقام فقط.',
    ],

    // Business Logic Messages
    'business' => [
        'insufficient_balance' => 'الرصيد غير كافي.',
        'limit_exceeded' => 'تم تجاوز الحد المسموح.',
        'duplicate_entry' => 'إدخال مكرر.',
        'invalid_operation' => 'عملية غير صحيحة.',
        'dependency_exists' => 'لا يمكن الحذف بسبب وجود تبعيات.',
        'status_conflict' => 'تعارض في الحالة.',
        'expired' => 'منتهي الصلاحية.',
        'not_available' => 'غير متاح.',
        'already_processed' => 'تمت المعالجة بالفعل.',
        'invalid_state' => 'حالة غير صحيحة.',
        'permission_denied' => 'الإذن مرفوض.',
        'quota_exceeded' => 'تم تجاوز الحصة المسموحة.',
    ],

    // Validation Messages (nested structure for custom validation)
    'validation' => [
        'required' => 'حقل :attribute مطلوب.',
        'unique' => ':attribute مأخوذ بالفعل.',
        'exists' => ':attribute المحدد غير صحيح.',
    ],

    // Attribute Names
    'attributes' => [
        'name' => 'الاسم',
        'location' => 'الموقع',
        'governorate' => 'المحافظة',
    ],
];

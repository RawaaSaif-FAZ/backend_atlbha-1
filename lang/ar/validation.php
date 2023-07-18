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

    'accepted' => 'يجب قبول الحقل :attribute',
    'accepted_if' => 'الحقل :attribute مقبول في حال ما إذا كان :other يساوي :value.',
    'active_url' => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => 'الحقل :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون الحقل :attribute ًمصفوفة',
    'before' => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => 'الحقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'current_password' => 'كلمة المرور غير صحيحة',
    'date' => 'الحقل :attribute ليس تاريخًا صحيحًا',
    'date_equals' => 'لا يساوي الحقل :attribute مع :date.',
    'date_format' => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'declined' => 'يجب رفض الحقل :attribute',
    'declined_if' => 'الحقل :attribute مرفوض في حال ما إذا كان :other يساوي :value.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي الحقل :attribute بين :min و :max رقمًا/أرقام',
    'dimensions' => ' :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'doesnt_end_with' => 'الحقل :attribute يجب ألا ينتهي بواحدة من القيم التالية: :values.',
    'doesnt_start_with' => 'الحقل :attribute يجب ألا يبدأ بواحدة من القيم التالية: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'ends_with' => ' :attribute يجب ان ينتهي بأحد القيم التالية :value.',
    'enum' => 'الحقل :attribute غير صحيح',
    'exists' => 'الحقل :attribute لاغٍ',
    'file' => ' :attribute يجب أن يكون من ملفا.',
    'filled' => 'الحقل :attribute إجباري',
    'gt' => [
        'array' => ' :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => ' :attribute يجب ان يكون اكبر من :value كيلو بايت.',
        'numeric' => ' :attribute يجب ان يكون اكبر من :value.',
        'string' => ' :attribute يجب ان يكون اكبر من :value حروفٍ/حرفًا.',
    ],
    'gte' => [
        'array' => ' :attribute يجب ان يحتوي علي :value عناصر/عنصر او اكثر.',
        'file' => ' :attribute يجب ان يكون اكبر من او يساوي :value كيلو بايت.',
        'numeric' => ' :attribute يجب ان يكون اكبر من او يساوي :value.',
        'string' => ' :attribute يجب ان يكون اكبر من او يساوي :value حروفٍ/حرفًا.',
    ],
    'image' => 'يجب أن يكون الحقل :attribute صورةً',
    'in' => 'الحقل :attribute لاغٍ',
    'in_array' => 'الحقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون الحقل :attribute عنوان IP ذا بُنية صحيحة',
    'ipv4' => 'يجب أن يكون الحقل :attribute عنوان IPv4 ذا بنية صحيحة.',
    'ipv6' => 'يجب أن يكون الحقل :attribute عنوان IPv6 ذا بنية صحيحة.',
    'json' => 'يجب أن يكون الحقل :attribute نصا من نوع JSON.',
    'lowercase' => 'الحقل :attribute يجب ان يتكون من حروف صغيرة',
    'lt' => [
        'array' => ' :attribute يجب ان يحتوي علي اقل من :value عناصر/عنصر.',
        'file' => ' :attribute يجب ان يكون اقل من :value كيلو بايت.',
        'numeric' => ' :attribute يجب ان يكون اقل من :value.',
        'string' => ' :attribute يجب ان يكون اقل من :value حروفٍ/حرفًا.',
    ],
    'lte' => [
        'array' => ' :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => ' :attribute يجب ان يكون اقل من او يساوي :value كيلو بايت.',
        'numeric' => ' :attribute يجب ان يكون اقل من او يساوي :value.',
        'string' => ' :attribute يجب ان يكون اقل من او يساوي :value حروفٍ/حرفًا.',
    ],
    'mac_address' => 'يجب أن يكون الحقل :attribute عنوان MAC ذا بنية صحيحة.',
    'max' => [
        'array' => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أصغر لـ :max.',
        'string' => 'يجب أن لا يتجاوز طول نص :attribute :max حروفٍ/حرفًا',
    ],
    'max_digits' => 'الحقل :attribute يجب ألا يحتوي أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'min' => [
        'array' => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أكبر لـ :min.',
        'string' => 'يجب أن يكون طول نص :attribute على الأقل :min حروفٍ/حرفًا',
    ],
    'min_digits' => 'الحقل :attribute يجب أن يحتوي :min أرقام على الأقل.',
    'multiple_of' => 'الحقل :attribute يجب أن يكون من مضاعفات :value.',
    'not_in' => 'الحقل :attribute لاغٍ',
    'not_regex' => 'الحقل :attribute نوعه لاغٍ',
    'numeric' => 'يجب على الحقل :attribute أن يكون رقمًا',
    'password' => [
        'letters' => 'يجب ان يشمل حقل :attribute على حرف واحد على الاقل.',
        'mixed' => 'يجب ان يشمل حقل :attribute على حرف واحد بصيغة كبيرة على الاقل وحرف اخر بصيغة صغيرة.',
        'numbers' => 'يجب ان يشمل حقل :attribute على رقم واحد على الاقل.',
        'symbols' => 'يجب ان يشمل حقل :attribute على رمز واحد على الاقل.',
        'uncompromised' => 'حقل :attribute تبدو غير آمنة. الرجاء اختيار قيمة اخرى.',
    ],
    'present' => 'يجب تقديم الحقل :attribute',
    'prohibited' => 'الحقل :attribute محظور',
    'prohibited_if' => 'الحقل :attribute محظور في حال ما إذا كان :other يساوي :value.',
    'prohibited_unless' => 'الحقل :attribute محظور في حال ما لم يكون :other يساوي :value.',
    'prohibits' => 'الحقل :attribute يحظر :other من اي يكون موجود',
    'regex' => 'صيغة الحقل :attribute .غير صحيحة',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'الحقل :attribute يجب ان يحتوي علي مدخلات للقيم التالية :values.',
    'required_if' => 'الحقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => 'الحقل :attribute إذا توفّر :values.',
    'required_with_all' => 'الحقل :attribute إذا توفّر :values.',
    'required_without' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'required_without_all' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق الحقل :attribute مع :other',
    'size' => [
        'array' => 'يجب أن يحتوي الحقل :attribute على :size عنصرٍ/عناصر بالظبط',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية لـ :size',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
    ],
    'starts_with' => 'الحقل :attribute يجب ان يبدأ بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون الحقل :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة الحقل :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل  :attribute',
    'uppercase' => 'The :attribute must be uppercase.',
    'url' => 'صيغة الرابط :attribute غير صحيحة',
    'uuid' => 'الحقل :attribute يجب ان ايكون رقم UUID صحيح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
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

    'attributes' => [
        'name' => 'الاسم',
        'user_name' => 'اسم المُستخدم',
        'email' => 'البريد الالكتروني',
        'first_name' => 'الاسم',
        'last_name' => 'اسم العائلة',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city'                  => 'المدينة',
        'country'               => 'الدولة',
        'address'               => 'العنوان',
        'phone'                 => 'الهاتف',
        'phonenumber'                => ' رقم الجوال',
        'age'                   => 'العمر',
        'sex'                   => 'الجنس',
        'gender'                => 'النوع',
        'day'                   => 'اليوم',
        'month'                 => 'الشهر',
        'year'                  => 'السنة',
        'hour'                  => 'ساعة',
        'minute'                => 'دقيقة',
        'second'                => 'ثانية',
        'content'               => 'المُحتوى',
        'description'           => 'الوصف',
        'excerpt'               => 'المُلخص',
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'available'             => 'مُتاح',
        'size'                  => 'الحجم',
        'price'                 => 'السعر',
        'desc'                  => 'نبذه',
        'title'                 => 'العنوان',
        'q'                     => 'البحث',
        'link'                  => 'الرابط ',
        'slug'                  => ' ',
        'icon'                  =>'صورة الايقونة',
        'package_id'            =>'اسم الباقة',
        'checkbox_field'         => 'الموافقة على الشروط والاحكام',
        'periodtype'             =>'مدة الاشتراك',
        'city_id'                =>'المدينة',
        'code'                   =>"الكود",
        'data.*.id'           =>"العنصر",
        'data.*.price'           =>"السعر",
        'data.*.qty'             =>"الكمية",
        'query'                   => 'البحث',
        'category'                  =>'التصنيف',
        'offer_type'          =>'نوع العرض',
        'offer_title'   =>'عنوان العرض',
        'offer_view'      =>'منصة العرض',
        'purchase_quantity' =>'الكمية',
        'purchase_type'=>'نوع المشتريات',
        'get_quantity' =>'الكمية',
        'get_type'=>'النوع ',
        'offer1_type'=>'نوع العرض الاول',
        'discount_percent'=>'نسبة التخفيض',
        'discount_value_offer2'=>' قيمة التخفيض',
        'offer_apply'=>'تطبيق العرض',
        'offer_type_minimum'=>'الحد الادنى لتطبيق العرض',
        'offer_amount_minimum'=>'قيمة الحد الادنى',
        'coupon_status'=>' تفعيل العرض مع وجود كوبون',
        'discount_value_offer3'=>'قيمة التخفيض',
        'maximum_discount'=>'الحد الأقصى للخصم ',
        'product_id'=>'المنتج',
        'get_product_id'=>'المنتج',
        'category_id'=>'التصنيف',
        'get_category_id'=>'التصنيف',
        'select_product_id'=>'المنتج',
        'select_category_id'=>'التصنيف',
        'select_payment_id'=>'طرق دفع',
        'index_page_title'=>'عنوان الصفحة ',
        'index_page_description'=>'وصف الصفحة',
        'show_pages' =>'عرض الصفحات ',
        'key_words'=>'الكلمات المفتاحية ',
        'robots'=>'ملف Robots',
        'domain'=>'الدومين',
        'message'=>'الرسالة',
        'discount_value'=>'قيمة التخفيض',
        'discount_expire_date'=>'تاريخ الانتهاء',
        'free_shipping'=>'شحن مجاني',
        'title'=>'العنوان',
        'total_price'=>'المبلغ',
        'discount'=>'الخصم',
        'discount_type'=>'نوع الخصم',
        'expire_date'=>'تاريخ الانتهاء',
        'total_redemptions'=>'عدد مرات الاستخدام للجميع',
        'user_redemptions'=>'عدد مرات الاستخدام للزبون الواحد',
        'exception_discount_product'=>'استثناء المنتجات المخفضة',
        'status'=>'الحالة',
        'service_id'=>'الخدمة',

        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'phone' => 'الهاتف',
        'phonenumber' => ' رقم الجوال',
        'age' => 'العمر',
        'sex' => 'الجنس',
        'gender' => 'النوع',
        'day' => 'اليوم',
        'month' => 'الشهر',
        'year' => 'السنة',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'content' => 'المُحتوى',
        'description' => 'الوصف',
        'excerpt' => 'المُلخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'مُتاح',
        'size' => 'الحجم',
        'price' => 'السعر',
        'desc' => 'نبذه',
        'title' => 'العنوان',
        'q' => 'البحث',
        'link' => 'الرابط ',
        'slug' => ' ',
        'icon' => 'صورة الايقونة',
        'data.*.name' => 'الاسم',
        'name_en' => 'الاسم بالانجليزي',
        'code' => 'الكود ',
        'country_id' => 'الدولة',
        'ID_number' => 'رقم الهوية',
        'image' => 'الصورة',
        'city_id' => 'المدينة',
        'comment_text' => 'نص التعليق',
        'rateing' => ' التقييم',
        'comment_for' => ' التعليق ل',
        'product_id' => '  المنتج',
        'subject' => '  العنوان',
        'message' => '  الرسالة',
        'store_id' => 'المتجر',
        'discount_type' => 'نوع الخصم',
        'discount' => 'الخصم',
        'start_at' => 'تاريخ البداية',
        'expire_date' => 'تاريخ الانتهاء',
        'total_redemptions' => 'عدد مرات الاستخدام للجميع',
        'tags' => 'التاجات',
        'data.*.video.*' => 'الفيديو',
        'data.*.title' => 'العنوان',
        'data.*.file.*' => 'الملف',
        'purchasing_price' => 'سعر الشراء',
        'selling_price' => 'سعر البيع',
        'stock' => 'المخزون',
        'amount' => 'كمية غير محدودة',
        'quantity' => 'الكمية',
        'less_qty' => ' اقل كمية للتنبيه',
        'images.*' => 'الصور المتعددة',
        'cover' => 'الصورة الرئيسية',
        'data.*.type' => 'النوع',
        'data.*.title' => 'العنوان',
        'data.*.value' => 'القيمه',
        'category_id' => 'التصنيف الرئيسي',
        'subcategory_id.*' => 'التصنيف الفرعي',
        'title' => 'العنوان',
        'video' => 'الفيديو',
        'thumbnail' => 'صورة تعريفية',
        'banar1' => 'بانر متحرك رقم 1',
        'banarstatus1' => 'حالة البانر متحرك رقم 1',
        'banar2' => 'بانر متحرك رقم 2',
        'banarstatus2' => 'حالة البانر متحرك رقم 2',
        'banar3' => 'بانر متحرك رقم 3',
        'banarstatus3' => ' حالة البانر متحرك رقم 3',
        'slider1' => 'سلايدر متحرك رقم 1',
        'sliderstatus1' => 'حالة السلايدر متحرك رقم 1',
        'slider2' => 'سلايدر متحرك رقم 2',
        'sliderstatus2' => 'حالة السلايدر متحرك رقم 2',
        'slider3' => 'سلايدر متحرك رقم 3',
        'sliderstatus3' => ' حالة السلايدر متحرك رقم 3',
        'package_id' => 'اسم الباقة',
        'checkbox_field' => 'الشروط والاحكام',
        'periodtype' => 'مدة الاشتراك',
        'city_id' =>'المدينة',
        'code' => "الكود",
        'data.*.id' => "العنصر",
        'data.*.price' => "السعر",
        'data.*.qty' => "الكمية",
        'password_confirm' => 'تأكيد كلمة المرور',
        'snapchat' => 'سناب شات',
        'facebook' => 'فيسبوك',
        'twiter' => 'تويتر',
        'whatsapp' => 'واتساب',
        'youtube' => 'يوتيوب',
        'instegram' => 'انستجرام',
        'status' => 'الحالة',
        'details' => 'التفاصيل',
        'data.*.product_id' => 'المنتج',
        'monthly_price' => 'المبلغ الشهري',
        'yearly_price' => 'المبلغ السنوي',
        'discount' => 'الخصم',
        'plan' => 'الخطة',
        'template' => 'القالب',
        'page_desc' => 'وصف الصفحة',
        'page_content' => 'محتوى الصفحة',
        'seo_title' => 'عنوان صفحة تعريفية ',
        'seo_link' => 'رابط صفحة تعريفية',
        'seo_desc' => 'وصف صفحة تعريفية',
        'order_id' => 'الطلب',
        'logo' => 'الشعار',
        'user_id' => 'المستخدم',
        'role_name' => 'اسم الدور الوظيفي',
        'permissions' => 'الصلاحيات',
        'permissions.*' => 'الصلاحيات',
        'data.*.status' => 'الحالة',
        'file' => 'الملف',
        'price' => 'السعر',
        'address' => 'العنوان',
        'store_name' => 'اسم المتجر',
        'store_email' => 'ايميل المتجر',
        'userphonenumber' => 'رقم جوال المستخدم',
        'activity_id' => 'النشاط',
        'package_id' => 'الباقة',
        'user_country_id' => 'الدولة',
        'user_city_id' => 'المدينة',
        'periodtype' => 'مدة الاشتراك',
        'package_id' => 'الباقة',
        'type' => 'النوع',
        'course_id' => 'الكورس',
        'role' => 'الدور',
        'video' => 'الفيديو',
        'unit_id' => 'الوحدة',
        'sevices' => 'الخدمة',
        'commercialregistertype'=>'السجل التجاري/ معروف',
        'fixed'=>"قيمة ثابتة",
        'fixed_amount'=>"قيمة ثابتة",
        'percent'=>"نسبة",
        "user_type"=>"نوع المستخدم",
        "If_bought_gets"=>"العرض الاول",
        "filter_category"=>"التصنيف",
        "limit"=>"الحد الاقصى",
        "price_from"=>"السعر من",
        "price_to"=>"السعر الى",
    ],

];

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

    'accepted'             => ':attribute phải được cho phép.',
    'active_url'           => ':attribute liên kết không hợp lệ.',
    'after'                => ':attribute ngày phải sau :date.',
    'after_or_equal'       => ':attribute ngày phải sau hoặc bằng :date.',
    'alpha'                => ':attribute chỉ chứa chữ cái.',
    'alpha_dash'           => ':attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang.',
    'alpha_num'            => ':attribute chỉ chứa chữ cái và số.',
    'array'                => ':attribute phải là kiểu mảng.',
    'before'               => ':attribute ngày phải trước :date.',
    'before_or_equal'      => ':attribute ngày phải trước hoặc bằng :date.',
    'between'              => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file'    => ':attribute phải nằm giữa :min và :max kilobytes.',
        'string'  => ':attribute phải nằm giữa :min and :max characters.',
        'array'   => ':attribute phải nằm giữa :min and :max items.',
    ],
    'boolean'              => ':attribute trường đúng hoặc là sai.',
    'confirmed'            => ':attribute xác nhận không phù hợp.',
    'date'                 => ':attribute ngày không hợp lệ.',
    'date_format'          => ':attribute không khớp với định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải :digits chữ số.',
    'digits_between'       => ':attribute phải nằm giữa :min và :max chữ số.',
    'dimensions'           => ':attribute kích thước hình ảnh không hợp lệ.',
    'distinct'             => ':attribute trường có giá trị trùng lập.',
    'email'                => ':attribute địa chỉ e-mail phải hợp lệ.',
    'exists'               => 'Các :attribute được chọn không hợp lệ.',
    'file'                 => ':attribute phải là tập tin.',
    'filled'               => ':attribute trường phải có giá trị.',
    'image'                => ':attribute phải là hình ảnh.',
    'in'                   => 'Các :attribute được chọn không hợp lệ.',
    'in_array'             => ':attribute trường không tồn tại trong :other.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là chuỗi JSON hợp lệ.',
    'max'                  => [
        'numeric' => ':attribute không lớn hơn :max.',
        'file'    => ':attribute có thể không lớn hơn :max kilobytes.',
        'string'  => ':attribute có thể không lớn hơn :max characters.',
        'array'   => ':attribute có thể không lớn hơn :max items.',
    ],
    'mimes'                => ':attribute phải là loại tệp: :values.',
    'mimetypes'            => ':attribute phải là loại tệp: :values.',
    'min'                  => [
        'numeric' => ':attribute phải ít nhất :min.',
        'file'    => ':attribute phải ít nhất :min kilobytes.',
        'string'  => ':attribute phải ít nhất :min characters.',
        'array'   => ':attribute phải ít nhất :min items.',
    ],
    'not_in'               => ':attribute được chọn không hợp lệ.',
    'numeric'              => ':attribute phải là số.',
    'present'              => ':attribute trường phải tồn tại.',
    'regex'                => ':attribute định dạng không hợp lệ.',
    'required'             => ':attribute yêu cầu trường.',
    'required_if'          => ':attribute yêu cầu trường khi :other là :value.',
    'required_unless'      => ':attribute yêu cầu trường trừ khi :other là :values.',
    'required_with'        => ':attribute yêu cầu trường khi :values tồn tại.',
    'required_with_all'    => ':attribute yêu cầu trường khi :values tồn tại.',
    'required_without'     => ':attribute yêu cầu trường khi :values không tồn tại.',
    'required_without_all' => ':attribute yêu cầu trường khi không có :values tồn tại.',
    'same'                 => ':attribute và :other phải khớp.',
    'size'                 => [
        'numeric' => ':attribute phải là :size.',
        'file'    => ':attribute phải là :size kilobytes.',
        'string'  => ':attribute phải là :size characters.',
        'array'   => ':attribute phải chứa :size items.',
    ],
    'string'               => ':attribute phải là chuỗi.',
    'timezone'             => ':attribute khu vực phải hợp lệ.',
    'unique'               => ':attribute đã được sử dụng.',
    'uploaded'             => ':attribute không thể tải lên.',
    'url'                  => ':attribute định dạng không hợp lệ.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

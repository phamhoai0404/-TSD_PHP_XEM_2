<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/05
 * Time: 11:27
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted'             => 'Field :attribute must be accepted.',
    'active_url'           => 'Field :attribute is not a valid URL.',
    'after'                => 'Field :attribute must be the day after :date.',
    'after_or_equal'       => 'Field :attribute must be the time after or equal :date.',
    'alpha'                => 'Field :attribute can only contain letters.',
    'alpha_dash'           => 'Field :attribute can only contain letters, numbers and dashes.',
    'alpha_num'            => 'Field :attribute can only contain letters and numbers.',
    'array'                => 'Field :attribute must be array form.',
    'before'               => 'Field :attribute must be the day before :date.',
    'before_or_equal'      => 'Field :attribute must be the time before or equal :date.',
    'between'              => [
        'numeric' => 'Field :attribute must be within :min - :max.',
        'file'    => 'File size in Field :attribute must be from :min - :max kB.',
        'string'  => 'Field :attribute must be from :min - :max letters.',
        'array'   => 'Field :attribute must be from :min - :max elements.',
    ],
    'boolean'              => 'Field :attribute must be true or false.',
    'confirmed'            => 'Confirmed value in Field :attribute is not matched.',
    'date'                 => 'Field :attribute is not the format of the day-month.',
    'date_equals'          => 'Field :attribute must be equal to :date.',
    'date_format'          => 'Field :attribute not the same as the format :format.',
    'different'            => 'Field :attribute and :other must be different.',
    'digits'               => 'The length of Field :attribute must be contain :digits digits.',
    'digits_between'       => 'The length of Field :attribute must be within :min and :max digits.',
    'dimensions'           => 'Field :attribute has invalid size.',
    'distinct'             => 'Field :attribute has duplicated value.',
    'email'                => 'Field :attribute must be a valid email.',
    'exists'               => 'The value that selected in Field :attribute is not valid.',
    'file'                 => 'Field :attribute must be a file.',
    'filled'               => 'Field :attribute can not be blank.',
    'gt'                   => [
        'numeric' => 'Value of Field :attribute must be bigger than :value.',
        'file'    => 'Size of Field :attribute must be bigger than :value kilobytes.',
        'string'  => 'The length of Field :attribute must be more than :value digits.',
        'array'   => 'Array :attribute must be more than :value elements.',
    ],
    'gte'                  => [
        'numeric' => 'Value of Field :attribute must be bigger or equal to :value.',
        'file'    => 'Size of Field :attribute must be bigger or equal to :value kilobytes.',
        'string'  => 'The length of Field :attribute must be bigger or equal to :value digits.',
        'array'   => 'Array :attribute must have at least :value elements.',
    ],
    'image'                => 'Field :attribute must be image format.',
    'in'                   => 'The value that selected in Field :attribute is not valid.',
    'in_array'             => 'Field :attribute must belong to the allowed set: :other.',
    'integer'              => 'Field :attribute must be an integer.',
    'ip'                   => 'Field :attribute must be an IP address.',
    'ipv4'                 => 'Field :attribute must be an IPv4 address.',
    'ipv6'                 => 'Field :attribute must be an IPv6 address.',
    'json'                 => 'Field :attribute must be a JSON string.',
    'lt'                   => [
        'numeric' => 'Value of Field :attribute must be less than :value.',
        'file'    => 'Size of Field :attribute must be less than :value kilobytes.',
        'string'  => 'The length of Field :attribute must be less than :value characters.',
        'array'   => 'Array :attribute must have less than :value elements.',
    ],
    'lte'                  => [
        'numeric' => 'Value of Field :attribute must be less than or equal to :value.',
        'file'    => 'Size of Field :attribute must be less than or equal to :value kilobytes.',
        'string'  => 'The length of Field :attribute must be less than or equal to :value characters.',
        'array'   => 'Array :attribute can not be more than :value elements.',
    ],
    'max'                  => [
        'numeric' => 'Field :attribute can not be more than :max.',
        'file'    => 'Size of file in Field :attribute can not be more than :max kB.',
        'string'  => 'Field :attribute can not be more than :max characters.',
        'array'   => 'Field :attribute can not be more than :max elements.',
    ],
    'mimes'                => 'Field :attribute must be a file with format: :values.',
    'mimetypes'            => 'Field :attribute must be a file with format: :values.',
    'min'                  => [
        'numeric' => 'Field :attribute must be at least :min.',
        'file'    => 'Size of file in Field :attribute must be at least :min kB.',
        'string'  => 'Field :attribute must be at least :min characters.',
        'array'   => 'Field :attribute must be at least :min elements.',
    ],
    'not_in'               => 'The value that selected in Field :attribute is not valid.',
    'not_regex'            => 'Field :attribute has invalid format.',
    'numeric'              => 'Field :attribute must be a number.',
    'present'              => 'Field :attribute must be provided.',
    'regex'                => 'Field :attribute has invalid format.',
    'required'             => 'Field :attribute can not be blank.',
    'required_if'          => 'Field :attribute can not be blank when Field :other is :value.',
    'required_unless'      => 'Field :attribute can not be blank unless :other is :values.',
    'required_with'        => 'Field :attribute can not be blank when one of :values has value.',
    'required_with_all'    => 'Field :attribute can not be blank when all of :values has value.',
    'required_without'     => 'Field :attribute can not be blank when one of :values does not have value.',
    'required_without_all' => 'Field :attribute can not be blank when all of :values does not have value.',
    'same'                 => 'Field :attribute and :other must be the same.',
    'size'                 => [
        'numeric' => 'Field :attribute must be equal to :size.',
        'file'    => 'Size of file in Field :attribute must be equal to :size kB.',
        'string'  => 'Field :attribute must contain :size characters.',
        'array'   => 'Field :attribute must contain :size elements.',
    ],
    'starts_with'          => 'Field :attribute must be started by one of below values: :values',
    'string'               => 'Field :attribute must be a characters string.',
    'timezone'             => 'Field :attribute must be a valid time zone.',
    'unique'               => 'Field :attribute has existed in database.',
    'uploaded'             => 'Field :attribute upload fail.',
    'url'                  => 'Field :attribute is not the same format as an URL.',
    'uuid'                 => 'Field :attribute must be a valid UUID string.',
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
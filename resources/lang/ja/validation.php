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
    'accepted'             => 'フィールド :attribute は受け入れられなければなりません。',
    'active_url'           => 'フィールド :attribute は有効なURLではありません。',
    'after'                => 'フィールド :attribute は :date　の翌日でなければなりません',
    'after_or_equal'       => 'フィールド :attribute は :date　以降の時間でなければなりません。',
    'alpha'                => 'フィールド :attribute は文字のみを含めることができます。',
    'alpha_dash'           => 'フィールド :attribute は文字、数字、ダッシュのみを含めることができます。',
    'alpha_num'            => 'フィールド :attribute は文字と数字のみを含めることができます。',
    'array'                => 'フィールド :attribute は配列形式でなければなりません。',
    'before'               => 'フィールド :attribute は :date　の前日でなければなりません。',
    'before_or_equal'      => 'フィールド :attribute は :date　前の時間または等しくなければなりません。',
    'between'              => [
        'numeric' => 'フィールド :attribute は :min - :max　内にある必要があります。',
        'file'    => 'フィールド :attribute にファイルのサイズは　:min - :max kB内にある必要があります',
        'string'  => 'フィールド :attribute は :min - :max 文字内にある必要があります。',
        'array'   => 'フィールド :attribute は :min - :max 要素内にある必要があります。',
    ],
    'boolean'              => 'フィールド :attribute はTRUEまたはFALSEでなければなりません。',
    'confirmed'            => 'フィールド :attribute　の確認した値は一致しません。',
    'date'                 => 'フィールド :attribute は日月の形式ではありません。',
    'date_equals'          => 'フィールド :attribute は :date　に等しくなければなりません。',
    'date_format'          => 'フィールド :attribute は :format　フォーマットと同じではありません',
    'different'            => 'フィールド :attribute は :other 異なっている必要があります。',
    'digits'               => 'フィールド :attribute　の長さは は :digits 数字が含める必要があります',
    'digits_between'       => 'フィールド :attribute　の長さは は :min and :max 数字内にある必要があります。',
    'dimensions'           => 'フィールド :attribute のサイズが無効です。',
    'distinct'             => 'フィールド :attribute の値が重複しています。',
    'email'                => 'フィールド :attribute は有効なメールでなければなりません。',
    'exists'               => 'フィールド :attribute　の選択した値は有効じゃない。',
    'file'                 => 'フィールド :attribute はファイルでなければなりません。',
    'filled'               => 'フィールド :attribute は空白にすることはできません。',
    'gt'                   => [
        'numeric' => 'フィールド :attribute　の値は :value　より大きくなければなりません。',
        'file'    => 'フィールド :attribute　のサイズは :value kilobytesより大きくなければなりません。',
        'string'  => 'フィールド :attribute の長さは :value 数字以上である必要があります。',
        'array'   => '配列 :attribute は :value 要素以上である必要があります。',
    ],
    'gte'                  => [
        'numeric' => 'フィールド :attribute の値は :value　以上である必要があります。',
        'file'    => 'フィールド :attribute　のサイズは :value kilobytes以上である必要があります。',
        'string'  => 'フィールド :attribute　の長さは :value 数字以上である必要があります。',
        'array'   => '配列 :attribute は :value 要素少なくとも持っている必要があります。',
    ],
    'image'                => 'フィールド :attribute は画像フォーマットでなければなりません。',
    'in'                   => 'フィールド :attribute　の選択した値は有効じゃない。',
    'in_array'             => 'フィールド :attribute は許可セット　:other　に属している必要があります。',
    'integer'              => 'フィールド :attribute は整数でなければなりません。',
    'ip'                   => 'フィールド :attribute はIPアドレスでなければなりません。',
    'ipv4'                 => 'フィールド :attribute はIPv4アドレスでなければなりません。',
    'ipv6'                 => 'フィールド :attribute はIPv6アドレスでなければなりません。',
    'json'                 => 'フィールド :attribute はJSON文字列でなければなりません。',
    'lt'                   => [
        'numeric' => 'フィールド :attribute　の値は :value　より小さい必要があります。',
        'file'    => 'フィールド :attribute　のサイズは :value kilobytes　より小さい必要があります。',
        'string'  => 'フィールド :attribute　の長さは :value 文字より小さい必要があります。',
        'array'   => '配列 :attribute　は :value 要素より小さい必要があります。',
    ],
    'lte'                  => [
        'numeric' => 'フィールド :attribute　の値は :value　以下でなければなりません。',
        'file'    => 'フィールド :attribute　のサイズは :value kilobytes以下でなければなりません。',
        'string'  => 'フィールド :attribute　の長さは :value 文字以下でなければなりません。',
        'array'   => '配列 :attribute は :value 要素以上になることはできません。',
    ],
    'max'                  => [
        'numeric' => 'フィールド :attribute は :max　以上になることはできません',
        'file'    => 'フィールド :attribute　のファイルサイズは :max kB以上になることはできません。',
        'string'  => 'フィールド :attribute は :max 文字以上になることはできません。',
        'array'   => 'フィールド :attribute は :max 要素以上になることはできません。',
    ],
    'mimes'                => 'フィールド :attribute は次の形式のファイルでなければなりません： :values',
    'mimetypes'            => 'フィールド :attribute は次の形式のファイルでなければなりません： :values',
    'min'                  => [
        'numeric' => 'フィールド :attribute は :min　少なくともでなければなりません。',
        'file'    => 'フィールド :attribute　のファイルサイズは :min kB少なくともでなければなりません。',
        'string'  => 'フィールド :attribute は :min 文字少なくともでなければなりません。',
        'array'   => 'フィールド :attribute は :min 要素少なくともでなければなりません。',
    ],
    'not_in'               => 'フィールド :attribute　の選択した値は有効じゃない。',
    'not_regex'            => 'フィールド :attribute のフォーマットが無効です。',
    'numeric'              => 'フィールド :attribute は数字でなければなりません。',
    'present'              => 'フィールド :attribute は提供されなければなりません。',
    'regex'                => 'フィールド :attribute のフォーマットが無効です。',
    'required'             => 'フィールド :attribute は空白にすることはできません。',
    'required_if'          => 'フィールド :other は :value　場合、フィールド :attribute は空白にすることはできません。',
    'required_unless'      => 'フィールド :other は :value　でない限り、フィールド :attribute は空白にすることはできません。',
    'required_with'        => '　:values　のいずれかに値がある場合、フィールド :attribute は空白にできません。',
    'required_with_all'    => 'すべての　:values　に値がある場合、フィールド :attribute は空白にできません。',
    'required_without'     => ':values のいずれかに値がない場合、フィールド :attribute は空白にできません。',
    'required_without_all' => 'すべての　:values　に値がない場合、フィールド :attribute は空白にできません。',
    'same'                 => 'フィールド :attribute と :other は同じでなければなりません。',
    'size'                 => [
        'numeric' => 'フィールド :attribute は :size　に等しくなければなりません。',
        'file'    => 'フィールド :attribute　のファイルサイズは :size kBに等しくなければなりません。',
        'string'  => 'フィールド :attribute は :size 文字を含まれている必要があります。',
        'array'   => 'フィールド :attribute は :size 要素を含まれている必要があります。',
    ],
    'starts_with'          => 'フィールド :attribute 以下の値のいずれかで開始する必要があります： :values',
    'string'               => 'フィールド :attribute は文字列でなければなりません。',
    'timezone'             => 'フィールド :attribute は有効なタイムゾーンである必要があります。',
    'unique'               => 'フィールド :attribute データベースに存在しています。',
    'uploaded'             => 'フィールド :attribute をアップロードに失敗しました。',
    'url'                  => 'フィールド :attribute はURLと同じ形式ではありません。',
    'uuid'                 => 'フィールド :attribute は有効なUUID文字列でなければなりません。',
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
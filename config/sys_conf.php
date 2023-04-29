<?php
/**
 * 用于配置系统需要到的配置
 */

return [
    //globe短信平台配置
    //请求地址
    'globe_app_url' => env('GLOBE_APP_URL'),
    //平台APP Id
    'globe_app_id' => env('GLOBE_APP_ID'),
    //平台APP 密钥1
    'globe_app_secret' => env('GLOBE_APP_SECRET'),
    //平台APP 密码
    'globe_passphrase' => env('GLOBE_PASSPHRASE'),

    //谷歌翻译地址
    'google_translate_url' => env("GOOGLE_TRANSLATE_URL"),
];

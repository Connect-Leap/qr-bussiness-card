<?php

function whatsappNumberFormatter(mixed $url)
{
    $parse_url_query = parse_url($url, PHP_URL_QUERY);
    $seperate_index_and_value = explode('=', $parse_url_query);
    $phone_number = $seperate_index_and_value[1];

    if ($phone_number[0] == 0) {
        return str_replace($phone_number, str_replace(0, 62, $phone_number), $url);
    }

    return $url;
}

function storageLinkFormatter(string $path, string $content, string $extension)
{
    return url($path).'/'.$content.'.'.$extension;
}

function diffDatetimeCounter(mixed $date)
{
    $now_time = new DateTime();
    $date = new DateTime($date);

    return $now_time->diff($date)->format('%h hour %i minutes %s seconds');
}

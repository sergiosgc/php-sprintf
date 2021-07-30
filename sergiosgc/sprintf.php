<?php
namespace sergiosgc;
if (!function_exists('sergiosgc\printf')) {
function printf() {
    $args = func_get_args();
    $result = call_user_func_array('\sergiosgc\sprintf', $args);
    print($result);
    return strlen($result);
}
function sprintf($format, ...$args) {
    if (count($args) && (is_array($args[count($args) - 1]) || $args[count($args) - 1] instanceof \ArrayAccess)) $namedArguments = array_pop($args); else $namedArguments = [];
    if (!preg_match_all('_(?:(?<doublepercent>%%)|(?<preceding>.*?(?:^|[^%]))%<(?<var>[^>]*)>(?<succeeding>.*?)|(?<nonvar>[^%]*%?))_', $format, $matches, PREG_SET_ORDER)) throw new \Exception('Error matching format regex');
    foreach ($matches as $i => $match) $matches[$i] = array_filter($match, "is_string", ARRAY_FILTER_USE_KEY);
    $result = '';
    foreach ($matches as $match) {
        if (array_key_exists('doublepercent', $match) && strlen($match['doublepercent'])) {
            $result .= '%%';
        } elseif (array_key_exists('nonvar', $match) && strlen($match['nonvar'])) {
            $result .= $match['nonvar'];
        } elseif (array_key_exists('var', $match) && strlen($match['var'])) {
            if (!array_key_exists($match['var'], $namedArguments)) throw new MissingConversionSpecifierException('Named convertion specifier not found: ' . $match['var'] . ' in format ' . $format);
            $result .= $match['preceding'] . $namedArguments[$match['var']] . $match['succeeding'];
        } else {
            if (0 == strlen(implode('', $match))) continue;
            throw new \Exception('Unexpected match in format');
        }
    }
    // If it looks like a valid \sprintf call, chain to \sprintf, otherwise just return the result so far
    if (count($args) == 0 || count($args) < preg_match_all('/(^%|%$|[^%]%[^%])/', $result)) return $result;
    array_unshift($args, $result);
    return \sprintf(...$args);
}
function sprintf_conversion_specifiers_in($format) {
    if (!preg_match_all('_(?:(?<doublepercent>%%)|(?<preceding>.*?(?:^|[^%]))%<(?<var>[^>]*)>(?<succeeding>.*?)|(?<nonvar>[^%]*%?))_', $format, $matches, PREG_SET_ORDER)) return [];
    foreach ($matches as $i => $match) $matches[$i] = array_filter($match, "is_string", ARRAY_FILTER_USE_KEY);
    $result = [];
    foreach ($matches as $match) {
        if (array_key_exists('doublepercent', $match) && strlen($match['doublepercent'])) {
        } elseif (array_key_exists('nonvar', $match) && strlen($match['nonvar'])) {
        } elseif (array_key_exists('var', $match) && strlen($match['var'])) {
            $result[] = $match['var'];
        }
    }
    return $result;
}
}

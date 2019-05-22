<?php
namespace sergiosgc;
function sprintf($format) {
    $args = func_get_args();
    array_shift($args);
    if (count($args) && is_array($args[count($args) - 1])) $namedArguments = array_pop($args); else $namedArguments = [];
    $offset = 0;
    $sprintfArgs = [];
    while( ($convertionOffset = strpos($format, '%', $offset)) !== FALSE ) {
        if ($convertionOffset == (strlen($format)-1)) break;
        $offset = $convertionOffset+1;
        if ($format[$offset] == '<') {
            $nameEnd = strpos($format, '>', $offset);
            if ($nameEnd === FALSE) throw new \Exception('Unterminated convertion specifier name: ' . substr($format, $offset));
            $convertionName = substr($format, $offset+1, $nameEnd - $offset - 1);
            $format = substr($format, 0, $offset) . substr($format, $nameEnd+1);
            if (!isset($namedArguments[$convertionName])) throw new \Exception('Named convertion specifier not found: ' . $convertionName);
            $sprintfArgs[] = $namedArguments[$convertionName];
        } elseif ($format[$offset] == '%') {
            $offset+=1;
        } else {
            if (count($args) == 0) throw new \Exception('Unmatched convertion specifier');
            $sprintfArgs[] = array_shift($args);
        }
    }
    array_unshift($sprintfArgs, $format);
    return call_user_func_array('\sprintf', $sprintfArgs);
}

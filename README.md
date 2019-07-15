# php-sprintf

`\sergiosgc\sprintf` adds to sprintf a new conversion specifier for named arguments. 
In regular sprintf, arguments are applied to conversion specifiers using order only: 

    $result = sprintf('%d is %s in %s', $target, $role, $container);
    
\sergiosgc\sprintf allows you to use named conversion specifiers:

    $result = sprintf('%<target> is %<role> in %<container>', [ 'target' => $target, 'role' => $role, 'container' => $container ]);
    
The first argument after the format string is an associative array of named arguments. You may also use classic position based conversion specifiers: 

    $result = sprintf('%<named> mixed with %s', [ 'named' => $someVar ], $positionalArgument);
    
`\sergiosgc\printf` shares `\sergiosgc\sprintf` behavior, except it prints the result instead of returning it.

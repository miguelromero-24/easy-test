<?php

require __DIR__ . '/vendor/autoload.php';

// Allowed classes for security
$allowedClasses = [
    'App\\Jobs\\ProcessMoviesJob',
];

try {
    // Parse inputs
    $className = $argv[1];
    $methodName = $argv[2];
    $parameters = json_decode($argv[3], true);

    // Validate class and method
    if (!in_array($className, $allowedClasses)) {
        throw new Exception("Unauthorized class: $className");
    }

    if (!class_exists($className)) {
        throw new Exception("Class $className does not exist.");
    }

    $instance = new $className($parameters['taskData']['params']);

    if (!method_exists($instance, $methodName)) {
        throw new Exception("Method $methodName does not exist in $className.");
    }

    // Execute method
    call_user_func_array([$instance, $methodName], [$parameters['taskData']['params']]);

    // Log success
    file_put_contents('job_logs.log', "[" . date('Y-m-d H:i:s') . "] SUCCESS: $className::$methodName executed.\n", FILE_APPEND);

} catch (Exception $e) {
    // Log error
    file_put_contents('background_jobs_errors.log', "[" . date('Y-m-d H:i:s') . "] ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
}

README: Custom Background Job Runner for Laravel
Overview

This project implements a custom background job runner system in Laravel that executes PHP classes and methods independently of Laravel's built-in queue system. It demonstrates scalability, error handling, and ease of use while supporting execution on both Windows and Unix-based systems.
Features

    Background Job Execution
        Runs PHP classes and methods as background processes.
        Accepts class name, method, and parameters as input.

    Error Handling
        Catches exceptions during job execution and logs errors to a dedicated background_jobs_errors.log.

    Logging
        Logs job execution details (e.g., class name, method, status) to background_jobs.log.

    Retry Mechanism
        Configurable retry attempts for failed jobs.

    Security
        Validates and sanitizes inputs to prevent unauthorized or harmful code execution.
        Only pre-approved classes are allowed for execution.

How It Works

    Global Helper Function
        A global function runBackgroundJob() is available to execute jobs as background processes.

    Execution Process
        The helper spawns a new background process using exec for Unix-based systems or start /B for Windows.
        The job execution script processes the input and logs its result.

Installation

    Clone this repository:

git clone <this-repo>
cd custom-job-runner

Install dependencies:

composer install

Configure the environment variables in .env:

APP_ENV=local
LOG_CHANNEL=stack

Set file permissions for logs:

    chmod 777 storage/logs/background_jobs.log
    chmod 777 storage/logs/background_jobs_errors.log

Usage

    Dispatching a Background Job
    Call the runBackgroundJob() helper to execute a job:

runBackgroundJob(\App\Jobs\ExampleJob::class, 'process', ['param1']);

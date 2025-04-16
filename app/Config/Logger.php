<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Log\Handlers\FileHandler;

class Logger extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Error Logging Threshold
     * --------------------------------------------------------------------------
     *
     * This setting lets you specify which error levels are logged. Threshold is a
     * value between 0 and 9. Each level corresponding to the verbosity of logs.
     *
     * 0 = Fatal errors
     * 1 = Fatal and Critical errors
     * 2 = Fatal, Critical and Error messages
     * 3 = Fatal, Critical, Error and Debug messages
     * 4 = Fatal, Critical, Error, Debug and Info messages
     * 5 = Fatal, Critical, Error, Debug, Info, Warning and Notice messages
     * 6 = Fatal, Critical, Error, Debug, Info, Warning, Notice and Alert messages
     * 7 = Fatal, Critical, Error, Debug, Info, Warning, Notice, Alert and Emergency messages
     * 8 = All messages
     * 9 = All messages plus trace information
     */
    public int $threshold = 9;

    /**
     * --------------------------------------------------------------------------
     * Date Format for Logs
     * --------------------------------------------------------------------------
     *
     * Each item that is logged has an associated date. You can use PHP date
     * codes to set your own date formatting
     */
    public string $dateFormat = 'Y-m-d H:i:s';

    /**
     * --------------------------------------------------------------------------
     * Log Handlers
     * --------------------------------------------------------------------------
     *
     * The logging system supports multiple actions to be taken when something
     * is logged. This is done by allowing for multiple Handlers, special classes
     * designed to write the log to their chosen destinations, whether that is
     * a file on the getServer, a cloud-based service, or even taking actions such
     * as emailing the dev team.
     *
     * Each handler is defined by the class name used for that handler, and it
     * MUST implement the `CodeIgniter\Log\Handlers\HandlerInterface` interface.
     *
     * The value of each key is an array of configuration items that are sent
     * to the constructor of each handler. The only required configuration item
     * is the 'handles' element, which must be an array of integer log levels.
     * This is most easily handled by using the constants defined in the
     * `Psr\Log\LogLevel` class.
     *
     * Handlers are executed in the order defined in this array, starting with
     * the one on the top and continuing down.
     */
    public array $handlers = [
        /*
         * --------------------------------------------------------------------
         * File Handler
         * --------------------------------------------------------------------
         */
        FileHandler::class => [
            'handles'         => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],
            'fileExtension'   => '',
            'filePermissions' => 0644,
            'filename'        => 'log',
        ],

        /*
         * The ChromeLoggerHandler requires the use of the Chrome web browser
         * and the ChromeLogger extension. Uncomment this block to use it.
         */
        // 'CodeIgniter\Log\Handlers\ChromeLoggerHandler' => [
        //     /*
        //      * The log levels that this handler will handle.
        //      */
        //     'handles' => ['critical', 'alert', 'emergency', 'debug',
        //                   'error', 'info', 'notice', 'warning'],
        // ],

        /*
         * The ErrorlogHandler writes the logs to PHP's native `error_log()` function.
         * Uncomment this block to use it.
         */
        // 'CodeIgniter\Log\Handlers\ErrorlogHandler' => [
        //     /* The log levels this handler can handle. */
        //     'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
        //
        //     /*
        //     * The message type where the error should go. Can be 0 or 4, or use the
        //     * class constants: `ErrorlogHandler::TYPE_OS` (0) or `ErrorlogHandler::TYPE_SAPI` (4)
        //     */
        //     'messageType' => 0,
        // ],
    ];
}

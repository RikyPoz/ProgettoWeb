<?php

class Logger {
    private $logFile;

    public function __construct($filePath) {
        $this->logFile = $filePath;
        file_put_contents($this->logFile, '');
        if (!is_writable($this->logFile)) {
            throw new Exception("Il file di log non è scrivibile: " . $this->logFile);
        }
    }

    public function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        if (is_array($message)) {
            $message = print_r($message, true);
        }
        $logEntry = "[$timestamp] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
?>
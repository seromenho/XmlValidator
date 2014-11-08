<?php

namespace XmlValidator;

class Error
{
    public $level;
    public $code;
    public $message;
    public $file;
    public $line;
    public $column;

    public function __construct($level, $code, $message, $file, $line, $column)
    {
        $this->level = $level;
        $this->code = $code;
        $this->message = $message;
        $this->file = $file;
        $this->line = $line;
        $this->column = $column;
    }
}
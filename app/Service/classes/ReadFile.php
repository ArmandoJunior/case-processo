<?php


namespace App\Service\classes;


class ReadFile
{
    private $file;

    public function __construct(string $filePath)
    {
        $this->file = fopen($filePath, 'r');
    }

    public function readFileGenerator() : iterable
    {
        while (!feof($this->file)) {
            yield fgets($this->file);
        }
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}

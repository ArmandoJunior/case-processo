<?php


namespace App\Service;


use App\Models\File;
use App\Models\Registry;
use App\Service\classes\ReadFile;
use App\Service\classes\SanitizerField;

class FileProcessing
{
    /**
     * @var array|false
     */
    private array $files;
    private string $path;
    private string $fileName;
    private SanitizerField $sanitizer;

    public function __construct(SanitizerField $sanitizer)
    {
        $this->path = public_path('/upload/');
        $this->files = array_diff(scandir($this->path), ['.', '..']);
        $this->sanitizer = $sanitizer;
    }

    public function fileProcess()
    {
        if (empty($this->files)) return 'File not found.';

        foreach ($this->files as $file) {
            $this->fileName = explode('.', $file, -1)[0];
            $fileData = File::query()->where('name', $this->fileName)->first();

            if (empty($fileData)) {
                $this->startProcessFile("$this->path$file");
                return $this->fileName;
            }

            if (!$fileData->status) break;
        }
        return 'File not found.';
    }

    private function startProcessFile(string $pathName)
    {
        $file = $this->checkIfFileExists();
        $lines = (new ReadFile($pathName))->readFileGenerator();
        $registries = [];

        foreach ($lines as $key => $line) {
            if ($key == 0) continue;
            $line = $this->sanitizer->removeDoublesSpaces($line);
            $array = $this->sanitizer->turnToArray($line);
            $arrayCleaned = $this->sanitizer->serialize($array);
            $registries[] = $arrayCleaned;
            if (count($registries) === 5000) {
                Registry::insert($registries);
                unset($registries);
            }
        }

        Registry::insert($registries);
        $file->update(['status' => File::FINISHED]);
    }

    private function checkIfFileExists()
    {
        return File::query()->create(['name' => $this->fileName, 'status' => File::IN_PROGRESS])->refresh();
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}

<?php


namespace Mmurattcann\RepositoryGenerator\Helper;


use Illuminate\Support\Facades\File;

class FileGetter
{

    private $fileInstance = null;
    private $interfacesPath = null;
    private $classesPath = null;

    public function __construct()
    {
        $this->fileInstance = new File();
        $this->interfacesPath = app_path("Repositories/Interfaces/");
        $this->classesPath = app_path("Repositories/Classes/");
    }

    public function getInterfaces()
    {
        $files = $this->fileInstance::files($this->interfacesPath);
        $interfaces = [];

        foreach ($files as $i => $path) {

            $file = pathinfo($path);

            $interfaces[$i] = $file['filename'] . "." . $file["extension"];

        }

        return $interfaces;
    }

    public function getClasses()
    {
        $files = $this->fileInstance::files($this->classesPath);

        $classes = [];

        foreach ($files as $i => $path) {

            $file = pathinfo($path);

            $classes[$i] = $file['filename'] . "." . $file["extension"];

        }

        return $classes;
    }

    public function readFiles()
    {
        return [
            "interfaces" => $this->getInterfaces(),
            "classes" => $this->getClasses()
        ];
    }

}

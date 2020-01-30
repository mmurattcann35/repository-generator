<?php

namespace Mmurattcann\RepositoryGenerator;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class InterfaceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'make:repository:interface {name : Singular model name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository';

    protected $type = "Interface";

    private $repositoryClass;

    private $model;
    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {

        $this->setRepositoryClass();

        $path = $this->getPath("Repositories/Interfaces/".'I'.$this->repositoryClass);

        if($this->alreadyExists($this->getNameInput())){

            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass('I'.$this->repositoryClass));

        //$this->customReplaceNamespace();

        $this->info("$this->type" . " Created Successfully!" );

        $this->line("<info>Created Interface: </info> $this->repositoryClass");

    }

    public function setRepositoryClass(){

        $name = ucwords(strtolower($this->argument('name')));

        $this->model = $name;

        $modelClass = $name;

        $this->repositoryClass = $modelClass.'Repository';

        return  $this;
    }

    /**
     * @param mixed $model
     */

    public function replaceClass($stub, $name)
    {
        if(!$this->name){
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException("Missing required argument model name");
        }

        return str_replace(['DummyRepository'],["$this->model"."Repository"], $stub);
    }

    protected function getStub()
    {
        return  (__DIR__.'/../../stubs/IRepository.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repository';
    }

    protected function getArguments()
    {
        return ['name', InputArgument::REQUIRED, 'The name of model class'];
    }
}

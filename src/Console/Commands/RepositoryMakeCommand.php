<?php

namespace Mmurattcann\RepositoryGenerator;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'make:repository {name : Singular model name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository';

    protected $type = "Repository Class";

    private $repositoryClass;

    private $model;

    private $repositoryName;
    private $modelName;
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
        $this->call('make:repository:interface',[
            'name' => $this->argument('name')
        ]);

        $this->setRepositoryClass();

        $path = $this->getPath("Repositories/Classes/".$this->repositoryClass);

        if($this->alreadyExists($this->getNameInput())){

            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->repositoryClass));

        $this->replaceModel($this->getStub(),$this->model);
        //$this->customReplaceNamespace();

        $this->info("$this->type" . " Created Successfully!" );

        $this->line("<info>Created Repository: </info> $this->repositoryClass");

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

        return str_replace(['DummyRepository', 'DummyModel'],["$this->model"."Repository", "$this->model"], $stub);
    }
    /**
     * @inheritDoc
     */
    public function replaceModel($stub, $name) {
        if(!$this->name){
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException("Missing required argument model name");
        }


    }

    protected function getStub()
    {
        return  base_path('app/stubs/Repository.stub');
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

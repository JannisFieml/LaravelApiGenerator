<?php


namespace Jannisfieml\LaravelApiGenerator\Services;

use Illuminate\Support\Str;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;

class GenerateTestsService extends BaseGenerateService
{
    /**
     * @var string
     */
    private $action;

    public function __construct(array $schema, string $action)
    {
        $this->action = Str::ucfirst($action);
        parent::__construct($schema);
    }

    public function generate(): string
    {
        $printer = new Printer();
        $file = new PhpFile();
        $namespace = $file->addNamespace("Tests\Controller\\" . $this->getModel());
        $class = $namespace->addClass($this->action . "ActionTest");
        $namespace->addUse("Tests\TestCase");

        $class->setExtends("Tests\TestCase");

        $class->addMethod('testBasicTest')
            ->setPublic()
            ->setBody($this->getTestBody());

        return $printer->printFile($file);
    }

    private function getTestBody(): string
    {
        return "\$this->assertTrue(true);";
    }

    public function getFileName(): string
    {
        return $this->action . "ActionTest.php";
    }
}

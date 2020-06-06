<?php
namespace App\Support\Helpers;

require_once '/home/mathon/laravel/ghanadriver7/vendor/autoload.php';

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

$sc = new ShellCommand();
$sc->restoreDatabase();

class ShellCommand
{
    public function restoreDatabase() {
        $process = new Process(['./load_gdnew.sh'], '/home/mathon/laravel/ghanadriver7');
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        echo $process->getOutput();
    }
}




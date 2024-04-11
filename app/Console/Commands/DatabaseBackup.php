<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use File;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'respaldo de la base de datos a un archivo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ds = DIRECTORY_SEPARATOR;
    $host = env('DB_HOST',"127.0.0.1");
    $username = env('DB_USERNAME', "root");
    $password = env('DB_PASSWORD', "olmec8212lemon.");
    $database = env('DB_DATABASE', "gcedva");
    $path = database_path('backups' . $ds);
    $file = 'bd' . date('_Y-m-d_Hmi') . '.sql';
    if (!is_dir($path)) {
            mkdir($path, 0755, true);
    }
    $this->line('<fg=cyan>Backup: </><fg=yellow;bg=black>'. $path . $file . '</>');
    # Generamos el comando con mysqldump para exportar los datos
    //dd($host);
    $command = sprintf(
        'mysqldump --host="%s" --user="%s" '
        , $host, $username
        );
    if (!empty($password)) {
        $command .= sprintf('--password="%s" ', $password);
    }
    $command .= sprintf('%s > "%s"', $database, $path . $file);
    $this->line('<fg=green>CMD: </><fg=yellow;bg=black>'. $command . '</>');
    exec($command, $output, $return);
    if ($return) {
        $this->line('<fg=red;bg=yellow>Error al intentar generar el Backup</>');
        if (file_exists($path . $ds . $file)) {
            unlink($path . $ds . $file);
        }
        return; // error
    }
    // Comprimiendo el archivo:
    // mayor info: https://www.php.net/manual/es/function.gzopen.php
    // Open the gz file (w9 is the highest compression)
    $fileCompress = gzopen ($path . $ds . $file . '.gz', 'w9');
    // Compress the file
    gzwrite ($fileCompress, file_get_contents($path . $ds . $file));
    // Close the gz file and we are done
    gzclose($fileCompress);
    // Generando el esquema
    $path = database_path('backups' . $ds . 'schemas'. $ds);
    $file = 'schema.sql';
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
    # Generamos el comando con mysqldump para exportar la estructura
    $command = sprintf(
        'mysqldump --skip-comments --skip-compact '
        . ' --no-data --host="%s" --user="%s" '
        , $host, $username
        );
    if (!empty($password)) {
        $command .= sprintf('--password="%s" ', $password);
    }
    $command .= sprintf(
        '%s | sed "s/ AUTO_INCREMENT=[0-9]*//g"  > "%s"',
        $database, $path . $file
    );
    $this->line('<fg=magenta>Generando Schema</>');
    exec($command, $output, $return);
    if ($return) {
        $this->line('<fg=red;bg=yellow>Error al intentar generar el Schema</>');
        if (file_exists($path . $ds . $file)) {
            unlink($path . $ds . $file);
        }
        return; // error
    }
    }
}

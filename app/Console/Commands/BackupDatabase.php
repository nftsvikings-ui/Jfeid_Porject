<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'database:backup';
    protected $description = 'Backup the PostgreSQL database daily';

    public function handle()
    {
        $dbUrl = env('DB_URL');
        $parts = $dbUrl ? parse_url($dbUrl) : false;

        if ($dbUrl && $parts === false) {
            $this->error('Backup failed: DB_URL is set but invalid.');
            return self::FAILURE;
        }

        $dbHost = $parts['host'] ?? env('DB_HOST', '127.0.0.1');
        $dbPort = (string) ($parts['port'] ?? env('DB_PORT', '5432'));
        $dbName = isset($parts['path']) ? ltrim($parts['path'], '/') : env('DB_DATABASE', 'your_db_name');
        $dbUser = isset($parts['user']) ? urldecode($parts['user']) : env('DB_USERNAME', 'postgres');
        $dbPass = isset($parts['pass']) ? urldecode($parts['pass']) : env('DB_PASSWORD', '');

        if ($dbHost === '' || $dbName === '' || $dbUser === '') {
            $this->error('Backup failed: missing DB host/database/username in DB_URL (or fallback DB_* vars).');
            return self::FAILURE;
        }

        $date = date('Y-m-d_H-i-s');
        $fileName = "backup-{$date}.sql";

        // Path to save the backup
        $filePath = storage_path("app/backups/{$fileName}");

        // Make sure backups folder exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Execute pg_dump (postgresql-client package is required in the container image)
        $hostArg = escapeshellarg($dbHost);
        $userArg = escapeshellarg($dbUser);
        $dbArg = escapeshellarg($dbName);
        $fileArg = escapeshellarg($filePath);
        $portArg = escapeshellarg($dbPort);
        $passArg = escapeshellarg($dbPass);

        $command = "PGPASSWORD={$passArg} pg_dump -h {$hostArg} -p {$portArg} -U {$userArg} {$dbArg} > {$fileArg}";

        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Backup successful: {$fileName}");
        } else {
            $this->error("Backup failed!");
        }
    }
}

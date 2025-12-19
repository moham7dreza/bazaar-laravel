<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Disk;
use App\Exceptions\BackupDownloadException;
use App\Exceptions\BackupIntegrityException;
use App\Exceptions\BackupProcessingException;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class BackupService
{
    /**
     * @throws BackupProcessingException
     */
    public function downloadRemoteBackup(string $backupUrl, string $destinationPath): true
    {
        try
        {
            $this->validateBackupUrl($backupUrl);

            $response = Http::timeout(300)->get($backupUrl);

            if ($response->failed())
            {
                throw new BackupDownloadException(
                    message: 'Failed to retrieve backup from ' . $backupUrl,
                    context: [
                        'backup_url'  => $backupUrl,
                        'status_code' => $response->status(),
                        'reason'      => $response->reason(),
                    ]
                );
            }

            $fileSize = $response->header('Content-Length');
            $this->logBackupStart($backupUrl, $fileSize);

            Storage::disk(Disk::Backups)->writeStream(
                $destinationPath,
                $response->resource()
            );

            $this->verifyBackupIntegrity($destinationPath, $fileSize);
            $this->logBackupCompletion($destinationPath);

            return true;

        } catch (Exception $exception)
        {
            $this->logBackupError($backupUrl, $exception->getMessage());

            throw_if($exception instanceof BackupDownloadException, $exception);

            throw new BackupProcessingException(
                message: 'Backup operation failed: ' . $exception->getMessage(),
                context: [
                    'backup_url'       => $backupUrl,
                    'destination_path' => $destinationPath,
                ],
                previous: $exception
            );
        }
    }

    public function syncMediaLibrary(array $mediaUrls): array
    {
        $results = [];

        foreach ($mediaUrls as $url)
        {
            $filename = basename(parse_url((string) $url, PHP_URL_PATH));

            try
            {
                $response = Http::get($url);

                if ($response->successful())
                {
                    Storage::disk(Disk::Media)->writeStream(
                        'library/' . $filename,
                        $response->resource()
                    );

                    $results[$url] = 'success';
                } else
                {
                    $results[$url] = 'failed';
                }

            } catch (Exception $e)
            {
                $results[$url] = 'error: ' . $e->getMessage();
            }
        }

        return $results;
    }

    private function validateBackupUrl(string $url): void
    {
        throw_unless(filter_var($url, FILTER_VALIDATE_URL), InvalidArgumentException::class, 'Invalid backup URL provided');
    }

    /**
     * @throws BackupIntegrityException
     */
    private function verifyBackupIntegrity(string $path, $expectedSize): void
    {
        $actualSize = Storage::disk(Disk::Backups)->size($path);

        throw_if($expectedSize && $actualSize !== (int) $expectedSize, BackupIntegrityException::class, 'File size mismatch during backup verification');
    }

    private function logBackupCompletion(string $destinationPath): void
    {
    }

    private function logBackupStart(string $backupUrl, string $fileSize): void
    {
    }

    private function logBackupError(string $backupUrl, string $getMessage): void
    {
    }
}

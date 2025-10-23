<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\StorageDisk;
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
                throw new BackupDownloadException("Failed to retrieve backup from {$backupUrl}");
            }

            $fileSize = $response->header('Content-Length');
            $this->logBackupStart($backupUrl, $fileSize);

            Storage::disk(StorageDisk::BACKUPS->value)->writeStream(
                $destinationPath,
                $response->resource()
            );

            $this->verifyBackupIntegrity($destinationPath, $fileSize);
            $this->logBackupCompletion($destinationPath);

            return true;

        } catch (Exception $e)
        {
            $this->logBackupError($backupUrl, $e->getMessage());
            throw new BackupProcessingException("Backup operation failed: {$e->getMessage()}");
        }
    }

    public function syncMediaLibrary(array $mediaUrls): array
    {
        $results = [];

        foreach ($mediaUrls as $url)
        {
            $filename = basename(parse_url($url, PHP_URL_PATH));

            try
            {
                $response = Http::get($url);

                if ($response->successful())
                {
                    Storage::disk(StorageDisk::MEDIA->value)->writeStream(
                        "library/{$filename}",
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
        if ( ! filter_var($url, FILTER_VALIDATE_URL))
        {
            throw new InvalidArgumentException('Invalid backup URL provided');
        }
    }

    /**
     * @throws BackupIntegrityException
     */
    private function verifyBackupIntegrity(string $path, $expectedSize): void
    {
        $actualSize = Storage::disk(StorageDisk::BACKUPS->value)->size($path);

        if ($expectedSize && $actualSize !== (int) $expectedSize)
        {
            throw new BackupIntegrityException('File size mismatch during backup verification');
        }
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

<?php

namespace App\Console\Commands;

use App\Models\User;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Console\Command;
use Storage;

class UploadImagesToDriveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:uploadImagesToDrive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron command to upload users images to google drive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::files('public/images');
        $serviceAccountFile = storage_path('app/public/service-account.json');
        $client = new Google_Client();
        $client->setAuthConfig($serviceAccountFile);
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setSubject(config('filesystems.disks.google_drive.service_account'));
        $driveService = new Google_Service_Drive($client);
        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $userId = explode('_',$fileName)[0];
            $driveFile = new Google_Service_Drive_DriveFile([
                'name' => $fileName,
                'parents' => [config('filesystems.disks.google_drive.folder')],
            ]);

            $uploadedFile = $driveService->files->create(
                $driveFile,
                [
                    'data' => Storage::get($file),
                    'mimeType' => Storage::mimeType($file),
                    'uploadType' => 'multipart',
                ]
            );

            $fileId = $uploadedFile->id;
            $userId = explode('.',$fileName)[0];
            $driveService->permissions->create(
                $fileId,
                new Google_Service_Drive_Permission([
                    'type' => 'anyone',
                    'role' => 'reader',
                ])
            );
            
            User::where('id',$userId)->update([
                'photo' => $fileId
            ]);
            Storage::delete($file);
        }
        return Command::SUCCESS;
    }
}

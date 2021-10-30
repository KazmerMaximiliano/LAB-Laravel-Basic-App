<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function downloadDB()
    {
        $db_username = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');
        $db_database = env('DB_DATABASE');

        $name = 'export_' . time() . '.sql';
        $path = base_path('vendor/backup/');
        $backup_path = $path . $name;
        $now = Carbon::now()->format('d/m/Y H:i');

        if (file_exists(base_path('vendor/backup/backups.json'))) {
            $file = file_get_contents(base_path('vendor/backup/backups.json'));
            $data = json_decode($file, true);
            array_push($data, [
                'id' => count($data) + 1,
                'name' => $name,
                'date' => $now
            ]);
            $newFile = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents(base_path('vendor/backup/backups.json'), stripslashes($newFile));
        } else {
            $data = [];
            array_push($data, [
                'id' => count($data) + 1,
                'name' => $name,
                'date' => $now
            ]);
            $newFile = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents(base_path('vendor/backup/backups.json'), stripslashes($newFile));
        }

        exec("(mysqldump -u$db_username -p$db_password $db_database > $backup_path) 2>&1");
        return response()->download($backup_path);
    }

    public function downloadBackup($id)
    {
        if (file_exists(base_path('vendor/backup/backups.json'))) {
            $file = file_get_contents(base_path('vendor/backup/backups.json'));
            $data = json_decode($file);
            $index = array_search($id, array_column($data, 'id'));
            $name = $data[$index]->name;
            $path = base_path('vendor/backup/');
            $backup_path = $path . $name;

            return response()->download($backup_path);
        } else {
            return [];
        }
    }

    public function getsBackups()
    {
        if (file_exists(base_path('vendor/backup/backups.json'))) {
            $file = file_get_contents(base_path('vendor/backup/backups.json'));
            $data = json_decode($file, true);
            return $data;
        } else {
            return [];
        }
    }
}

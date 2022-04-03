<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Sopamo\LaravelFilepond\Filepond;

class UploadController extends Controller
{

    private $filepond;

    public function __construct(Filepond $filepond)
    {
        $this->filepond = $filepond;
    }


    public function upload(Request $request)
        {
            // $input = $request->file(config('filepond.input_name'));
            // if ($input === null) {
            //     return Response::make(config('filepond.input_name') . ' is required', 422, [
            //         'Content-Type' => 'text/plain',
            //     ]);
            // }
            // $file = is_array($input) ? $input[0] : $input;
            // $path = config('filepond.temporary_files_path', 'filepond');
            // $disk = config('filepond.temporary_files_disk', 'local');
            // if (! ($newFile = $file->storeAs($path . DIRECTORY_SEPARATOR . Str::random(), $file->getClientOriginalName(), $disk))) {
            //     return Response::make('Could not save file', 500, [
            //         'Content-Type' => 'text/plain',
            //     ]);
            // }
            // return Response::make(Storage::disk($disk)->path($newFile), 200, [
            //     'Content-Type' => 'text/plain',
            // ]);
                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $filename = $file->getClientOriginalName();
                    $folder = uniqid().'-'.now()->timestamp;
                    $file->storeAs('files/'.$folder, $filename);
                    return storage_path('app/public/files/'.$folder.'/'.$filename);
                }
                return '';
        }

    public function delete(Request $request)
    {
        return $request;
        $filePath = $this->filepond->getPathFromServerId($request->getContent());
        if (Storage::disk(config('filepond.temporary_files_disk', 'local'))->delete($filePath)) {
            return Response::make('', 200, [
                'Content-Type' => 'text/plain',
            ]);
        }

        return Response::make('', 500, [
            'Content-Type' => 'text/plain',
        ]);
    }
}

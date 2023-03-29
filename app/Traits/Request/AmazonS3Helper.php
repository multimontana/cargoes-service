<?php

namespace App\Traits\Request;

use Illuminate\Http\Request;

trait AmazonS3Helper
{
    /**
     * @param Request $request
     * @param string $key
     * @param string $folder
     * @return string
     */
    public function uploadImageFromAmazon(Request $request, string $key, string $folder): ?string
    {
        if (config('app.debug')) {
            if ($request->file($key)) {
                $awsUrl = $request->file($key)->store('test/' . $folder, 's3');
                return env('AWS_URL') . $awsUrl;
            } else {
                return $request->input('image');
            }
        } else {
            if ($request->file($key)) {
                $awsUrl = $request->file($key)->store($folder, 's3');
                return env('AWS_URL') . $awsUrl;
            } else {
                return $request->input('image');
            }
        }
    }

    /**
     * @param Request $request
     * @param string $key
     * @param string $folder
     * @return array
     */
    public function uploadMultipleImageFromAmazon(Request $request, string $key, string $folder): array
    {
        $links = [];

        if (config('app.debug')) {
            if ($request->hasFile($key)) {
                $files = $request->file($key);
                foreach ($files as $file) {
                    $links[] = env('AWS_URL') . $file->store('test/' . $folder, 's3');
                }
            }
        } else {
            if ($request->hasFile($key)) {
                $files = $request->file($key);
                foreach ($files as $file) {
                    $links[] = env('AWS_URL') . $file->store($folder, 's3');
                }
            }
        }

        return $links;
    }
}

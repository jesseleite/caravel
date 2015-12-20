<?php

namespace ThisVessel\Caravel\Traits;

use Storage;
use ThisVessel\Caravel\Resource;

trait UploadsFiles
{
    public function prepareInputData($request)
    {
        foreach ($request->all() as $name => $value) {
            if ($request->hasFile($name)) {
                $data[$name] = $value->getClientOriginalName();
            } else {
                $data[$name] = $value;
            }
        }

        return $data;
    }

    public function uploadFiles($request, $entity)
    {
        foreach ($request->all() as $name => $file) {
            if ($request->hasFile($name) && $request->file($name)->isValid()) {
                $request->file($name)->move($this->uploadPath($entity), $file->getClientOriginalName());

                // Direct download to another disk? ie. S3
                    // $disk = Storage::disk(config('caravel.upload.disk'));
                    // $here = $this->uploadPath($entity) . '/' . $file->getClientOriginalName();
                    // $disk->put($here, file_get_contents($file), 'public');
            }
        }
    }

    public function uploadPath($entity)
    {
        foreach (array_filter(explode('/', config('caravel.upload.path'))) as $part) {
            $path[] = $this->uploadPart($part, $entity);
        }

        return '/' . implode('/', $path);
    }

    public function uploadPart($part, $entity)
    {
        if (str_contains($part, ':')) {
            if ($part == ':table') {
                return $entity->getTable();
            } else {
                $attribute = str_replace(':', '', $part);
                return $entity->$attribute;
            }
        }

        return $part;
    }
}

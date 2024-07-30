<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
  protected $s3Client;
  protected $bucket;

  public function __construct()
  {
    $this->s3Client = new S3Client([
      'region'  => env('AWS_DEFAULT_REGION'),
      'version' => 'latest',
      'endpoint' => 'http://localhost:9000',
      'use_path_style_endpoint' => true,
      'credentials' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
      ],
    ]);

    $this->bucket = env('AWS_BUCKET');
  }

  /**
   * Create a new file in the S3 bucket.
   *
   * @param Request $request The request object containing the file and key.
   * @return \Illuminate\Http\JsonResponse The result of the S3 putObject operation.
   */
  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'key' => 'required|string',
      'file' => 'required|file',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $key = $request->input('key');
    $file = $request->file('file');

    $result = $this->s3Client->putObject([
      'Bucket' => $this->bucket,
      'Key'    => $key,
      'Body'   => fopen($file->getRealPath(), 'r'),
      'ACL'    => 'public-read',
    ]);

    $imageUrl = $this->s3Client->getObjectUrl($this->bucket, $key);

    return response()->json([
      'result' => $result,
      'url' => $imageUrl,
    ]);
  }

  /**
   * Read a file from the S3 bucket.
   *
   * @param string $key The key of the file to fetch.
   * @return \Illuminate\Http\Response The content of the file.
   */
  public function read($key)
  {
    $result = $this->s3Client->getObject([
      'Bucket' => $this->bucket,
      'Key'    => $key,
    ]);

    $fileContent = $result['Body']->getContents();

    return response($fileContent);
  }

  /**
   * Update an existing file in the S3 bucket.
   *
   * @param Request $request The request object containing the new content.
   * @param string $key The key of the file to update.
   * @return \Illuminate\Http\JsonResponse The result of the S3 putObject operation.
   */
  public function update(Request $request, $key)
  {
    $validator = Validator::make($request->all(), [
      'content' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $newContent = $request->input('content');

    $result = $this->s3Client->putObject([
      'Bucket' => $this->bucket,
      'Key'    => $key,
      'Body'   => $newContent,
    ]);

    return response()->json($result);
  }

  /**
   * Delete a file from the S3 bucket.
   *
   * @param string $key The key of the file to delete.
   * @return \Illuminate\Http\JsonResponse The result of the S3 deleteObject operation.
   */
  public function delete($key)
  {
    $result = $this->s3Client->deleteObject([
      'Bucket' => $this->bucket,
      'Key'    => $key,
    ]);

    return response()->json($result);
  }
}

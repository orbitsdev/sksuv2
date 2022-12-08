<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
class CloudStorageController extends Controller
{



public function getAccessToken()
   {
      AlibabaCloud::accessKeyClient( config('filesystems.disks.oss.access_key_id'), config('filesystems.disks.oss.access_key_secret'))
      ->regionId(config('filesystems.disks.oss.region'))
      ->asDefaultClient();

      try {
        $result = AlibabaCloud::rpc()
        ->product('Sts')
        ->host('sts.ap-southeast-6.aliyuncs.com')
        ->version('2015-04-01')
        ->action('AssumeRole')
        ->scheme('https')
        ->method('POST')
        ->options([
          'query' => [
            'RegionId' => config('filesystems.disks.oss.region'),
            'RoleArn' => config('filesystems.disks.oss.acs'),
            'RoleSessionName' => config('filesystems.disks.oss.user'),
            ],
          ])
        ->request();
        
        $data = collect($result);

        $format = [
          'region' => config('filesystems.disks.oss.region'),
          'stsToken' => $data['Credentials']['SecurityToken'],
          'bucket' => config('filesystems.disks.oss.bucket'),
          'accessKeyId' => $data['Credentials']['AccessKeyId'],
          'accessKeySecret' => $data['Credentials']['AccessKeySecret']
        ];
    
        return response()->json(['success' => true, 'data' => $format], 200);
      } catch (ClientException $exception)
      {
        \Log::emergency("client error " . $exception->getErrorMessage() );
        return response()->json(['success' => false, 'message' => 'Failed to get access token'], 200);

      }catch (ServerException $exception )
      {
        \Log::emergency(["server error " . $exception->getErrorMessage(), 
        $exception->getMessage(), $exception->getErrorCode(), $exception->getRequestId()] );
        return response()->json(['success' => false, 'message' => 'Something went wrong please try again'], 200);
      }
   }


}



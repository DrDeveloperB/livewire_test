<?php

namespace App\Http\Livewire;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Livewire\Component;

class TestBase extends Component
{
    public function render()
    {
//        $test = $request->file->getClientOriginalName();
//        $test = $request->file('upload_files')->store('images', 'public');
//        dump($test);



        echo "<br><br>";
        var_dump(  public_path() );
        echo "<br><br>";
        var_dump(  app_path() );
        echo "<br><br>";
        var_dump(  base_path() );
        echo "<br><br>";
        var_dump(  storage_path() );
        echo "<br><br>";
//             var_dump( $request->file('upload_files')->getFileInfo() );
        echo "<br><br>";
//             var_dump( $httpRrequest->file('upload_files')->getFilename() );
        echo "<br><br>";
//             var_dump( $httpRrequest->file('upload_files')->getPathname() );
        echo "<br><br>";
//             var_dump( $httpRrequest->file('upload_files')->extension() );
        echo "<br><br>";
//             var_dump( $httpRrequest->file('upload_files')->getBasename() );
        echo "<br><br>";
//             var_dump( $httpRrequest->file('upload_files')->getClientOriginalName() );
        echo "<br><br>";

//        Storage::disk('custom_01')->put('test.png' , $request->file('upload_files') ) ;

        return view('livewire.test-base');




//        $sAppID = 'simsale';
//        $file = storage_path() . '\app\public\toss.txt';
////        $toss_file = storage_path() . '\app\public\toss_back_orderid.txt';
////        echo "<xmp>";
////        var_dump(  file_exists($file) );
////        echo "</xmp>";
//
//        $data = array('datetime' => array(), 'tossData' => array());
//        $aQuery = array();
//        foreach(file($file) as $contents) {
//
//            $replace = preg_replace("/www\/application\/logs\/toss-webhook-(.*).php:/", "", $contents);
//
//            $array = explode(' --> param (http://treport.jasongroup.co.kr/api_toss) :', $replace);
//            array_push($data['datetime'], $array[0]);
//            $json = json_decode($array[1]);
////            $tossData = (array) json_decode($array[1]);
//            array_push($data['tossData'], $json);
//
//            foreach ($json as $key => $value) {
//                echo "<xmp>";
//                print_r($key);
//                echo "</xmp>";
//                $cHookKey = (array)json_decode($key);
//
//                if (!isset($cHookKey['eventType'])) {
////                    fnLog_V2('error', $this->sLogFileName, '토스페이 WEBHOOK 데이터에 eventType 이 없음', ['StartTime' => $this->sLogStart, 'cHookKey' => $cHookKey]);
//                } else {
//                    /**
//                     * eventType 이 존재하는 경우에만 디비 입력
//                     */
//                    $sQuery = <<<SQL
//insert into {$sAppID}_topy_evnt_hist set eventType = '{$cHookKey['eventType']}',
//    frst_reg_dtm = '{$array[0]}'
//SQL;
////                    $aData[$i]['eventType'] = $cHookKey['eventType'];
//
//                    $aColumn = array(
//                        'customerKey',              // 사용자 식별키
//                        'methodKey',              // 결제수단 고유키
//                        'paymentKey',              // 결제키
//                        'changedAt',              // 변동 시각
//                        'authorizationCode',              // 인증 코드
//                        'registeredAt',              // 가입 시각
//                        'status',              // 상태
//                    );
//
//                    foreach ($aColumn as $sColVal) {
//                        foreach ($cHookKey['data'] as $k => $v) {
//                            if ($sColVal == $k) {
//                                $sQuery .= <<<SQL
//, {$k} = '{$v}'
//SQL;
//                                break;
//                            }
////                        $aData[$i][$k] = $v;
//                        }
//                    }
//
//                    array_push($aQuery, $sQuery);
//                }
//            }
//        }
//
//        echo "<xmp>";
//        print_r($aQuery);
//        echo "</xmp>";


    }

    public function uploadFile1(Request $request)
    {
        $debug = array();
//        phpinfo();
//        die;
        $path = storage_path('app\public');
        $debug['path'] = $path;
//        $path = storage_path() . '\app\public';
//        dd($path);      // "E:\test\livewire1\storage\app\public"
//        var_dump(file_exists($path));
//        var_dump(file_exists("E:\\test\livewire1\storage\app\public"));

        $file = $request->file('upload_files');
        $debug['file'] = $file;
        $filename = sprintf('%s_%s.%s',
            pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME),
            date('Ymd_His'),
            $file->getClientOriginalExtension()
        );
//        $filename = $file->getClientOriginalName();     // "img_spec.png"
//        $filename = date('Ymd_His_') . $file->getClientOriginalName();
        $debug['filename'] = $filename;
//        dd($filename);
//        $move = $file->move($path, $filename);
//        $move = $request->file('upload_files')->store('/');
//        $move = $request->file('upload_files')->store('public');
//        $move = $request->file('upload_files')->storeAs('/', $filename);
//        $debug['move'] = $move;
//        dd($debug);

//        $path = storage_path('public/' . $file);
//        dd($file);
        $debug['storagePath'] = Storage::disk('custom_01');
        $storage = Storage::disk('custom_01')->putFileAs('/', $file, $filename);
//        $debug['storagePath'] = Storage::disk();
//        $storage = Storage::putFileAs('/', $file, $filename);
//        $storage = Storage::putFileAs("E:\\test\livewire1\storage\\temp\\", $filename);
        $debug['storage'] = $storage;
        dd($debug);
//        $storagePath = Storage::disk('custom_01')->get($file);
//        $debug['storagePath'] = $storagePath;
//        dd(Storage::disk('custom_01'));
//        var_dump(file_exists("E:\test\livewire1\storage\app\public"));

//        $storage = Storage::putFile($path, $filename);
//        $path = storage_path('app/test');
//        $storage = Storage::disk('public')->put(
//            '/',
//            $filename
//        );
//        $storage = Storage::disk('custom_01')->putFileAs(
//            $path,
//            $file,
//            $filename
//        );
//        dd($storage);

        // fail
//        $file->move($path, "aaa.png");





//        $banklist = $request->file('upload_files');
//        $path = storage_path() . '/app/public';
//        $filename = $banklist->getClientOriginalName();
//        $banklist->move($path, $filename);



//        $file = $request->file('upload_files');
//        $file->move($path.'\aaa.png');

//        dd($request->file('upload_files'));
//        echo "<xmp>";
//        var_dump(file_exists($path));
//        echo "</xmp>";
//        die;
//        $uploadedFile = $request->file('upload_files')->store($path);
//        $uploadedFile = Storage::putFile($path, $request->file('upload_files'));
//        $path = $request->file('avatar')->store('avatars');
//        dd($uploadedFile);
//        return $path;

//        Excel::import(new BankImport, storage_path() . '/app/123.xlsx');

//        Storage::fake('avatars');
//
//        $file = UploadedFile::fake()->image('avatar.jpg');

//        $response = $this->json('POST', '/avatar', [
//            'avatar' => $file,
//        ]);
//
//        // Assert the file was stored...
//        Storage::disk('avatars')->assertExists($file->hashName());
//
//        // Assert a file does not exist...
//        Storage::disk('avatars')->assertMissing('missing.jpg');


//             var_dump( $request->file('upload_files')->getFileInfo() );
//             dd(Storage::disk('custom_01'));
//        Storage::disk('custom_01')->put('test.png' , $request->file('upload_files') ) ;
//        $request->upload_file->store('custom_01');

//        $test = $request->file('upload_files')->store('images', 'public');

//        $uploadedFile = $request->file('upload_files');
//        $filename = time().$uploadedFile->getClientOriginalName();
//        Storage::disk('custom_01')->putFileAs(
//            $filename,
////            'files/'.$filename,
//            $uploadedFile,
//            $filename
//        );
//        $upload = new Upload;
//        $upload->filename = $filename;
//        $upload->save();

//        return '파일 업로드 완료';
    }

    public function uploadFile2(Request $request)
    {
        $debug = array();
//        phpinfo();
//        die;
        $path = storage_path('app\public');
        $debug['path'] = $path;
//        $path = storage_path() . '\app\public';
//        dd($path);      // "E:\test\livewire1\storage\app\public"
//        var_dump(file_exists($path));
//        var_dump(file_exists("E:\\test\livewire1\storage\app\public"));

        $file = $request->file('upload_files2');
        $debug['file'] = $file;
        $filename = date('Ymd_His_').$file->getClientOriginalName();
        $debug['filename'] = $filename;
//        $filename = $file->getClientOriginalName();     // "img_spec.png"
//        dd($filename);
        $move = $file->move($path, $filename);
        $debug['move'] = $move;
        dd($debug);

//        $path = storage_path('public/' . $file);
//        dd($file);
//        $debug['storagePath'] = Storage::disk();
//        $storage = Storage::putFile("E:\\test\livewire1\storage\\temp\\", $filename);
//        $debug['storage'] = $storage;
//        dd($debug);
    }
}

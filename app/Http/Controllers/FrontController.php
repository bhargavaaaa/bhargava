<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use DataTables;
use FeedReader;
use Client;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    public function index()
    {
    	return view('dashboard');
    }

    public function getData()
    {
    	$employees = Employee::get();
    	return DataTables::of($employees)
    			->addIndexColumn()
                ->addColumn('salary', function($row){
                    $btn = '';
                    $btn .= '₹ '.number_format($row->salary,2);
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-danger" onclick="delete_rec('.$row->id.')">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function deleteData(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->delete();

        return true;
    }

    public function notification()
    {
        return view('notification');
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $SERVER_API_KEY = 'AAAAd3NE1mk:APA91bEzabN5TNvLJkSaX6ZHrVhRlSLL5P4SXWewhXQ7VcSk663wjIMgr5iRGUoWhgPNsieJr5P84AnrJit72_zOtVDdv3xLr5DMTlUWKkhHpbft6ykcR4tJLZmSq6y3mwhzWOyhon8c';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        return redirect(route('notification'));
    }

    public function feeds()
    {
        $f = FeedReader::read('https://news.google.com/rss');
        return view('feeds',compact('f'));
    }

    public function imap()
    {
        $subjects = [];
        $attachments = [];
        $mids = [];
        $oClient = Client::account('gmail');
        $oClient->connect();
        $aFolder = $oClient->getFolders('INBOX');

        foreach($aFolder as $oFolder) {
            if($oFolder->name == 'INBOX') {
                $aMessage = $oFolder->messages()->all()->get();
                foreach ($aMessage as $oMessage) {
                    $subjects[] = $oMessage->getSubject();
                    $count = $oMessage->getAttachments()->count();
                    $attachments[] = $count;
                    $mids[] = $oMessage->getMessageId();
                    if($count > 0) {
                        $oMessage->getAttachments()->each(function ($oAttachment) use($oMessage) {
                            if (!Storage::exists("public\\attachments\\{$oMessage->getMessageId()}\\{$oAttachment->name}")) {
                                Storage::disk('local')->put("public\\attachments\\{$oMessage->getMessageId()}\\{$oAttachment->name}", $oAttachment->content);
                            }
                        });
                    }
                }
                break;
            }
        }
        return view('imap', compact('subjects','attachments','mids'));
    }

    public function pert_mail(Request $request)
    {
        $id = $request->id;
        $oClient = Client::account('gmail');
        $oClient->connect();
        $aFolder = $oClient->getFolders('INBOX');

        foreach($aFolder as $oFolder) {
            if($oFolder->name == 'INBOX') {
                $aMessage = $oFolder->query()->whereMessageId($id)->get();
                $html = '<br/><hr>';
                foreach ($aMessage as $oMessage) {
                    if ($oMessage->hasHTMLBody()) {
                        $html .= $oMessage->getHTMLBody();
                    } elseif ($oMessage->hasTextBody()) {
                        $html .= $oMessage->getTextBody();
                    }
                    $count = $oMessage->getAttachments()->count();
                    if($count > 0) {
                        $files = Storage::disk('local')->allFiles("public\\attachments\\{$oMessage->getMessageId()}");
                        foreach($files as $file) {
                            $file_str = substr($file, 7);
                            $html .= '<br/><a style="width:100%" class="btn btn-primary" download href="'.url($file_str).'"><i class="fa fa-download"></i> Download Attachments</a>';
                        }
                    }
                }
                break;
            }
        }
        return response()->json($html);
    }
}

<?php

namespace App\Http\Controllers;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;

use Illuminate\Http\Request;
use Session;
use Mail;

class EmailFetchController extends Controller
{
    //
    public function connectPage(){
        return View('connect');
    }
    public function connect(Request $request){
        
        $cm = new ClientManager();
        $client = $cm->make([
            'host'          => 'mail.equatorial-property.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap',
            'username'      => $request->email,
            'password'      => $request->password
         ]);
         $client->connect();
        
         return redirect()->route('indexPage',['client'=>$client]);
    }

    public function index(Request $request){
        set_time_limit(0);
        $cm = new ClientManager();
        $client = $cm->make([
            'host'          => 'mail.equatorial-property.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap',
            'username'      => $request->email,
            'password'      => $request->password
         ]);

        $client->connect();
        Session::put('email', $request->email);
        Session::put('password', $request->password);
        // $folders = $client->getFolders();
        // dd($client);
        $folder = $client->getFolders();
        $overview = $folder[0]->overview($sequence = "3:*");
        // dd($overview);
        $query = $folder[0]->messages();
        $message = $query->getMessage($id = 3);
        $message_msgn = $query->getMessageByMsgn($msgn = 8);
        $message_all = $query->all()->get();
        $flags = $message->getFlags();
        $from = $message->getFrom();

        dd($flags);
        // $test = $message->references[0];
        // dd($test);
        // Mail::raw('Testing reply to e-mail', function ($message) use ($request) {
        //     $r = "<58f21f94fc655575a0f1d5ff753700e9@127.0.0.1>" . '<' . '8' . '>';
        //     $message->getHeaders()->addTextHeader('In-Reply-To', '8');
        //     $message->getHeaders()->addTextHeader('References', $r);
        //     $message->from("info@equatorial-property.com", "Equatorial Property");
        //     $message->sender($message->getFrom());
        //     $message->to("dummy.gusade@gmail.com");
        //     $message->replyTo($message->getFrom());
        //     $message->subject("Testing dari hosting");
        //     $message->setBody("Ini reply dari hosting");
        // });

        //Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        // foreach($folders as $folder){
           

        //     //Get all Messages of the current Mailbox $folder
        //     /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        //     // $messages = $folder->messages()->all()->to("4")->get();

        //     // // dd($messages);

                
        //     // /** @var \Webklex\PHPIMAP\Message $message */
        //     // foreach($messages as $message){
        //     //     echo $message->getSubject().'<br />';
        //     //     echo 'Attachments: '.$message->getAttachments()->count().'<br />';
        //     //     echo $message->getHTMLBody();

        //     //     //Move the current Message to 'INBOX.read'
        //     //     if($message->move('INBOX.read') == true){
        //     //         echo 'Message has ben moved';
        //     //     }else{
        //     //         echo 'Message could not be moved';
        //     //     }
        //     // }
        // }
        // $folders = $client->getFolderByName('INBOX');
        // $messages = $folders->messages()->all()->get();
        // return View('emails')->with(['messages'=>$messages]);       
    }

        public function custom_search(Request $request){
            set_time_limit(0);
        
            $cm = new ClientManager();
            $client = $cm->make([
                'host'          => 'mail.equatorial-property.com',
                'port'          => 993,
                'encryption'    => 'ssl',
                'validate_cert' => true,
                'protocol'      => 'imap',
                'username'      => Session::get('email'),
                'password'      => Session::get('password')
             ]);
    
            $client->connect();
            $folders = $client->getFolderByName('INBOX');
            $messages = $folders->messages()->to($request->search)->all()->get();
            return View('emails')->with(['messages'=>$messages]);   

        }
    
}

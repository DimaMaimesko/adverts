<?php
namespace App\Http\Controllers\Cabinet\Messages;

use App\Http\Controllers\Controller;
use App\Mail\MessageNotifier;
use App\Models\Adverts\Advert;
use App\Models\Adverts\Advert\Dialog\Dialog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Events\MessageSended;

class MessagesController extends Controller
{

    public function index()
    {
        $dialogs = Dialog::myDialogs()->paginate(10);
        $counter = Dialog::countNewMessages($dialogs);
        return view('cabinet.messages.index', [
            'dialogs' => $dialogs,
            'counter' => $counter,
        ]);
    }

    public function send($advert, Request $request)
    {
        $advert = Advert::find($advert);
        $advert->writeClientMessage( Auth::id(),  $request->input('message'));

        Mail::to($advert->user->email)
            ->send(new MessageNotifier(Auth::id(),$request->input('message')));

        return back();
    }

    public function show($dialog)
    {
       $dialog = Dialog::find($dialog);
       if ($dialog->owner_id == Auth::id()) $dialog->readByOwner();
       if ($dialog->client_id == Auth::id()) $dialog->readByClient();
       return view('cabinet.messages.show', compact('dialog'));
    }

    public function reply($dialog, Request $request)
    {
        $dialog = Dialog::find($dialog);
        if ($dialog->owner_id == Auth::id()) $dialog->writeMessageByOwner($request->input('message'));
        if ($dialog->client_id == Auth::id()) $dialog->writeMessageByClient($request->input('message'));
        return back();
    }



    public function removeMessage()
    {

    }

    public function removeDialog()
    {

    }
}

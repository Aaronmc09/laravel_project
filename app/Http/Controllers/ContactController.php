<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use App\Models\delete_journal;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function saveContact(Request $request){

        $new_contact = new Contacts();
        $new_contact->first_name = $request->first_name;
        $new_contact->last_name = $request->last_name;
        $new_contact->contact_number= $request->contact_number;
        $new_contact->email = $request->email;
        $new_contact->address = $request->address;
        $new_contact->note = $request->note;

        if($request->image) {
            
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $new_contact->image_path = "images/" . $imageName;
            
        }

        $new_contact->save();

        return redirect('/');
    }

    public function updateContact(Request $request){

        $contact_id = $request->id;
        $contact = DB::table('contacts')->where('id', $contact_id)->limit(1);

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if($request->image) {
            
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $contact->update([
                'image_path' => "images/" . $imageName
            ]);
            
        }

        return redirect('/');
    }

    public function getContactData(Request $request){

        $contact_id = $request->id;

        $contact_info = DB::table('contacts')->where('id', $contact_id)->first();

        return \Response::json(array(
                        'success' => true,
                        'data'   => $contact_info
                    )); 
    }

    public function deleteContact(Request $request){

        $contact_id = $request->id;

        $contact_info = DB::table('contacts')->where('id', $contact_id)->first();

        if($contact_info){

            $journal = new delete_journal();

            $journal->id = $contact_id;
            $journal->first_name = $contact_info->first_name;
            $journal->last_name = $contact_info->last_name;
            $journal->contact_number= $contact_info->contact_number;
            $journal->email = $contact_info->email;
            $journal->address = $contact_info->address;
            $journal->note = $contact_info->note;
            $journal->image_path = $contact_info->image_path;

            $journal->save();

            DB::delete('delete from contacts where id = ?',[$contact_id]);

            return \Response::json(array(
                'success' => true
            )); 
            
        }

        else {

            return \Response::json(array(
                'success' => false
            )); 

        }
        
    }
}

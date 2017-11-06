<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Bandmember;
use App\Preference;
use App\UserHistory;
use App\Playlist;
use App\Plist;

class UserController extends Controller
{
    
	public function updateUser(Request $request)
        {
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["address" => "input['users-city']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["contact" => "input['users-contact']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["email" => "input['users-email"]);

            $updateUserInfo = User::where('user_id', session('userSocial')['id'])
                    ->update([
                        "address" => $request->userscity,
                        "contact" => $request->userscontact,
                        "email" => $request->usersemail,
                        "bio" => $request->usersbio
                        ]);

            $usersCity = User::select('address')->where('user_id', session('userSocial')['id'])->first();
            $usersContact = User::select('contact')->where('user_id', session('userSocial')['id'])->first();
            $usersEmail = User::select('email')->where('user_id', session('userSocial')['id'])->first();
            $usersBio = User::select('bio')->where('user_id', session('userSocial')['id'])->first();
            // dd($usersCity->address);
            session(['userSocial_City' => $usersCity->address]);
            session(['userSocial["email"]' => $usersEmail->email]);
            session(['userSocial_Contact' => $usersContact->contact]);
            session(['userSocial_Bio' => $usersBio->bio]);

            // return redirect('/user/profile');
			return response ()->json($updateUserInfo);

        }

    public function show(){
           // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
           //  return view('user-profile', compact('userRole'));
        $user = User::where('user_id',session('userSocial')['id'])->first();

        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
        $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
        $userBandRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->get();
        // dd($userBandRole);
            // return view('user-profile', compact('userHasBand','userBandRole'));
		return response ()->json($userHasBand,$userBandRole,$usersBand,$user);

    }

    public function saveUser(Request $request)
    {
        $user = $request->input('user_id');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $fullname = $fname." ".$lname;
        $email = $request->input('email');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $address = $request->input('address');
        $contact = $request->input('contact');
        $bio = $request->input('bio');
        $pic = $request->input('pic');

        $create = User::create([
            'user_id' => $user,
            'fname' => $fname,
            'lname' => $lname,
            'fullname' => $fullname,
            'email' => $email,
            'age' => $age,
            'gender' => $gender,
            'address' => $address,
            'contact' => $contact,
            'bio' => $bio,
            'profile_pic' => $pic,
        ]);

        return response()->json($create);
    }
    public function getusers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function preferences(Request $request)
    {
        $preferences = Preference::where('user_id', $request->input('user_id'))->get();

        if (count($preferences) > 0)
        {
           return response() ->json($preferences);            
        }
        else
        {
            return response() ->json(['message' => 'No preferences found in the table.']);   
        }
    }

    public function userhistory(Request $request)
    {
        $userhistory = UserHistory::where('user_id', $request->input('user_id'))->get();

        if (count($userhistory) > 0)
        {
           return response() ->json($userhistory);            
        }
        else
        {
            return response() ->json(['message' => 'No userhistory found in the table.']);   
        }
    }

    public function AddPlayList(Request $request){

      $uid = $request->input('user_id');
      $title = $request->input('pl_title');
      $desc = $request->input('pl_desc');
      $image = $request->file('pl_image');

      \Cloudder::upload($image);
      $cloudder=\Cloudder::getResult();

      $create = Playlist::create([
            'pl_title' => $title,
            'pl_desc' => $desc,
            'pl_creator' => $uid,
            'image' => $cloudder['url'],
          ]);

      return response() ->json($create);;
    }

    public function DeletePlayList(Request $request){

        $id = $request->input('pl_id');

        $delete = Playlist::where('pl_id', $id)->delete();
    }

    public function updateplaylist(Request $request)
    {
        $id = Playlist::where('pl_id', $request->input('pl_id'))->first();
        $title = $request->input('pl_title');
        $desc = $request->input('pl_desc');
        $image = $request->file('pl_image');

        if($image != null){
          \Cloudder::upload($image);
          $cloudder=\Cloudder::getResult();

        
          $update = Playlist::where('pl_id', $id->pl_id)->update([
            'pl_title' => $title,
            'pl_desc' => $desc,
            'image' => $cloudder['url'],
          ]);
        }
        else{
            $update = Playlist::where('pl_id', $id->pl_id)->update([
            'pl_title' => $title,
            'pl_desc' => $desc,
          ]);
        }
    }

    public function getAllPlaylist(Request $request){
        $playlists = Playlist::all();

        return response() ->json($playlists);
    }

    public function addSongToPlaylist(Request $request){
        
        $genre = $request->input('genre_id');
        $song = $request->input('song_id');
        $playlistId = $request->input('pl_id');

        $create = Plist::create([
        'genre_id' => $genre,
        'song_id' => $song,
        'pl_id' => $playlistId,
      ]);
    }
}

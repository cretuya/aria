<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Album_Contents;
use App\Article;
use App\Band;
use App\BandArticle;
use App\Bandmember;
use App\BandVideo;
use App\Genre;
use App\Song;
use App\User;
use \Session;
use Laravel\Socialite\Facades\Socialite;

class BandController extends Controller
{
	public function index($name)
	{

		$band = Band::where('band_name' ,$name)->first();
		$videos = BandVideo::where('band_id', $band->band_id)->get();
		$albums = Album::where('band_id', $band->band_id)->get();
		$articles = BandArticle::where('band_id' , $band->band_id)->get();
		$genres = Genre::all();
		$contents = Album_Contents::all();

		return view('dashboard-band' , compact('band','videos', 'albums', 'articles', 'genres', 'contents'));
	}
	public function createBand(Request $request)
	{
		$name = $request->input('band_name');
		$role = $request->input('band_role_create');


		$create = Band::create([
			'band_name' => $name,
		]);


		$bandmember = Bandmember::create([
			'band_id' => $create->id,
			'user_id' => session('userSocial')['id'],
			'bandrole' => $role
			// 'band_desc' => $desc,
		]);

		return redirect('/'.$create->band_name);
	}

	public function followBand($bname)
	{
		$band = Band::where('band_name', $bname)->first();

	}

}

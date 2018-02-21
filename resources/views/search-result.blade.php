@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<style>
	.panel{
		margin-bottom: 0px !important;
	}
	.panel-body{
		padding-bottom: 0px !important;
	}

	.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover, .nav>li>a:focus, .nav>li>a:hover{
		background: none !important;
		border-top: none !important;
		border-left: none !important;
		border-right: none !important;
		border-bottom: 2px solid #E57C1F;
		border-radius: 0px;
		color: #fafafa;
	}
	input[type='range']{
	  -webkit-appearance: none !important;
	  background: #212121;
	  cursor: pointer;
	  height: 5px;
	  outline: none !important;
	}

	input[type='range']::-webkit-slider-thumb{
	  -webkit-appearance: none !important;
	  background: #E57C1F;
	  height: 12px;
	  width: 12px;
	  border-radius: 2px;
	  cursor: pointer;
	}
</style>

@include('layouts.sidebar')
@section('content')
<br><br>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
    <div class="row">
        <div class="col-md-12">

			<ul class="nav nav-pills">
			  <li class="active"><a data-toggle="tab" href="#people">People</a></li>
			  <li><a data-toggle="tab" href="#band">Band</a></li>
			  <li><a data-toggle="tab" href="#playlist">Playlist</a></li>
			  <li><a data-toggle="tab" href="#song">Song</a></li>
			  <li><a data-toggle="tab" href="#album">Album</a></li>
			  <li><a data-toggle="tab" href="#video">Video</a></li>
			</ul>

			<div class="tab-content">

			  <div id="people" class="tab-pane fade in active">
				  @if(count($searchResultUser) > 0)
			        <br>
			        <?php for ($x=0; $x < count($searchResultUser) ; $x++) { ?>
			        <div class="panel" style="background: transparent;">
			        	<div class="panel-body">
				          <div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
				            <div class="media-left">
				              <a href="{{url('/profile/'.$searchResultUser[$x]->user_id)}}">
				              <div class="panel-thumbnail">
				              	<img src="{{$searchResultUser[$x]->profile_pic}}" class="media-object" style="width: 100%; min-width: 100px; height:100px;">
				              </div>
				              </a>
				            </div>
				            <div class="media-body" style="padding-top: 16px; background: #232323; padding-left: 12px;">
				              <a href="{{url('/profile/'.$searchResultUser[$x]->user_id)}}"><h5 class="media-heading">{{ $searchResultUser[$x]->fname }} {{ $searchResultUser[$x]->lname}}</h5></a>
				              <p style="font-size: 12px; margin-top: 10px;">{{$searchResultUser[$x]->address}}</p>
				              <p style="font-size: 12px; margin-top: -10px;">{{$searchResultUser[$x]->email}}</p>
				            </div>
				          </div>
			          	</div>
			          </div>
			         <?php } ?>
			      @else
			      	<br>
			      	<p>No person named '{{$termSearched}}' found.</p>
			      @endif

			      <br><br>
			  </div>

			  <div id="band" class="tab-pane fade">
				  @if(count($searchResultBand) > 0)
			        <br>
			        <?php 
			        $i = 0;
			        $j = $i;
			        for ($i=0; $i < count($searchResultBand); $i++) {
			        ?>
			          <div class="panel" style="background: transparent;">
			          	<div class="panel-body">
				          <div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
				            <div class="media-left">
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}">
				              <div class="panel-thumbnail">
				              <img src="{{$searchResultBand[$i]->band_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
				              </div>
				              </a>
				            </div>
				            <div class="media-body" style="padding-top: 15px; background: #232323; padding-left: 10px;">
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><h5 class="media-heading">{{$searchResultBand[$i]->band_name}}</h5></a>
				              @if(count($bandGenre) == 0)
					              @if($searchResultBand[$i]->num_followers == null)
						          <p style="font-size: 12px;">0 Followers</p>
						          @else
						          <p style="font-size: 12px;">{{$searchResultBand[$i]->num_followers}} Followers</p>
						          @endif
					          @else			          
						          <p style="font-size: 12px;">{{ $bandGenre[$j]->genre_name }} | {{ $bandGenre[$j+1]->genre_name }}</p>
						          @if($searchResultBand[$i]->num_followers == null)
						          <p style="font-size: 12px;">0 Followers</p>
						          @else
						          <p style="font-size: 12px;">{{$searchResultBand[$i]->num_followers}} Followers</p>
						          @endif
				              @endif
				            </div>
				          </div>
				        </div>
				       </div>
				    <?php $j+=2;} ?>
			      @else
			      	<br>
			      	<p>No bands named '{{$termSearched}}' found.</p>
			      @endif
			      <br><br>
			  </div>


			  <div id="playlist" class="tab-pane fade">
		    	  @if(count($searchResultPlaylist) > 0)
		            <br>
		            @foreach($searchResultPlaylist as $srPlay)
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
		              		  <div class="media-left">
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}">
		              		    <div class="panel-thumbnail">
		              		    <img src="{{$srPlay->image}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
		              		    </div>
		              		    </a>
		              		  </div>
		              		  <div class="media-body" style="padding-top: 20px; background: #232323; padding-left: 10px;">
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}"><h4 class="media-heading">{{$srPlay->pl_title}}</h4></a>
		              		    <p>by: {{$srPlay->fullname}}</p>
		              		  </div>
		              		</div>
		              		
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No songs titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  

			  <div id="song" class="tab-pane fade">
		    	  @if(count($searchResultSong) > 0)
		            <br>
		            @foreach($searchResultSong as $srSong)
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<div class="media" style="width: 70%;">
		              			<div class="media-left">
		              				<div class="panel-thumbnail">
		              				  <img src="{{$srSong->album->album_pic}}" class="media-object" style="width: 80px; height: 80px;">
		              				</div>
		              				<a href="#" onclick="playOrPause($(this),{{$srSong->song_id}});" style="position: relative;">
		              				  <img src="{{asset('assets/img/playfiller.png')}}" class="media-object" style="width: 45px; position: absolute; top: -62px; left: 18px; opacity: 0.75;" draggable="false">
		              				  <img id="playBtn" src="{{asset('assets/img/play.png')}}" class="media-object" draggable="false" style="width: 45px; position: absolute; top: -62px; left: 18px;">
		              				</a>
		              				<audio src="{{url('/assets/music/'.$srSong->song_audio)}}" data-id="{{$srSong->song_id}}" type="audio/mpeg" controls hidden></audio>
		              			</div>
		              			<div class="media-body" style="background: #fafafa; padding: 15px;">
		              				<h5 style="margin-top: 5px; color: #212121;">
		              					{{$srSong->album->band->band_name}} - {{$srSong->song_title}}
		              					<button class="btn pull-right" style="padding: 3px 7px; margin-top: -5px; background: #232323; color: #fafafa;">
		              						<span style="font-size: 12px;">Add to playlist</span>
		              					</button>
		              					<!-- <div class="pull-right" style="margin-right: 20px;"><span id="fullDuration" style="color: #212121; vertical-align: text-top;">0:00</span>
		              					</div> -->
		              				</h5>
		              				<input id="musicslider{{$srSong->song_id}}" type="range" style="margin-top: 20px;" min="0" max="100" value="0" step="1">		              				
		              			</div>
		              		</div>		              		
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No songs titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  <div id="album" class="tab-pane fade">
			    @if(count($searchResultAlbum) > 0)
		            <br>
		            @foreach($searchResultAlbum as $srAlbum)

		            <?php
		            	$date = DateTime::createFromFormat("Y-m-d", $srAlbum->released_date);
		            	$srAlbum->released_date = $date->format("M Y");
		            ?>

		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              	<div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
		              		<div class="media-left">
		              		<a href="#">
		              			<div class="panel-thumbnail">
		              				<img src="{{$srAlbum->album_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
		              			</div>
		              		</a>
		              		</div>
		              		<div class="media-body" style="padding-top: 5px; background: #232323; padding-left: 10px;">
		              		<a href="#"><h5>{{$srAlbum->album_name}}</h5></a>
		              		<p style="font-size: 12px; margin-top: -5px; margin-bottom: 20px;">{{$srAlbum->num_likes}} people liked this album</p>
		              		<span style="font-size: 12px;">Date Release: {{$srAlbum->released_date}}</span>
		              		</div>
		              	</div>
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No albums titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  <div id="video" class="tab-pane fade">
			    @if(count($searchResultVideo) > 0)
		            <br>
		            @foreach($searchResultVideo as $srVideo)
			           <div class="panel" style="background: transparent;">
			           	<div class="panel-body">
			 	          <div class="media">
			 	            <div class="media-left">
			 	              <video class="media-object" style="width:150px" controls>
			 	              	<source src="{{asset('assets/video/'.$srVideo->video_content)}}" type="video/mp4">
			 	              </video>
			 	            </div>
			 	            <div class="media-body">
			 	              <h4 class="media-heading">Video Title</h4>
			 	              <p>{{$srVideo->video_desc}}</p>
			 	            </div>
			 	          </div>
			 	        </div>
			 	       </div>
		              		
		            @endforeach
		          @else
		          	<br>
		          	<p>No videos titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	var usersDurationPlayed = 0;
	var globalInt;
	var othersongId;
	var currentlyPlayingId;
	var prevPlayingId;
	var counter=0;
	var prevSong;

	function playOrPause(element, id){

		// console.log(element.next().data('id'));
		// console.log(currentlyPlayingId);
		var audioElement = element.next();

		var seekslider = document.getElementById('musicslider'+id);
		// var audio = audioElement;

		prevSong = parseInt($(audioElement).get(0).duration);

		$(audioElement).get(0).addEventListener("ended", function(){
		  setTimeout(function(){

		    element.find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
		    element.find(':nth-child(2)').css('width','45px');
		    element.find(':nth-child(2)').css('left','18px');
		    element.find(':nth-child(2)').css('top','-62px');

		    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		    console.log(CSRF_TOKEN, usersDurationPlayed, id, prevSong);
		    $.ajax({
		      method : "post",
		      url : 'addSongPlayedForScore',
		      data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : id, 'prevSong' : prevSong
		      },
		      success: function(json){
		        console.log(json);
		      },
		      error: function(a,b,c)
		      {
		        console.log(b);
		      }
		    });

		    clearInterval(globalInt);
		    usersDurationPlayed = 0;
		    timerDurationPlayed();

			});
		  var prevElement = $('audio[data-id="'+prevPlayingId+'"]');
		  prevElement.get(0).currentTime=0;
		});

		// console.log($(audioElement).get(0));

		if (!$(audioElement).get(0).paused && !$(audioElement).get(0).ended) {
			element.find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
			element.find(':nth-child(2)').css('width','45px');
			element.find(':nth-child(2)').css('left','18px');
			element.find(':nth-child(2)').css('top','-62px');
			$(audioElement).get(0).pause();			
			// window.clearInterval(updateTime);
		}
		else{			
			element.find(':nth-child(2)').attr("src","{{url('/assets/img/equa2.gif')}}");
			element.find(':nth-child(2)').css('width','20px');
			element.find(':nth-child(2)').css('left','30px');
			element.find(':nth-child(2)').css('top','-55px');
			$(audioElement).get(0).play();

			counter++;

			if (counter == 1) {
				prevPlayingId = id;
			}else{				
				if (id != prevPlayingId) {
					var prevElement = $('audio[data-id="'+prevPlayingId+'"]');
					// console.log(prevElement);
					prevElement.prev().find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
					prevElement.prev().find(':nth-child(2)').css('width','45px');
					prevElement.prev().find(':nth-child(2)').css('left','18px');
					prevElement.prev().find(':nth-child(2)').css('top','-62px');
					prevElement.get(0).pause();
					prevElement.get(0).currentTime=0;

					if(usersDurationPlayed == 0){
					  timerDurationPlayed();
					}else{
					  //push then usersDurationPlayed = 0;
					  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
					    console.log(CSRF_TOKEN, usersDurationPlayed, prevPlayingId, prevSong);
					  $.ajax({
					    method : "post",
					    url : 'addSongPlayedForScore',
					    data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : prevPlayingId, 'prevSong' : prevSong
					    },
					    success: function(json){
					      console.log(json);
					    },
					    error: function(a,b,c)
					    {
					      console.log(b);
					    }
					  });
					  usersDurationPlayed = 0;
					  timerDurationPlayed();
					}

					prevPlayingId = id;
				}
			}

			// othersongId = audioElement.data('id');
			// console.log(othersongId, "other song id");
			// updateTime = setInterval(update(element), 0);
		}
		
		// console.log(element.next());
		// console.log(audioElement.get(0).duration);

		seekslider.addEventListener("change", function(){
		    var seekTo = audioElement.get(0).duration * (seekslider.value/100);
		    audioElement.get(0).currentTime = seekTo;
		});

		audioElement.get(0).addEventListener("timeupdate", function(){
		    var newtime = audioElement.get(0).currentTime/audioElement.get(0).duration*100;
		    seekslider.value = newtime;
		});
	}

	function timerDurationPlayed(flag = true){

	  globalInt = setInterval(function(){
	    usersDurationPlayed++;
	    // console.log(usersDurationPlayed);
	  }, 1000);
	}

</script>

@endsection
@extends('layouts.master')

@section('content')

<style type="text/css">
  #albumPicTop{
    position: absolute;
    top: 25px;
    width: calc(100% - 240px);
  }
  #albumPicTop img{
    border: 2px solid #fafafa;
  }

  #albumBanner, #albumBannerFilter{
    height: 300px;
  }

  #albumPicTop img{
    height: 255px;
  }

  
</style>

@include('layouts.sidebar')

<br><br>
<div class="container" id="main" style="background: #161616;">

  <div class="row">
      <div id="albumBanner" class="panel-thumbnail" style="background: url({{$albums->album_pic}}) no-repeat center center;">
        &nbsp;
      </div>
      <div id="albumBannerFilter" class="panel-thumbnail">
        &nbsp;
      </div>
      <div id="albumPicTop" class="panel-thumbnail" style="background: transparent;">
          <div class="media" style="border: none; padding-left: 80px;">
            <div class="media-left">
              <img src="{{$albums->album_pic}}" class="media-object">
            </div>
            <div class="media-body" style="background: transparent; padding-left: 30px; padding-top: 15px;">
              <p style="color: #E57C1F; font-size: 12px;">ALBUM</p>
              <h2 style="letter-spacing: 1px;">{{$albums->album_name}}</h2>  
              <h4>{{$band->band_name}}</h4>
              <h6 style="margin-top: 20px;">Released on 10 Mar 2018</h6>
              <p style="margin-top: 20px; font-size: 12px; text-align: justify; word-wrap: break-word; width: 75%">{{$albums->album_desc}}</p>
            </div>
          </div>
      </div>

  </div>
  <br>
  <div class="row">
    <div class="col-md-1">&nbsp;</div>
    <div class="col-md-8">
      <div class="panel" style="border-radius: 0px; background: transparent;">
        <div class="panel-body" style="padding: 0;">
          <div class="media" style="border: 0; border-radius: 0px;">
            <div class="media-left">
              <img src="{{$albums->album_pic}}" class="media-object" style="width: 110px;">
            </div>
            <div class="media-body" style="padding-left: 10px; padding-top: 10px;">
              <h4 class="media-heading" style="color: #212121">Song Name</h4>
              <p style="color: #212121; font-size: 12px">Band / Artist</p>
              <br>
              <input type="range">
            </div>
            <div class="panel">
              <div class="panel-body">
                <table class="table">
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      
    </div>
  </div>

</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.albums').on('click', '.showSongs', function()
	{
		var id = $(this).data('id');
		getSongs(id);
	});
	function getSongs(id)
	{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../"+bname+"/viewSongs",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            $('.songs h4').text(json.album.album_name);
            $('.list').empty();
              $.each(json.songs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

               $('.list').append('<label>'+value.song_title+'</label><br><audio onplay="playSong('+value.song_id+')" class="audio" controls><source src="'+audio+'" type="audio/mpeg"></audio><br><br>'); 

              });
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });			
	}

  $('button.likeButton').on('click', function(e)
  {
      e.preventDefault();
      $button = $(this);
      if($button.hasClass('liked')){
          
          // $.ajax(); Do Unlike
          var id = $(this).data('id');
          alert('unlike');
          unlikeAlbum(id); 
          
      } else {
          
          // $.ajax(); Do Like
          var id = $(this).data('id');
          alert('like');
          likeAlbum(id);   
      }
  });

  function likeAlbum(id)
  {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../likeAlbum",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $button.addClass('liked');
            $button.text('Unlike');
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });         
  }
  function unlikeAlbum(id)
  {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../unlikeAlbum",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $button.removeClass('liked');
            $button.text('Like');
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });         
  }
});

function playSong(id)
{
  songid = id;
  var audio = document.getElementsByClassName('audio');
  setTimeout(function() { addSongPlayed(songid)}, 5000);
}
function addSongPlayed(id)
{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../addSongPlayed",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });   
}
</script>
@endsection
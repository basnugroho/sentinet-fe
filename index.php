<?php
header("Access-Control-Allow-Origin: *"); ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,800" rel="stylesheet" />
    <link href="css/main.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  </head>
  <body>
    <div class="s006">
      <form id="myform" method="POST">
        <fieldset>
          <legend id="kalimat">Sampaikan walau hanya satu kalimat 📣</legend>
          <div class="inner-form">
            <div class="input-field">
              <button class="btn-search" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </button>
              <input id="search" type="text" name="tweet" placeholder="masukkan kalimat..." value="" />
            </div>
          </div>
          <div class="suggestion-wrap">
            <span id="kata"></span>
            <span id="sent-positive">Sentiment: 😁</span>
            <span id="sent-netral">Sentiment: 😐</span>
            <span id="sent-negative">Sentiment: 😡</span>
          </div>
        </fieldset>
      </form>
    </div>
    <script language="JavaScript" type="text/javascript">
      $('#kata').hide();     
      sentiment = 2
      //jQuery detect user pressing enter
      $(document).on('keypress',function(e) {
        if(e.which == 13) {
            event.preventDefault()
            var tweet = $("#search").val()
            $.ajax({
                url : "https://api.sentinet.xyz/process", // Url of backend (can be python, php, etc..)
                type: "post", // data type (can be get, post, put, delete)
                data : JSON.stringify({
                  'tweet': tweet
                }), // data in json format
                async : false, // enable or disable async (optional, but suggested as false if you need to populate data afterwards)
                contentType: 'application/json;charset=UTF-8',
                success: function(response, textStatus, jqXHR) {
                  console.log(response)
                  if (response.sentiment==-1) {
                    sentiment = -1
                  } else if (response.sentiment==0) {
                    sentiment = 0
                  } else {
                    sentiment = 1
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
            $('#myform')[0].reset();
            if (sentiment == -1) {  
              $('#kata').text(tweet).show();            
              $("#sent-positive").hide();
              $("#sent-netral").hide();
              $("#sent-negative").show();
            } else if (sentiment == 0) {
              $('#kata').text(tweet).show();
              $("#sent-positive").hide();
              $("#sent-netral").show();
              $("#sent-negative").hide();
            } else if (sentiment == 1) {
              $('#kata').text(tweet).show();
              $("#sent-positive").show();
              $("#sent-netral").hide();
              $("#sent-negative").hide();
            } else {
              $("#sent-positive").show();
              $("#sent-netral").show();
              $("#sent-negative").show();
            }
        }
      });
    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>


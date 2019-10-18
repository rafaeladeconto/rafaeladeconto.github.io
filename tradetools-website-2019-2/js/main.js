$(document).ready(function() {

    $(".process .tabs-container .tab p").hide();
    $(".process .tabs-container .tab-1 p").show();

    $(".process-container .tabs-container .tab").click(function() {
        var tabNumber = $(this).attr('id');
        $(this).siblings().removeClass('-active');
        $(this).addClass('-active');

        $(this).find("p").slideDown(300);
        $(".process .tabs-container .tab").not(this).find("p").slideUp(300);

        $(".process-container .image .tab-screen-" + tabNumber).siblings().removeClass('-active');
        $(".process-container .image .tab-screen-" + tabNumber).addClass('-active');
    });

    $(".benefits-menu .benefits-item").click(function() {
        var compositionNumber = $(this).attr('id');
        $(this).siblings().removeClass('-active');
        $(".benefits-content #composition-" + compositionNumber).siblings().removeClass('-active');
        $(this).addClass('-active');
        $(".benefits-content #composition-" + compositionNumber).addClass('-active');
    });

    $('a[href*="#"]').on('click', function(e) {
        e.preventDefault()
      
        $('html, body').animate(
          {
            scrollTop: $($(this).attr('href')).offset().top,
          },
          700,
          'swing'
        )
      })

    	/* Toggle Video Modal
  -----------------------------------------*/
	function toggle_video_modal() {
	    
	    // Click on video thumbnail or link
	    $(".js-trigger-video-modal").on("click", function(e){
          
          // prevent default behavior for a-tags, button tags, etc. 
	        e.preventDefault();
        
          // Grab the video ID from the element clicked
          var id = $(this).attr('data-youtube-id');

          // Autoplay when the modal appears
          // Note: this is intetnionally disabled on most mobile devices
          // If critical on mobile, then some alternate method is needed
          var autoplay = '?autoplay=1';

          // Don't show the 'Related Videos' view when the video ends
          var related_no = '&rel=0';

          // String the ID and param variables together
          var src = '//www.youtube.com/embed/'+id+autoplay+related_no;

          if ($(".js-trigger-video-modal").hasClass("js-video-subtitles")) {
            src = src+'&cc_lang_pref=pt-BR&cc_load_policy=1';
          }
          
          // Pass the YouTube video ID into the iframe template...
          // Set the source on the iframe to match the video ID
          $("#youtube").attr('src', src);
          
          // Add class to the body to visually reveal the modal
          $("body").addClass("show-video-modal noscroll");
	    
      });

	    // Close and Reset the Video Modal
      function close_video_modal() {
        
        event.preventDefault();

        // re-hide the video modal
        $("body").removeClass("show-video-modal noscroll");

        // reset the source attribute for the iframe template, kills the video
        $("#youtube").attr('src', '');
        
      }
      // if the 'close' button/element, or the overlay are clicked 
	    $('body').on('click', '.close-video-modal, .video-modal .overlay', function(event) {
	        
          // call the close and reset function
          close_video_modal();
	        
      });
      // if the ESC key is tapped
      $('body').keyup(function(e) {
          // ESC key maps to keycode `27`
          if (e.keyCode == 27) { 
            
            // call the close and reset function
            close_video_modal();
            
          }
      });
	}
	toggle_video_modal();
  });

  $(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
       $('.header-wrapper').addClass('-scrolled');
    } else {
       $('.header-wrapper').removeClass('-scrolled');
    }
})

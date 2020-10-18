
// -------------------------------------------
// CLASSES
// -------------------------------------------

function App () {
  this.mode = "navigation";
  this.videoWidth = null;
  this.videoHeight = null;

  this.player;
  this.colLeft = $(".column#left");
  this.colHome = $(".column#home");
  this.colChannel1 = $(".column#channel-1");
  this.colChannel2 = $(".column#channel-2");
  this.colChannel3 = $(".column#channel-3");

  this.home = function () { 
    this.colHome.removeClass("closed").addClass("expanded");
    this.colChannel1.removeClass("closed").removeClass("expanded");
    this.colChannel2.removeClass("closed").removeClass("expanded");
    this.colChannel3.removeClass("closed").removeClass("expanded");
  }

  this.channels = function (ids) { 
    this.colHome.removeClass("expanded").addClass("closed");
    this.colChannel1.removeClass("closed").removeClass("expanded");
    this.colChannel2.removeClass("closed").removeClass("expanded");
    this.colChannel3.removeClass("closed").removeClass("expanded");
    ids.forEach(function (e, i) {
      $(".column#"+ e).addClass("expanded");
    });
  }

  this.setMode = function (newMode) {
    var prevMode = this.mode;
    if (prevMode == newMode) {
      return;
    }
    var availableModes = ["navigation", "watching"];
    if (!availableModes.includes(newMode)) {
      throw new Error('Unknown mode: '+ newMode);
    }
    this.mode = newMode;
    if (this.mode == "navigation") {
      $("body").removeClass("watching");
      $("#bg-video").css({ "transform": "scale("+ this.scaleFactor +")" });
    } else if (this.mode == "watching") {
      $("body").addClass("watching");
      $("#bg-video").css({ "transform": "scale(1)" });
      this.player.play();
    }
  }

  this.initBgVideo = function (additionalOptions) {

    var options = {
        // id: 458126085,
        // autoplay: true,
        muted: true,
        // currentTime: 60,
        width: $(window).width(),
        height: $(window).height(),
        title: false,
        byline: false,
        portrait: false,
        loop: true,
        color: "#8197FF",
        controls: false
    };

    if (additionalOptions) {
      Object.assign(options, additionalOptions);
    }

    // Create bg video

    // Will create inside the made-in-ny div:
    // <iframe src="https://player.vimeo.com/video/59777392?loop=1" width="640" height="360" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
    this.player = new Vimeo.Player('bg-video', options);
    // $("body").click();
    // this.player.setCurrentTime(70);
    
    var that = this;
    this.player.getVideoWidth().then(function (w) {
      that.videoWidth = w;
      that.player.getVideoHeight().then(function (h) {
        that.videoHeight = h;

        var w = $(window).width();
        var h = $(window).height();
        var screenRatio = w/h;
        var videoRatio = that.videoWidth/that.videoHeight;
        if (screenRatio > videoRatio) {
          that.scaleFactor = that.videoWidth/w;
        } else {
          that.scaleFactor = that.videoHeight/h;
        }
        if (that.mode == "navigation") {
          $("#bg-video").css({ "transform": "scale("+ that.scaleFactor +")" });
        }

      });
    });


    this.player.play();

  }

  this.handleResize = function () {
    var that = this;
    this.player.getCurrentTime().then(function (time) {
      that.player.getVideoId().then(function (id) {
        debugger;
        that.player.destroy();
        that.initBgVideo({"id": id});
        that.player.setCurrentTime(time);
      });
    });

  }
}



// -------------------------------------------
// FUNCTIONS
// -------------------------------------------

// -------------------------------------------
// EVENTS
// -------------------------------------------

$(window).resize(function () {
  a.handleResize();
});

// -------------------------------------------
// KEY BINDINGS
// -------------------------------------------

document.addEventListener('keyup', function (event) {
  if (event.defaultPrevented) {
    return; 
  }
  var key = event.key || event.keyCode;
  if (key === 'Escape' || key === 'Esc' || key === 27) {
    a.setMode("navigation");
  }
});

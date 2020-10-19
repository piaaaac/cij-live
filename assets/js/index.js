
// -------------------------------------------
// CLASSES
// -------------------------------------------

function App () {
  this.mode = "navigation";
  this.videoWidth = null;
  this.videoHeight = null;
  this.videoId = null;
  this.videoTitle = null;
  this.currentChannel = null;

  this.isPaused = false;
  this.isFullscreen = false;

  this.player;
  this.videoContainer = $("#bg-video");
  this.colHome = $("#home");
  this.colChannels = $(".column[id^='channel-']");

  this.home = function () { 
    this.colChannels.removeClass("expanded");
    $("body").removeClass("schedule-open");
  }

  this.toggleSchedule = function (id) { 
    var thisCol = $(".column#"+ id);

    if (thisCol.hasClass("expanded")) {
      // thisCol.removeClass("expanded");
      this.home();
    } else {
      this.colChannels.removeClass("expanded");
      thisCol.addClass("expanded");
    }

    var anyChannelOpen = $(".column[id^='channel-'].expanded").length > 0;
    $("body").toggleClass("schedule-open", anyChannelOpen);
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

      this.player.setMuted(true);
      $("body").removeClass("watching");
      this.videoContainer.css({ "transform": "scale("+ this.scaleFactor +")" });
      this.player.pause();
      this.isPaused = true;

    } else if (this.mode == "watching") {

      this.player.setMuted(false);
      $("body").addClass("watching");
      this.videoContainer.css({ "transform": "scale(1)" });
      this.player.play();
      this.isPaused = false;

    }
  }

  this.initBgVideo = function (id, title, channelNum, startWatching) {

    var options = {
        id: id,
        width: $(window).width(),
        height: $(window).height(),
        muted: true,
        title: false,
        byline: false,
        portrait: false,
        loop: true,
        color: "#8197FF",
        // controls: false,
        // autoplay: true,
        // currentTime: 60,
    };

    // --- Create Vimeo player

    this.player = new Vimeo.Player('bg-video', options);

    // --- Update object & home UI
    
    this.videoId = id;
    this.videoTitle = title;
    this.currentChannel = channelNum;
    $("#home .highlight .title").text(title);
    $("#now-playing-small .title").text(title);
    $(".small-channel-num").text(channelNum);
    $("[id^='channel-'] .title").removeClass("active");
    $("#channel-"+ channelNum +" .title").addClass("active");

    // --- Reset sizes

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
          that.scaleFactor = screenRatio/videoRatio;
        } else {
          that.scaleFactor = videoRatio/screenRatio;
        }
        if (that.mode == "navigation") {
          that.videoContainer.css({ "transform": "scale("+ that.scaleFactor +")" });
        }

        if (that.mode == "watching") {
          that.setMuted(false);
        }

        that.player.play();
        that.isPaused = false;

        if (startWatching) {
          that.setMode("watching");
          that.home();
        }

      });
    });
  }

  this.changeVideo = function (id, title, channelNum, startWatching) {
    this.player.destroy();
    this.initBgVideo(id, title, channelNum, startWatching);
  }

  this.handleResize = function () {
    if (this.isFullscreen) {
      return;
    }
    var that = this;
    this.player.getCurrentTime().then(function (time) {
      that.player.destroy();
      that.initBgVideo(that.videoId, that.videoTitle, that.currentChannel);
      that.player.setCurrentTime(time);
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

$("iframe").click(function () {
  setTimeout(function () {
    console.log(this);
    a.videoContainer.focus();
  }, 100);
});

// -------------------------------------------
// KEY BINDINGS
// -------------------------------------------

document.addEventListener('keyup', function (event) {
  if (event.defaultPrevented) {
    return; 
  }
  var key = event.key || event.keyCode;

  // console.log("hit", key);

  // --- ESC

  if (key === 'Escape' || key === 'Esc' || key === 27) {
    if (this.isFullscreen) {
      a.isFullscreen = false;
      a.exitFullscreen();
    } else {
      a.setMode("navigation");
    }
  }

  // --- SPACE

  if (key === 'Space' || key === ' ' || key === 32) {
    a.isPaused = !a.isPaused;
    if (a.isPaused) {
      a.player.pause();
    } else {
      a.player.play();
    }
  }

  // --- F

  if (key === 'f' || key === 70) {
    a.isFullscreen = true;
    a.player.requestFullscreen();
  }

  // --- Enter

  if (key === 'Enter' || key === 13) {
    a.setMode("watching");
  }

});















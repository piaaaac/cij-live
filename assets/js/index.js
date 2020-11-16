
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
$('body').removeClass('xs-menu-open');
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
    $("#now-playing-watching .title").text(title);
    $(".small-channel-num").text(channelNum);
    $(".watching-channel-num").text(channelNum);
    $("[id^='channel-'] .title").removeClass("active");
    $("#channel-"+ channelNum +" .title").addClass("active");

    var label = this.defaultOrangeLabel;
    if (this.liveStream.isActive && channelNum == this.liveStream.channelNum) {
      label = this.liveStream.orangeLabel;
    }
    $(".orange-label").text(label);

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
// if (startWatching) {  }
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

  this.toggleAbout = function (show) {
    var doShow;
    if (show === false) { 
      doShow = false; 
    } else if (show === true) {
      doShow = true;
    } else {
      doShow = !$("body").hasClass("about");
    }
    $("body").toggleClass("about", doShow);
  }

  this.toggleMobMenu = function () {
    var isOpening = !$('body').hasClass('xs-menu-open');
    if (isOpening) {
      if (this.mode == "watching") {
        this.setMode("navigation");
      }
      $('body').addClass('xs-menu-open');
    }
    if (!isOpening) {
      this.setMode("watching");
      $('body').removeClass('xs-menu-open');
    }
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

$("a[data-toggle-desc]").click(function () {
  var id = $(this).attr("data-toggle-desc");
  var desc = $("#"+ id);
  var doOpenThis = !desc.hasClass("open");

  $(".description.open").removeClass("open").slideUp(200);
  $("a[data-toggle-desc].open").removeClass("open");
  if (desc.hasClass("open") && !doOpenThis) {
    desc.removeClass("open").slideUp(200);
    $(this).removeClass("open");
  }
  if (!desc.hasClass("open") && doOpenThis) {
    desc.addClass("open").slideDown(200);
    $(this).addClass("open");
  }
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
      a.toggleAbout(false);
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

  // --- 1 2 3 4 5

  if (key === '1' || key === 49) {
    $("#channel-1 .title").click();
  }
  if (key === '2' || key === 50) {
    $("#channel-2 .title").click();
  }
  if (key === '3' || key === 51) {
    $("#channel-3 .title").click();
  }
  if (key === '4' || key === 52) {
    $("#channel-4 .title").click();
  }
  if (key === '5' || key === 53) {
    $("#channel-5 .title").click();
  }

});


function icon (num) {
  // var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
  // link.type = 'image/x-icon';
  // link.rel = 'shortcut icon';
  // link.href = '/assets/favicon/'+ num +'/';
  // document.getElementsByTagName('head')[0].appendChild(link);

  var selectors = [
    { sel: "link[rel='apple-touch-icon'][sizes='57x57']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='60x60']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='72x72']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='76x76']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='114x114']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='120x120']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='144x144']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='152x152']", attr: "href" },
    { sel: "link[rel='apple-touch-icon'][sizes='180x180']", attr: "href" },
    { sel: "link[rel='icon'][sizes='192x192']", attr: "href" },
    { sel: "link[rel='icon'][sizes='32x32']", attr: "href" },
    { sel: "link[rel='icon'][sizes='96x96']", attr: "href" },
    { sel: "link[rel='icon'][sizes='16x16']", attr: "href" },
    { sel: "link[rel='manifest']", attr: "href" },
    { sel: "meta[name='msapplication-TileImage']", attr: "content" },
  ];

  selectors.forEach(function (e, i) {
    var tag = $(e.sel);
    var currentValue = tag.attr(e.attr);
    // console.log(e.sel, e.attr, currentValue);
    var newValue = currentValue.replace(/favicon\/([0-9])\//g, "favicon/"+ num +"/");
    console.log(newValue);
    tag.attr(e.attt, newValue);

  });
  // $("link[rel='apple-touch-icon'][sizes='57x57']")     href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-57x57.png">
  // $("link[rel='apple-touch-icon'][sizes='60x60']")     href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-60x60.png">
  // $("link[rel='apple-touch-icon'][sizes='72x72']")     href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-72x72.png">
  // $("link[rel='apple-touch-icon'][sizes='76x76']")     href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-76x76.png">
  // $("link[rel='apple-touch-icon'][sizes='114x114']")   href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-114x114.png">
  // $("link[rel='apple-touch-icon'][sizes='120x120']")   href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-120x120.png">
  // $("link[rel='apple-touch-icon'][sizes='144x144']")   href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-144x144.png">
  // $("link[rel='apple-touch-icon'][sizes='152x152']")   href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-152x152.png">
  // $("link[rel='apple-touch-icon'][sizes='180x180']")   href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-180x180.png">
  // $("link[rel='icon'][sizes='192x192']")               href="<?= $kirby->url('assets') ?>/favicon/1/android-icon-192x192.png">
  // $("link[rel='icon'][sizes='32x32']")                 href="<?= $kirby->url('assets') ?>/favicon/1/favicon-32x32.png">
  // $("link[rel='icon'][sizes='96x96']")                 href="<?= $kirby->url('assets') ?>/favicon/1/favicon-96x96.png">
  // $("link[rel='icon'][sizes='16x16']")                 href="<?= $kirby->url('assets') ?>/favicon/1/favicon-16x16.png">
  // $("link[rel='manifest']")                            href="<?= $kirby->url('assets') ?>/favicon/1/manifest.json">
  // $("meta[name='msapplication-TileImage']")            content="<?= $kirby->url('assets') ?>/favicon/1/ms-icon-144x144.png">
  // $("meta[name='theme-color']")                        content="#ffffff">

}












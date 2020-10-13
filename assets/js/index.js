
var a = new App();
a.init();

// -------------------------------------------
// CLASSES
// -------------------------------------------

function App () {
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

  this.init = function () {

    // Create bg video

    var options = {
        id: 458126085,
        autoplay: true,
        muted: true,
        // width: $(window).width(),
        height: $(window).height(),
        title: false,
        byline: false,
        portrait: false,
        loop: true
    };

    // Will create inside the made-in-ny div:
    // <iframe src="https://player.vimeo.com/video/59777392?loop=1" width="640" height="360" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
    var playerBg = new Vimeo.Player('bg-video', options);
    $("body").click();
    playerBg.play();


  }


}

// -------------------------------------------
// FUNCTIONS
// -------------------------------------------

// -------------------------------------------
// EVENTS
// -------------------------------------------

// -------------------------------------------
// KEY BINDINGS
// -------------------------------------------

document.addEventListener('keyup', function (event) {
  // if (event.defaultPrevented) {
  //   return; 
  // }
  // var key = event.key || event.keyCode;
  // if (key === 'Escape' || key === 'Esc' || key === 27) {
  //   a.closeDetail();
  // }
});

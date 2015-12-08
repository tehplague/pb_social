$(document).ready(function() {
    $("a.likes,a.comments,a.plus,a.replies").click(function(){
        window.open(this.href,"_blank","width=1200,height=800");
        $("#jplayer-bg").jPlayer('stop');
        $("#speaker-btn").removeClass("icon-speaker-on").addClass("icon-speaker-off");
        return false; });

    $(".social-list-item .image, .social-list-item img, .social-list-item .text").click(function(e){
        var _Url = $(this).closest(".social-list-item").data("url");
        window.open(_Url,"_blank","width=1200,height=800");
        $("#jplayer-bg").jPlayer('stop');
        $("#speaker-btn").removeClass("icon-speaker-on").addClass("icon-speaker-off");
        return false;
    });

    window.onscroll = function() {
        if ((window.innerHeight + $(window).scrollTop()) >= document.body.offsetHeight) {
            // reached bottom of page
            var _LeftColItems = $(".social-list .col-left .hidden");
            var _RightColItems = $(".social-list .col-right .hidden");
            if(_LeftColItems.length > 0){  _LeftColItems.first().fadeIn("slow", function(){ $(this).removeClass("hidden"); $(window).scroll(); }); }
            if(_RightColItems.length > 0){  _RightColItems.first().fadeIn("slow", function(){ $(this).removeClass("hidden"); $(window).scroll(); }); }
        }
    };

    //
    // FACEBOOK AJAX => LIKES/COMMENTS COUNTER UPDATE
    //
    $(".social-list-item-facebook").each(function(){
        var _PostID = $(this).data("id");

        if($(this).find(".likes").text() == "25"){
            var _LikeLink = $(this).find(".likes");
            $.ajax({ url: "https://graph.facebook.com/"+_PostID+"/likes?limit=5000" }).done(function( data ) {
                _LikeLink.text(data.data.length);
            });
        }
        if($(this).find(".comments").text() == "25"){
            var _CommentLink = $(this).find(".comments");
            $.ajax({ url: "https://graph.facebook.com/"+_PostID+"/comments?limit=5000" }).done(function( data ) {
                _CommentLink.text(data.data.length);
            });
        }
    });
});
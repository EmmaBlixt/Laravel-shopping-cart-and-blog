var postId = 0;

  $(document).ready(function(){
    // show edit post-div when edit button is clicked
        $(".edit").click(function(){
            var $toggle = $(this); 
            $(".edit").hide();
            var id = "#edit-post" + $toggle.data('id'); 
            $( id ).toggle();
        });

        // hide edit post-div when cancel button is clicked
        $(".cancel").click(function(){
            var $toggle = $(this); 
            $(".edit").show();
            var id = "#edit-post" + $toggle.data('id'); 
            $( id ).toggle();
        });
    });


/* Add/remove likes and dislikes onClick*/
$('.like-dislike').on('click', function(event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var isLike = event.target.previousElementSibling == null;
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token}
    })
        .done(function() {
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'You don\'t like this post' : 'Dislike';
            if (isLike) {
                event.target.nextElementSibling.innerText = 'Dislike';
            } else {
                event.target.previousElementSibling.innerText = 'Like';
            }
        });
});
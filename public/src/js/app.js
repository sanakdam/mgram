var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function (event) {
	event.preventDefault();

	postBodyElement = event.target.parentNode.parentNode.parentNode.childNodes[3]
	console.log(postBodyElement);
	var postBody = postBodyElement.textContent;
	postId = event.target.parentNode.parentNode.dataset['postid'];
	$('#post-body').val(postBody);
	$('#edit-modal').modal();
});

$('#modal-save').on('click', function () {
	 $.ajax({
	 	method: 'POST',
	 	url: urlEdit,
	 	data: {body: $('#post-body').val(), postId: postId, _token: token}
	 })
	 .done(function (msg) {
	 	 $(postBodyElement).text(msg['new_body']);
	 	 $('#edit-modal').modal('hide');
	 });
});

$('.like').on('click', function (event) {
	 event.preventDefault();
	 postId = event.target.parentNode.parentNode.dataset['postid'];
	 $.ajax({
	 	method: 'POST',
	 	url: urlLike,
	 	data: {postId: postId, _token: token}
	 })
	 .done(function (response) {

	 	var parse = JSON.parse(response);
	 	var element = event.target.parentNode.parentNode;
	 	$(element).find('.info').find('.like_count').html(parse.like_count + " Like");
        $(element).find('.like').text(parse.action_text);
	 });
});

$('.post').find('.interaction').find('.comment').keypress(function (event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
 	if(keycode == '13'){
 		postId = event.target.parentNode.parentNode.dataset['postid'];
 		commentElement = event.target.parentNode.parentNode.childNodes[4]

 		$.ajax({
		 	method: 'POST',
		 	url: urlComment,
		 	data: {comment_body: $('#comment_body').val(), postId: postId, _token: token}
		 })
 		.done(function (response) {
 			 $(commentElement).text(response['new_comment']);
 		})
 	}
});
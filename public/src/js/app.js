var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function (event) {
	event.preventDefault();

	postBodyElement = event.target.parentNode.parentNode.childNodes[1]
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
         $('.like').text(parse.action_text);
	 });
});

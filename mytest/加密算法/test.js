$("#btnClear").on("click",function(){
	$("#input").val('');
	$("#output").val('');
});

$("#btnEncrypt").on("click",function(){
	encrypt_ajax();
});

$("#btnDecrypt").on("click",function(){
	decrypt_ajax();
});

function encrypt_ajax(){
	$.post( "test.php", {"inputstring": $("#input").val(), "type": "encrypt" ,"is_publickey_encrypt" : "yes"}).done(function( data ) {
		$('#output').val(data);
	});
};

function decrypt_ajax(){
	$.post( "test.php", {"inputstring": $("#input").val(), "type": "decrypt", "is_publickey_encrypt" : "yes"}).done(function( data ) {
		$('#output').val(data);
	});
};
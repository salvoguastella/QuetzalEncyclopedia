var n=0;
$(document).ready(function() {

	$("#categorie li").click(function(){
		if(!$(this).hasClass("selected")){
			$(".box_pacchetti").hide();
			$("#categorie li").removeClass("selected").animate({height:44},300);
			n=$(this).find(".pkg_wrapper").length;
			$(this).addClass("selected").animate({height:44+40*n+20},300,function(){
				$(this).children(".box_pacchetti").fadeIn(300);	
			});
		}
	});
	
	$(".pkg_wrapper").click(function(){
		
		$("#img_pacchetto").attr("src",$(this).children(".pkg_icon").attr("src"));
		$("#nome_pacchetto").text($(this).children(".pkg_name").text());
		
		$.ajax({
			url:"get_words.php",
			data: {pkg:$(this).attr("rel")},
			type: "POST"		
		}).done(function(result){
			$(".box_parole").html(result);	
			$(".box_parole").show();
		});
		//alert($(this).attr("rel"));
		
	});

});
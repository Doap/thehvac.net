/**
	CREDOMATIC VALIDATION
*/
jQuery(function($) {
	
	$("#card_number").payment("formatCardNumber")
								 .bind("input", function(){
									$(this).unbind("keyup");
									validateCreditCardNumber.call(this);
								 }).bind("keyup", function(){
									validateCreditCardNumber.call(this);
								 });
				
	validateCreditCardNumber = function(){
			var cardType = $.payment.cardType($(this).val()); 
			if(cardType != null){
				if(cardType === "amex"){
					$("#cvv_code").attr("maxlength", "4");
				}else{
					$("#cvv_code").attr("maxlength", "3");
				}
			}
	}
	
	$("#cvv_code").numeric({
		allowPlus           : false,
		allowMinus          : false, 
		allowThouSep        : false,  
		allowDecSep         : false, 
		allowLeadingSpaces  : false
	});
	
	$("#card_holder").alpha({
		allowSpace: true,
		allowOtherCharSets : false,
		maxLength : 45 
	}).bind("input", function(){
						$(this).unbind("keyup");
						toUpperCaseCardHolder.call(this);
					  }).bind("keyup", function(){
						toUpperCaseCardHolder.call(this);
					  });
					  
	toUpperCaseCardHolder = function(){
		var str = $(this).val();
		if ( !(str === str.toUpperCase()) ) {
			$(this).val(str.toUpperCase());
		}
	}
			
});
Inputmask.extendAliases({
  'maskFecha': {
	alias: "datetime",  
	autoUnmask: false,
    inputFormat: "yyyy-mm-dd",
	clearIncomplete: true
  }
});

Inputmask.extendAliases({
  'maskEnteroComa': {
    alias: "integer",
	autoUnmask: true,
	groupSeparator: ",",
	placeholder: "",
	autoGroup: true,
	allowPlus: false,
	allowMinus: false,
	positionCaretOnClick: "select"

 }
});

Inputmask.extendAliases({
  'maskEntero': {
    alias: "integer",
	autoUnmask: true,
	groupSeparator: "",
	placeholder: "",
	autoGroup: false,
	allowPlus: false,
	allowMinus: false,
	positionCaretOnClick: "select"

 }
});

Inputmask.extendAliases({
  'maskDecimal2': {
    alias: "numeric",
	autoUnmask: true,
	groupSeparator: ",",
	placeholder: "",
	autoGroup: true,
	digits: 2,
	digitsOptional: true,
	allowPlus: false,
	allowMinus: false,
	positionCaretOnClick: "select"
 }
});

Inputmask.extendAliases({
  'maskMoneda': {
    alias: "integer",
	autoUnmask: true,
	prefix: '$',
	groupSeparator: ",",
	placeholder: "",
	autoGroup: true,
	allowPlus: false,
	allowMinus: false,
	positionCaretOnClick: "select"

  }
});

Inputmask.extendAliases({
  'maskMoneda2': {
    alias: "numeric",
	autoUnmask: true,
	groupSeparator: ",",
	placeholder: "",
	prefix: '$',
	autoGroup: true,
	digits: 2,
	digitsOptional: true,
	allowPlus: false,
	allowMinus: false,
	positionCaretOnClick: "select"

 }
});

function aplicaMask(){
	$(".maskFecha").inputmask("maskFecha",
		{
			onincomplete: function(obj){
				$(this).focus();
			}
		}
	);
	
	$(".maskEnteroComa").inputmask("maskEnteroComa");
	$(".maskEntero").inputmask("maskEntero");
	$(".maskDecimal2").inputmask("maskDecimal2");
	$(".maskMoneda").inputmask("maskMoneda");
	$(".maskMoneda2").inputmask("maskMoneda2");
};

aplicaMask();
	



$(document).ready(function() {
	
	$("select.sensitive").change(function() {
		
		var elementID = $(this).attr('id');
		
		var sensitiveID = $(this).data('sensitive-target');
		var sensitiveTarget = $(this).data('sensitive');
		var tarval = $(this).data('tarval');
		var tartext = $(this).data('tartext');
		//var sensitiveIDFull = "#"+ sensitiveID;
		
		var value = $(this).val();
		var action = "http://sp-kubani.inmtoo.com/index.php/sensitivelists/" + sensitiveTarget + "/?" + elementID +"=" + value; //убрать
		var url = "http://sp-kubani.inmtoo.com/index.php/sensitivelists/" + sensitiveTarget + "/";
		var varget = elementID +"=" + value;
		//$('h1').html(action);
                
		
		//$(this).attr("rel", action + ">>" + sensitiveID);
		
		 if (elementID == '0') {
			$(sensitiveID).html('<option>- выберите -</option>');
			$(sensitiveID).attr('disabled', true);
			return(false);
		}
		
		$(sensitiveID).attr('disabled', true);
		$(sensitiveID).html('<option>загрузка...</option>');
		
		     $.get(
            url,
            varget,
            function (result) {
                /*
                 * В случае неудачи мы получим результат с type равным error.
                 * Если все прошло успешно, то в type будет success,
                 * а также массив regions, содержащий данные по городам
                 * в формате 'id'=>'1', 'title'=>'название города'.
                 */
                if (result.type == 'error') {
                    /*
                     * ошибка в запросе
                     */
                    alert('error');
                    return(false);
                }
                else {
                    /*
                     * проходимся по пришедшему от бэк-энда массиву циклом
                     */
                    var options = '';
                    $(result.SensitiveResult).each(function() {
                        /*
                         * и добавляем в селект по городу
                         */
                       options += '<option value="' + $(this).attr(tarval) + '">' + $(this).attr(tartext) + '</option>';
                       //options += '<option>bgggg</option>';
                    });
                    $(sensitiveID).html(options);
                    $(sensitiveID).attr('disabled', false);
		    $(sensitiveID).attr("rel", "fff");
                }
            },
            "json"
        );
		
		//$('.blue-bg').css('background-color', '#ff0000'); 
		
	});
});



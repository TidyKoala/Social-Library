function ajaxFormSubmit(domObject, selectSelector)
{
    var url_action = domObject.attr('action');
    $.ajax({
        url: url_action,
        type: 'POST',
        data: domObject.serializeArray(),
        success: function(data) {
            if(data.code == 200) {
                $('select' + selectSelector).append('<option value="' + data.id + '">' + data.name + '</option>');
                $(selectSelector).select2("val", data.id);
            }
            else if(data.code == 400) {
                // TODO: display the form error message
                //alert(data.error);
            }
        },
        error: function(data) {
        }
    });
}

function ajaxGetForm(domObject) {
    var url_post = domObject.attr('data-request');
    $.ajax({
        url: url_post,
        success: function(data) {
        	domObject.popover({
                html: true,
                content: data
            }).popover('show');
            $('.ajax-submit').submit(function() {
                ajaxFormSubmit( $(this), domObject.attr('data-select'));
            	domObject.popover('destroy');
            	
                return false;
            });
        }
    });
    return false;
}
$('body').on('focus', ".autocomplete", function () {
  var listId = $(this).attr('list');
  var fieldId = $(this).attr('id');
  $( this ).autocomplete({
    source: function( request, response, event) {
      $.ajax( {
        url: "autocomplete.php",
        dataType: "json",
        data: {
          term: request.term,
          list: listId,
        },
        success: function( data ) {
          response( data );
        }
      } );
    },
    minLength: 2,
    select: function( event, ui ) {
      $('#'+fieldId).attr('value', ui.item.id);
      $('#'+fieldId).val(ui.item.value);
      $('#'+fieldId).prop( "disabled", true );
      $('#'+fieldId).after('<span class="remove" parent="' + fieldId + '"><a href="#">remove</a></span>');
    }
  });
});

$('body').on('click', 'span.remove', function() {
  var fieldId = $(this).attr('parent');
  $('#'+fieldId).prop( "disabled", false );
  $('#'+fieldId).attr("value","");
  $('#'+fieldId).attr("humanvalue","");
  $('#'+fieldId).val('');
  $(this).remove();
  
});


$('#deleteBtn').click(function() {
  $('.spinnerbox').show();
  console.log("Delete");
  var data = getDeleteData();
  if(data.getAll('id').length === 0) {
    $('.spinnerbox').css('display','none');
    alert('keine Elemente zum Löschen angegeben');
  }
  else {
    $.ajax({
      method: "POST",
      url: "deleteItem.php",
      dataType: 'text', 
      cache: false,
      contentType: false,
      processData: false,
      data: data,
    })
    .done(function( msg ) {
      location.reload();
      console.log( msg );
    });
  }
});

var getDeleteData = function() {
  var form_data = new FormData();
  $('.checker:checkbox:checked').each( function(index) {
    form_data.append('id', $( this ).attr('id'));
  });
  return form_data;
}

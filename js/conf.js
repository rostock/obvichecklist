$('.btnOpenModal').click(function() {
  $("#confModal").modal("show");
  $(this).closest('tr').find('td').each(function(){
    
    if($(this).attr('col')) {
      $('#' + $(this).attr('col') ).val($(this).text());
    }
  });
})

$('#saveConfigBtn').click(function() {
  $('.spinnerbox').show();
  $.ajax({
    method: "POST",
    url: "updateConf.php",
    dataType: 'text', 
    cache: false,
    contentType: false,
    processData: false,
    data: getConfData(),
  })
  .done(function( msg ) {
    $('.spinnerbox').show();
    location.reload();
    console.log( msg );
  });
});

var getConfData = function() {
  var form_data = new FormData();
  var type = $('#confTable').attr('type');
  $( ".modalInput" ).each(function() {
    var data = {
      value: $( this ).val()
    };  
    var dataString = JSON.stringify(data);
    form_data.append($( this ).attr('id'), dataString);
  });
  var data = {
    value: type
  };
  
  var dataString = JSON.stringify(data);
  form_data.append('entitytype', dataString);
  return form_data;
}


$('#confModal').on('hidden.bs.modal', function (e) {
  $('.modalInput').val('');
})
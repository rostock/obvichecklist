 /*
 * Ajax function to add a ticket to the projectmanagement.
 */
$('#createIssueBtn').click(function() {
  $('.spinnerbox').show();
  console.log("Create");
  if($('#1').val() === '') {
    $('.spinnerbox').css('display','none');
    alert('Bitte K-Nummer angeben');
  } else {
    getData();
    $.ajax({
      method: "POST",
      url: "createItem.php",
      dataType: 'text', 
      cache: false,
      contentType: false,
      processData: false,
      data: getData(),
    })
    .done(function( msg ) {
      $('.spinnerbox').show();
      location.reload();
      console.log( msg );
    });
  }
}); 

$('#updateIssueBtn').click(function() {
  console.log("Update");
  $('.spinnerbox').show();
  if($('#1').val() === '') {
    $('.spinnerbox').css('display','none');
    alert('Bitte K-Nummer angeben');
  } else {
    getData();
    $.ajax({
      method: "POST",
      url: "updateItem.php",
      dataType: 'text', 
      cache: false,
      contentType: false,
      processData: false,
      data: getData(),
    })
    .done(function( msg ) {
      $('.spinnerbox').hide();
      location.reload();
      console.log( msg );
    });
  }
}); 

var getData = function() {
  var form_data = new FormData();
  $( ".form-control" ).each(function() {
    
    var val = "";
    var value = "";
    var id = $( this ).attr('id').replace("comment_", "");
    var type = $( this ).attr('kind');
    var list = $( this ).attr('list'); 
    if (type === 'autocomplete' ) {
      val = $( this ).val(); //bewusste Änderung der Variable
      value = $( this ).attr('value'); //bewusste Änderung der Variable
    } else {
      val =  $( this ).attr('value'); //bewusste Änderung der Variable
      value = $( this ).val();//bewusste Änderung der Variable
    }
    
    var data = {
      id: id,
      type: type,
      list: list,
      value: value,
      val: val,
    };    
    var dataString = JSON.stringify(data);
    form_data.append($( this ).attr('id'), dataString);
    
  });
  return form_data;
}

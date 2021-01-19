/*
 * init
 * Funktionen die das Erscheinungsbild gleich beim Laden anpassen
 */
$('.formElement').css('display','none');
$('.formElement[fieldCategory=""]').css('display','');
$(".formElement[fieldCategory='Stammdaten']").addClass('active');
$(".formElement[fieldCategory='Stammdaten']").css('display','');
$("li[fieldCategory='Stammdaten']").addClass('active');
$('#sectionTitel').html('Stammdaten');
$('.autocomplete').each(function(){
  $(this).val($(this).attr('humanvalue'));
})


//Function Breadcrumb switcher
$('li.breadcrumbs').click(function() {
  var fieldCategory = $(this).attr('fieldCategory');
  $('#sectionTitel').html($(this).attr('title'));
  $('li.active').removeClass('active');
  $(this).addClass('active');
  $('.formElement.active').css('display','none');
  $('.formElement.active').removeClass('active');
  $("div[fieldCategory='" + fieldCategory + "']").addClass('active');
  $(".formElement[fieldCategory='" + fieldCategory + "']").css('display','');
})
/*
 * Funktion der Buttons Vor und Zurück
 */
$('li.btnNext, li.btnPrevious').click(function() {
  var index = $('li.breadcrumbs.active').index();
  if($(this).hasClass('btnPrevious')  && !$('li.breadcrumbs.active').is(':first-child')) {
    $('li.breadcrumbs').eq(index).removeClass('active');
    $('li.breadcrumbs').eq(index - 1).addClass('active');
  }
  if($(this).hasClass('btnNext')  && !$('li.breadcrumbs.active').is(':last-child')) {
    $('li.breadcrumbs').eq(index).removeClass('active');
    $('li.breadcrumbs').eq(index + 1).addClass('active');
  }
  if($('li.breadcrumbs.active').is(':last-child')) {
    $('li.btnNext').addClass('disabled');
  } else {
    $('li.btnNext').removeClass('disabled');
  }
  if($('li.breadcrumbs.active').is(':first-child')) {
    $('li.btnPrevious').addClass('disabled');
  } else {
    $('li.btnPrevious').removeClass('disabled');
  }
  
  $('#sectionTitel').html($('li.breadcrumbs.active').attr('title'));
  
  var fieldCategory = $('li.breadcrumbs.active').attr('fieldCategory');
  
  $('.formElement.active').css('display','none');
  $('.formElement.active').removeClass('active');
  $(".formElement[fieldCategory='" + fieldCategory + "']").addClass('active');
  $(".formElement[fieldCategory='" + fieldCategory + "']").css('display','');
})


// zeigt die textarea an oder eben nicht
$('.selectBox').on('change', function() {
  
  var taIDs = $(this).attr('changeattr').split(',');
  var index = (parseInt($(this).children('option:selected').index()) + 1).toString();
  
  if(taIDs.includes(index)) {
    //make the textare visible
    $(this).closest('.inputField').find('textarea').css('display','');
  } else {
    $(this).closest('.inputField').find('textarea').css('display','none');
    $(this).closest('.inputField').find('textarea').val('');
  }
  initSummaryValues();
});


//Change view between "zusammenfassung" and "bearbeitunsansicht"
$('.view').click(function() {
  $('.view.deactive').removeClass('deactive');
  
  if ($('#breadcrumb').hasClass('deactive')) {
    $('#breadcrumb').removeClass('deactive');
    $('#filter').addClass('deactive');
    var fieldCategory = $('li.breadcrumbs.active').attr('fieldCategory');
    $('#sectionTitel').html($('li.breadcrumbs.active').attr('title'));
    $('.formElement.active').css('display','none');
    $('.formElement.active').removeClass('active');
    $(".formElement[fieldCategory='" + fieldCategory + "']").addClass('active');
    $(".formElement[fieldCategory='" + fieldCategory + "']").css('display','');
  } else { 
    initSummaryValues();
    $('#filter').removeClass('deactive');
    $('#breadcrumb').addClass('deactive');
    $('.formElement').addClass('active');
    $('.formElement').css('display','');
    $('#sectionTitel').html("Filteransicht");
  }
  $(this).addClass('deactive');
});

$('.filterAttr').change(function() {
  
  var filterValue = $(this).attr('name');
  
  if($(this).prop('checked')) {
    $(".selectBox").each(function() {
      if($(this).val() === filterValue) {
        $(this).closest('.formElement').addClass('active');
        $(this).closest('.formElement').css('display','');
      }
    });
  } else {
    $(".selectBox").each(function() {
      if($(this).val() === filterValue) {
        $(this).closest('.formElement').removeClass('active');
        $(this).closest('.formElement').css('display','none');
      }
    });
  }
})

var initSummaryValues = function () {
  var count = {};
  $( ".filterAttr" ).each(function(  ) {
    count[$( this ).attr('name')] = $(".selectBox option[value='" + $( this ).attr('name') + "']:selected").length;
  });
  
  $( ".summarySpan" ).each(function(  ) {
    $(this).text(count[$(this).attr('name')]);
  });
}

//init again
initSummaryValues();
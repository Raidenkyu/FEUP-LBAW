$('.color-picker').click(function(event){
  let colorSelected = document.querySelector('.color-selected');
  if(this != colorSelected){
    $(colorSelected).removeClass("color-selected");
    $(this).addClass("color-selected");
    $('#color-selected-hidden').val(getColor($('.color-picker').index(this)));
  }
});

function getColor(id){
  var colors = ['Orange', 'Yellow', 'Red', 'Green', 'Lilac', 'Sky', 'Brown', 'Golden', 'Bordeaux', 'Emerald', 'Purple', 'Blue'];
  return colors[id];
}

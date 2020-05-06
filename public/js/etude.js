$('#add-image').click(function(){
    //recuperation du nombre de form group
    const index = +$('#widgets-counter').val();

    //les protype des entrees
    const tmpl = $('#etude_imageEtudes').data('prototype').replace(/__name__/g, index);

    //injection du tmpl dans la div
    $('#etude_imageEtudes').append(tmpl);

    $('#widgets-counter').val(index + 1);

    //gestion du bouton suprimer
    handleDeleteButtons();
});
function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
       // console.log(target);
        $(target).remove();
    })
}
function updateCounter() {
    const count = +$('#etude_imageEtudes div.form-group').length;
    $('#widgets-counter').val(count);
}
updateCounter();
handleDeleteButtons();

CKEDITOR.replace( 'etude_contenu', {
    extraPlugins: 'chart'
  } );